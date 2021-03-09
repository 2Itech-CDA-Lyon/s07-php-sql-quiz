<?php

use App\Views\View;

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
$router->map( 'POST', '/question/create', 'QuestionController#create', 'create_question' );

// Action permettant de supprimer une question
$router->map( 'POST', '/question/[i:id]/delete', 'QuestionController#delete', 'delete_question' );

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
  // Découpe le nom du contrôleur et le nom de la méthode correspondant à la route trouvée
  list($controllerName, $methodName) = explode('#', $match['target']);
  $controllerName = 'App\\Controllers\\' . $controllerName;
  // Instancie le contrôleur et appelle la méthode correspondante, en passant tous les paramètres récupérés de l'URL le cas échéant
  $controller = new $controllerName;
  $view = $controller->$methodName(...array_values($match['params']));
}

// Si la variable view n'est pas définie, ou si ce n'est pas un objet View, envoie un message d'erreur
if (!isset($view) || !$view instanceof View) {
  throw new Error('Routes must return a View object.');
}

// Génère la page HTML à partir de l'objet View paramétré précédemment
$view->send();
