<?php

// Si on arrive sur ce fichier par une méthode autre que POST, renvoie un code d'erreur
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo('Cannot ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);
    die();
}

// Si toutes les données du formulaire sont présentes
if (isset($_POST['question-text']) && isset($_POST['question-count'])) {
    
    // Crée une connexion à la bonne de données
    $databaseHandler = new PDO('mysql:dbname=php_quiz;host=127.0.0.1', 'root', 'root');
    $databaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prépare une requête d'insertion
    $statement = $databaseHandler->prepare('INSERT INTO `question` (`text`, `order`) VALUES (:text, :order);');
    // Exécute la requête en remplaçant les champs variables par le contenu du formulaire
    $statement->execute([
        ':text' => $_POST['question-text'],
        ':order' => $_POST['question-count'] + 1,
    ]);

    // Redirige vers la page du mode création
    header('Location: /create.php');

// Sinon, c'est que l'utilisateur est arrivé sur cette page par un autre moyen que le formumaire dédié
} else {
    http_response_code(400);
    echo('Invalid form data');
}
