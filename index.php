<?php

use App\Views\View;
use App\Models\Answer;
use App\Models\Question;

// Front Controller
// Toutes les requêtes HTTP sont interceptées par le fichier .htaccess et redirigées vers ce fichier.
// C'est lui qui s'occupe de décider quel traitement associer à chaque requête

// Active le chargement automatique des classes
require __DIR__ . '/vendor/autoload.php';

// Crée un routeur
$router = new AltoRouter();

// Paramètre les différentes routes de l'application

// Page d'accueil
$router->map( 'GET', '/', function() {
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
}, 'home' );

// Page du mode "création"
$router->map( 'GET', '/create', function() {
  // Récupère toutes les questions en base de données
  $questions = Question::findAll();

  // Paramètre une vue pour afficher la page demandée
  return new View('pages/create', ['questions' => $questions]);
}, 'create' );

// Tente de trouver une correspondance entre les routes existantes et la requête du client
$match = $router->match();

// Si aucune correspondance n'a été trouvée
if ($match === false) {
  // Configure la réponse avec un code HTPP 404 - non trouvé
  http_response_code(404);
  // Paramètre une vue pour afficher une page "page non trouvée"
  $view = new View('pages/not-found');
// Sinon
} else {
  // Appelle la fonction correspondant à la route trouvée
  $view = call_user_func($match['target']);
}

// Si la variable view n'est pas définie, ou si ce n'est pas un objet View, envoie un message d'erreur
if (!isset($view) || !$view instanceof View) {
  throw new Error('Routes must return a View object.');
}

// Génère la page HTML à partir de l'objet View paramétré précédemment
$view->send();
