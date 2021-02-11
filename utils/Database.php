<?php

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
     * @param string $tableName Table name from which to fetch
     * @param string $className Class to return objects as
     * @param integer $id ID of the resource to fetch
     */
    public function fetchFromTableById(string $tableName, string $className, int $id)
    {
        // Récupère l'ensemble des enregistrements ayant l'ID demandé en bas e de données
        $result = $this->fetchFromTableWhere($tableName, $className, [ 'id' => $id ]);

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
     * @param string $tableName Table name from which to fetch
     * @param string $className Class to return objects as
     * @param array $criteria Criteria to be satisfied as collection of key/values
     * @return array
     */
    public function fetchFromTableWhere(string $tableName, string $className, array $criteria): array
    {
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
     * @param string $tableName Table name from which to fetch
     * @param string $className Class to return objects as
     * @return array
     */
    public function fetchAllTable(string $tableName, string $className) : array
    {
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

    public function insertIntoTable(string $tableName, array $properties): int
    {
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

        $statement = $this->databaseHandler->prepare($query);
        foreach ($properties as $key => $value) {
            $params [':' . $key]= $value;
        }
        $statement->execute($params);

        return $this->databaseHandler->lastInsertId();
    }

    public function updateTable(string $tableName, int $id, array $properties): void
    {
        $query = 'UPDATE `' . $tableName . '` SET ';
        foreach (array_keys($properties) as $propertyName) {
            $sets []= '`' . $propertyName . '` = :' . $propertyName; 
        }
        $query .= join(', ', $sets);
        $query .= ' WHERE `id` = :id';

        $statement = $this->databaseHandler->prepare($query);
        foreach ($properties as $key => $value) {
            $params [':' . $key]= $value;
        }
        $params [':id'] = $id;
        $statement->execute($params);
    }

    public function deleteFromTable(string $tableName, int $id): void
    {
        $statement = $this->databaseHandler->prepare('DELETE FROM `'. $tableName . '` WHERE `id` = :id');
        $statement->execute([ ':id' => $id ]);
    }
}
