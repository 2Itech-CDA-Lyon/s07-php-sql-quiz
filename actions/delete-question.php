<?php

include '../utils/Database.php';
include '../interfaces/ActiveRecordModel.php';
include '../models/AbstractModel.php';
include '../models/question.php';

// Si on arrive sur ce fichier par une méthode autre que POST, renvoie un code d'erreur
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
echo('Cannot ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);
    die();
}

// Si toutes les données du formulaire sont présentes
if (isset($_POST['question-id'])) {

    // Récupère la question associée à l'ID fourni dans la BDD
    $question = Question::findById($_POST['question-id']);
    // Supprime la question de la base de données
    $question->delete();

    // Redirige vers la page du mode création
    header('Location: /create.php');

// Sinon, c'est que l'utilisateur est arrivé sur cette page par un autre moyen que le formumaire dédié
} else {
    http_response_code(400);
    echo('Invalid form data');
}

var_dump($_POST);
