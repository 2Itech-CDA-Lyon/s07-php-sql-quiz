<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Question;

// Si on arrive sur ce fichier par une méthode autre que POST, renvoie un code d'erreur
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo('Cannot ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);
    die();
}

// Si toutes les données du formulaire sont présentes
if (isset($_POST['question-text']) && isset($_POST['question-order'])) {

    // Si un ID de question a été passé dans le formulaire, on sait qu'on doit modifier un objet existant
    if (isset($_POST['question-id'])) {
        // Récupère la question associée à l'ID fourni
        $question = Question::findById($_POST['question-id']);
    // Sinon, c'est qu'on doit créer un nouvel objet
    } else {
        // Crée un objet à partir du contenu du formulaire
        $question = new Question();
    }

    // Injecte le contenu du formulaire dans les propriétés de l'objet
    $question->setText($_POST['question-text']);
    $question->setOrder($_POST['question-order']);

    // Sauvegarde l'objet en BDD
    $question->save();

    // Redirige vers la page du mode création
    header('Location: /create.php');

// Sinon, c'est que l'utilisateur est arrivé sur cette page par un autre moyen que le formumaire dédié
} else {
    http_response_code(400);
    echo('Invalid form data');
}
