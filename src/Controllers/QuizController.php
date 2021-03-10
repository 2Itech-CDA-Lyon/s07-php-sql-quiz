<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\Answer;
use App\Models\Question;
use App\Views\StandardLayoutView;

class QuizController
{
    public function index()
    {
        // Récupère la première question du quiz dans la base de données
        $result = Question::findWhere([ 'order' => 1 ]);
        $question = $result[0];

        // Récupère toutes les réponses associées à cette question dans la base de données
        $answers = Answer::findWhere([ 'question_id' => $question->getId() ]);

        // Paramètre une vue pour afficher la page demandée
        return new StandardLayoutView('pages/quiz', [
            'hasAnswered' => false,
            'rightlyAnswered' => null,
            'question' => $question,
            'answers' => $answers,
            'previousQuestionRightAnswer' => null,
        ]);
    }
}
