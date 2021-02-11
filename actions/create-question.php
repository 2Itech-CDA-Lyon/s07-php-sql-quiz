<?php

include '../utils/Database.php';
include '../models/question.php';

// Si on arrive sur ce fichier par une méthode autre que POST, renvoie un code d'erreur
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo('Cannot ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);
    die();
}

// Si toutes les données du formulaire sont présentes
if (isset($_POST['question-text']) && isset($_POST['question-count'])) {

    // Crée un objet à partir du contenu du formulaire
    $question = new Question(
        null,
        $_POST['question-text'],
        $_POST['question-count'] + 1
    );

    // Sauvegarde l'objet en base de données
    $question->insert();
    
    // Redirige vers la page du mode création
    header('Location: /create.php');

// Sinon, c'est que l'utilisateur est arrivé sur cette page par un autre moyen que le formumaire dédié
} else {
    http_response_code(400);
    echo('Invalid form data');
}
