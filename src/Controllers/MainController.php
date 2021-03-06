<?php

namespace App\Controllers;

use App\Views\View;
use App\Models\Answer;
use App\Models\Question;
use App\Views\NoLayoutView;
use App\Interfaces\HttpResponse;
use App\Views\StandardLayoutView;
use App\Utils\AuthenticationService;
use App\Exceptions\UnauthorizedException;

/**
 * Handles all general requests
 */
class MainController {
    /**
     * Home page
     *
     * @return HttpResponse
     */
    public function home(): HttpResponse
    {
        return new NoLayoutView('pages/home', 'home');
    }

    /**
     * Creation mode page
     *
     * @return HttpResponse
     */
    public function create(): HttpResponse
    {
        // Si l'utilisateur n'est pas authentifié, renvoie une erreur
        $authenticationService = new AuthenticationService();
        $authenticationService->denyAccessUnlessGranted();

        // Récupère toutes les questions en base de données
        $questions = Question::findAll();

        // Paramètre une vue pour afficher la page demandée
        return new StandardLayoutView('pages/create', ['questions' => $questions]);
    }
}
