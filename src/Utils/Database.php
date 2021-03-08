<?php

namespace App\Utils;

use PDO;
use App\Interfaces\ActiveRecordModel;

/**
 * Handles all communication with the database
 */
class Database
{
    /**
     * Single and only instance of Database
     * @var Database
     * @static
     */
    private static Database $instance;

    /**
     * Instance of PHP database interface
     * @var PDO
     */
    private PDO $databaseHandler;

    /**
     * Create new database handler
     * 
     * Made private to prevent any instanciation from outside processes as part of the Singleton design pattern
     */
    private function __construct()
    {
        $this->databaseHandler = new PDO('mysql:dbname=php_quiz;host=127.0.0.1', 'root', 'root');
        $this->databaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Get single and only instance of Database
     *
     * @return Database
     * @static
     */
    public static function getInstance(): Database
    {
        // S'il n'existe pas encore d'instance de Database en mémoire, en crée une
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }

        // Renvoyer l'unique instance de Database en mémoire
        return self::$instance;
    }

    /**
     * Fetch resource from database based on ID
     *
     * @param string $className Class to return objects as
     * @param integer $id ID of the resource to fetch
     */
    public function fetchFromTableById(string $className, int $id)
    {
        // Récupère l'ensemble des enregistrements ayant l'ID demandé en bas e de données
        $result = $this->fetchFromTableWhere($className, [ 'id' => $id ]);

        // Si aucun enregistrement ne correspond, renvoie null
        if (empty($result)) {
            return null;
        }

        // Sinon, puisque les ID sont uniques, il ne peut y avoir qu'un seul résultat:
        // renvoie ce résultat
        return $result[0];
    }

    /**
     * Fetch collection of resources from database based on criteria
     *
     * @param string $className Class to return objects as
     * @param array $criteria Criteria to be satisfied as collection of key/values
     * @return array
     */
    public function fetchFromTableWhere(string $className, array $criteria): array
    {
        $tableName = $className::getTableName();
        // Construit la requête préparée avec le nom de la table...
        $query = 'SELECT * FROM `' . $tableName . '` ';
        // ...puis tous les critères de filtrage
        foreach ($criteria as $key => $value) {
            $query .= 'WHERE `' . $key . '` = :' . $key;
        }
        // Prépare la requête
        $statement = $this->databaseHandler->prepare($query);

        // Exécute la requête en remplaçant tous les champs variables par leur valeur
        foreach ($criteria as $key => $value) {
            $params [':' . $key]= $value;
        }
        $statement->execute($params);

        // Récupère tous les résultats de la requête sous forme d'objets
        // de la classe spécifiée en paramètres
        $result = $statement->fetchAll(PDO::FETCH_FUNC,
            function (...$params) use ($className) {
                return new $className(...$params);
            }
        );

        // Renvoie le gestionnaire de requête
        return $result;
    }

    /**
     * Fetch all resources from database
     *
     * @param string $className Class to return objects as
     * @return array
     */
    public function fetchAllFromTable(string $className) : array
    {
        $tableName = $className::getTableName();

        $query = 'SELECT * FROM `'. $tableName .'`';

        $statement = $this->databaseHandler->query($query);

        $result = $statement->fetchAll(
            PDO::FETCH_FUNC,
            function (...$params) use ($className)
            {
                return new $className(...$params);
            }
        );

        return $result;
    }

    /**
     * Create new record based on current object state
     *
     * @param ActiveRecordModel $instance The object from which to create a new record
     * @return integer
     */
    public function insertIntoTable(ActiveRecordModel $instance): int
    {
        // Récupère le nom de la table sur laquelle envoyer la requête
        $className = get_class($instance);
        $tableName = $className::getTableName();

        // Construit la requête à partir du nom de la table et de la liste des propriétés
        $properties = $instance->getProperties();
        $query = 'INSERT INTO `' . $tableName . '` (';
        foreach (array_keys($properties) as $propertyName) {
            $propertyNames []= '`' . $propertyName . '`';
            $valueNames []= ':' . $propertyName;
        }
        $query .= join(', ', $propertyNames);
        $query .= ') ';

        $query .= 'VALUES (';
        $query .= join(', ', $valueNames);
        $query .= ');';

        // Exécute la requête en remplaçant tous les champs variables par les valeurs correspondantes
        $statement = $this->databaseHandler->prepare($query);
        foreach ($properties as $key => $value) {
            $params [':' . $key]= $value;
        }
        $statement->execute($params);

        // Renvoie l'ID de l'objet qui vient d'être créé
        return $this->databaseHandler->lastInsertId();
    }

    /**
     * Update existing record based on current object state
     *
     * @param ActiveRecordModel $instance The object from which to update existing record
     * @return void
     */
    public function updateTable(ActiveRecordModel $instance): void
    {
        // Récupère le nom de la table sur laquelle envoyer la requête
        $className = get_class($instance);
        $tableName = $className::getTableName();

        // Construit la requête à partir du nom de la table et de la liste des propriétés
        $properties = $instance->getProperties();
        $query = 'UPDATE `' . $tableName . '` SET ';
        foreach (array_keys($properties) as $propertyName) {
            $sets []= '`' . $propertyName . '` = :' . $propertyName; 
        }
        $query .= join(', ', $sets);
        $query .= ' WHERE `id` = :id';

        // Exécute la requête en remplaçant tous les champs variables par les valeurs correspondantes
        $statement = $this->databaseHandler->prepare($query);
        foreach ($properties as $key => $value) {
            $params [':' . $key]= $value;
        }
        $params [':id'] = $instance->getId();
        $statement->execute($params);
    }

    /**
     * Delete record associated with a given object from database
     *
     * @param ActiveRecordModel $instance The object associated with the record to be deleted
     * @return void
     */
    public function deleteFromTable(ActiveRecordModel $instance): void
    {
        // Récupère le nom de table du modèle
        $className = get_class($instance);
        $tableName = $className::getTableName();

        // Envoie une requête de suppression en base de données
        $statement = $this->databaseHandler->prepare('DELETE FROM `'. $tableName . '` WHERE `id` = :id');
        $statement->execute([ ':id' => $instance->getId() ]);
    }
}
