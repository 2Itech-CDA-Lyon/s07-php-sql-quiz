<?php

use App\Views\View;
use App\Exceptions\NotFoundException;
use App\Exceptions\InvalidFormDataException;

// Front Controller
// Toutes les requêtes HTTP sont interceptées par le fichier .htaccess et redirigées vers ce fichier.
// C'est lui qui s'occupe de décider quel traitement associer à chaque requête

// Active le chargement automatique des classes
require __DIR__ . '/vendor/autoload.php';

// Crée un routeur
$router = new AltoRouter();

// Paramètre les différentes routes de l'application

// Page d'accueil
$router->map( 'GET', '/', 'MainController#home', 'home' );

// Page du mode "création"
$router->map( 'GET', '/create', 'MainController#create', 'create' );

// Action permettant de créer une question
$router->map( 'POST', '/question/create', 'QuestionController#create', 'question_create' );

// Action permettant de supprimer une question
$router->map( 'POST', '/question/[i:id]/delete', 'QuestionController#delete', 'question_delete' );

// Page contenant le formulaire de modication d'une question
$router->map( 'GET', '/question/[i:id]/edit', 'QuestionController#editForm', 'question_edit_form' );

// Action permettant de modifier une question
$router->map( 'POST', '/question/[i:id]/edit', 'QuestionController#edit', 'question_edit' );

// Action permettant de traiter la réponse à une question
$router->map( 'POST', '/question/[i:id]/answer', 'QuestionController#answer', 'question_answer' );

// Tente de trouver une correspondance entre les routes existantes et la requête du client
$match = $router->match();

// Tente de faire fonctionner l'application normalement
try {
  if ($match === false) {
    throw new NotFoundException();
  }

  // Découpe le nom du contrôleur et le nom de la méthode correspondant à la route trouvée
  list($controllerName, $methodName) = explode('#', $match['target']);
  $controllerName = 'App\\Controllers\\' . $controllerName;
  // Instancie le contrôleur et appelle la méthode correspondante, en passant tous les paramètres récupérés de l'URL le cas échéant
  $controller = new $controllerName;
  $view = $controller->$methodName(...array_values($match['params']));
}
// En cas d'erreur liée à une ressource manquante
catch (NotFoundException $exception) {
  // Configure la réponse avec un code HTPP 404 - non trouvé
  http_response_code(404);
  // Paramètre une vue pour afficher une page "page non trouvée"
  $view = new View('pages/not-found');
}
catch (InvalidFormDataException $exception) {
  http_response_code(400);
  $view = new View('pages/bad-request');
}

// Si la variable view n'est pas définie, ou si ce n'est pas un objet View, envoie un message d'erreur
if (!isset($view) || !$view instanceof View) {
  throw new Error('Routes must return a View object.');
}

// Génère la page HTML à partir de l'objet View paramétré précédemment
$view->send();
