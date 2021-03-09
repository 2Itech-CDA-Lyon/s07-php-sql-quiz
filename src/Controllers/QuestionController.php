<?php

namespace App\Controllers;

use App\Models\Question;

class QuestionController
{
    public function create()
    {
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
            header('Location: /create');

        // Sinon, c'est que l'utilisateur est arrivé sur cette page par un autre moyen que le formumaire dédié
        } else {
            http_response_code(400);
            echo('Invalid form data');
            die();
        }
    }

    public function delete(int $id)
    {
        // Récupère la question associée à l'ID fourni dans la BDD
        $question = Question::findById($id);
        // Supprime la question de la base de données
        $question->delete();

        // Redirige vers la page du mode création
        header('Location: /create');
        die();
    }
}
