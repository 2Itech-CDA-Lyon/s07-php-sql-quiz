<?php

class Database
{
    private PDO $databaseHandler;

    function __construct()
    {
        $this->databaseHandler = new PDO('mysql:dbname=php_quiz;host=127.0.0.1', 'root', 'root');
        $this->databaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function fetchFromTableById(string $tableName, string $className, int $id)
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

    function fetchFromTableWhere(string $tableName, string $className, array $criteria): array
    {
        // Construit la requête préparée avec le nom de la table...
        $query = 'SELECT * FROM `' . $tableName . '` ';
        // :::puis tous les critères de filtrage
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
}
