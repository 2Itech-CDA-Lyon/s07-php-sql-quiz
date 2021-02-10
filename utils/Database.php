<?php

class Database
{
    private PDO $databaseHandler;

    function __construct()
    {
        $this->databaseHandler = new PDO('mysql:dbname=php_quiz;host=127.0.0.1', 'root', 'root');
        $this->databaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function fetchFromTableById(string $tableName, int $id): PDOStatement
    {
        return $this->fetchFromTableWhere($tableName, [ 'id' => $id ]);
    }

    function fetchFromTableWhere(string $tableName, array $criteria): PDOStatement
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

        // Renvoie le gestionnaire de requête
        return $statement;
    }
}
