<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\Answer;
use App\Models\Question;
use App\Views\FlashMessage;
use App\Views\RedirectResponse;
use App\Interfaces\HttpResponse;
use App\Views\StandardLayoutView;
use App\Utils\FlashMessagesService;
use App\Exceptions\NotFoundException;
use App\Exceptions\InvalidFormDataException;

/**
 * Handles all requests pertaining to questions
 */
class QuestionController
{
    /**
     * Action - create question
     *
     * @return HttpResponse
     */
    public function create(): HttpResponse
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

            $flashMessagesService = new FlashMessagesService();
            $flashMessagesService->addMessage(
                new FlashMessage('Question créée avec succès!', 'success')
            );

            // Redirige vers la page du mode création
            return new RedirectResponse('/create');

        // Sinon, c'est que l'utilisateur est arrivé sur cette page par un autre moyen que le formumaire dédié
        } else {
            throw new InvalidFormDataException('Invalid form data');
        }
    }

    /**
     * Action - delete question
     *
     * @param integer $id
     * @return HttpResponse
     */
    public function delete(int $id): HttpResponse
    {
        // Récupère la question associée à l'ID fourni dans la BDD
        $question = Question::findById($id);

        // Si l'ID fourni ne correspond à aucune question en BDD, affiche un message d'erreur
        if ($question == null){
            throw new NotFoundException('Question #' . $id . ' does not exist in database.');
        }
        
        // Supprime la question de la base de données
        $question->delete();

        $flashMessagesService = new FlashMessagesService();
        $flashMessagesService->addMessage(
            new FlashMessage('Question supprimée avec succès!', 'success')
        );

        // Redirige vers la page du mode création
        return new RedirectResponse('/create');
    }

    /**
     * Page - question edit form
     *
     * @param integer $id
     * @return HttpResponse
     */
    public function editForm(int $id): HttpResponse
    {   
        // Récupère la question associée à l'ID fourni
        $question = Question::findById($id);

        // Si l'ID fourni ne correspond à aucune question en BDD, affiche un message d'erreur
        if ($question == null){
            throw new NotFoundException('Question #' . $id . ' does not exist in database.');
        }
        
        // Paramètre une vue pour afficher la page demandée
        return new StandardLayoutView('pages/question-edit', [
            'question' => $question
        ]);
    }

    /**
     * Action - edit question
     *
     * @param integer $id
     * @return HttpResponse
     */
    public function edit(int $id): HttpResponse
    {
        // Récupère la question associée à l'ID fourni
        $question = Question::findById($id);

        // Si l'ID fourni ne correspond à aucune question en BDD, affiche un message d'erreur
        if ($question == null){
            throw new NotFoundException('Question #' . $id . ' does not exist in database.');
        }
        
        // Injecte les données du formulaire dans l'objet
        $question->setText($_POST["question-text"]);

        // Sauvegarde l'état actuel de l'objet en BDD
        $question->save();

        $flashMessagesService = new FlashMessagesService();
        $flashMessagesService->addMessage(
            new FlashMessage('Question modifiée avec succès!', 'success')
        );

        // Redirige vers la page "mode création"
        return new RedirectResponse('/create');
    }

    /**
     * Action - process answer to a question
     *
     * @param integer $id
     * @return HttpResponse
     */
    public function answer(int $id): HttpResponse
    {
        // Vérifie que le formulaire contient bien les données attendues
        if (isset($_POST['answer'])) {
            // Récupère la question à laquelle l'utilisateur vient de répondre dans la BDD
            $previousQuestion = Question::findById($id);

            // Calcule si la réponse donnée par l'utilisateur à la question précédente était la bonne réponse ou pas
            $userAnswerId = intval($_POST['answer']);
            $rightlyAnswered = $previousQuestion->getRightAnswerId() === $userAnswerId;

            // Si l'utilisateur a mal répondu à la question précédente
            if (!$rightlyAnswered) {
                // Récupère la bonne réponse à la question précédente dans la BDD
                $previousQuestionRightAnswer = Answer::findById($previousQuestion->getRightAnswerId());
            } else {
                $previousQuestionRightAnswer = null;
            }
        // Sinon, répond avec un code d'erreur
        } else {
            throw new InvalidFormDataException('Field \'answer\' missing in form data.');
        }

        // Récupère la question suivante dans l'ordre du quiz
        $previousQuestion = Question::findById($id);
        $result = Question::findWhere([ 'order' => $previousQuestion->getOrder() + 1 ]);

        // Si la question suivante n'existe pas, c'est donc qu'on a atteint la fin du quiz
        if (empty($result)) {
            return new RedirectResponse('/');
        }

        $nextQuestion = $result[0];
        // Récupère les réponses associées à cette question
        $answers = Answer::findWhere([ 'question_id' => $nextQuestion->getId() ]);

        // Paramètre une vue pour afficher la page demandée
        return new StandardLayoutView('pages/quiz', [
            'hasAnswered' => true,
            'rightlyAnswered' => $rightlyAnswered,
            'question' => $nextQuestion,
            'answers' => $answers,
            'previousQuestionRightAnswer' => $previousQuestionRightAnswer,
        ]);        
    }
}
