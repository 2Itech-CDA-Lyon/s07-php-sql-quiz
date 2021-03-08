<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\Answer;
use App\Models\Question;

/**
 * Handles all general requests
 */
class MainController {
    /**
     * Home page
     *
     * @return View
     */
    public function home(): View
    {
        $rightlyAnswered = null;
        $previousQuestionRightAnswer = null;

        // Calcule si l'utilisateur vient de répondre à une question pour le réutiliser plus tard
        $hasAnswered = isset($_POST['answer']) && isset($_POST['current-question']);
        // Si l'utilisateur vient de répondre à une question
        if ($hasAnswered) {
            // Récupère la question à laquelle l'utilisateur vient de répondre dans la BDD
            $previousQuestion = Question::findById($_POST['current-question']);

            // Calcule si la réponse donnée par l'utilisateur à la question précédente était la bonne réponse ou pas
            $userAnswerId = intval($_POST['answer']);
            $rightlyAnswered = $previousQuestion->getRightAnswerId() === $userAnswerId;

            // Si l'utilisateur a mal répondu à la question précédente
            if (!$rightlyAnswered) {
                // Récupère la bonne réponse à la question précédente dans la BDD
                $previousQuestionRightAnswer = Answer::findById($previousQuestion->getRightAnswerId());
            }
        }

        // Récupère la première question du quiz dans la base de données
        $result = Question::findWhere([ 'order' => 1 ]);
        $question = $result[0];

        // Récupère toutes les réponses associées à cette question dans la base de données
        $answers = Answer::findWhere([ 'question_id' => $question->getId() ]);

        // Paramètre une vue pour afficher la page demandée
        return new View('pages/quiz', [
            'hasAnswered' => $hasAnswered,
            'rightlyAnswered' => $rightlyAnswered,
            'question' => $question,
            'answers' => $answers,
            'previousQuestionRightAnswer' => $previousQuestionRightAnswer,
        ]);
    }

    /**
     * Creation mode page
     *
     * @return View
     */
    public function create(): View
    {
        // Récupère toutes les questions en base de données
        $questions = Question::findAll();

        // Paramètre une vue pour afficher la page demandée
        return new View('pages/create', ['questions' => $questions]);
    }
}
