<?php

namespace App\Controllers;

use App\Models\User;
use App\Views\RedirectResponse;
use App\Interfaces\HttpResponse;
use App\Views\StandardLayoutView;
use App\Utils\AuthenticationService;
use App\Exceptions\NotFoundException;
use App\Exceptions\InvalidFormDataException;
use App\Exceptions\InvalidCredentialsException;

class SecurityController
{
    public function loginForm(): HttpResponse
    {
        // Si l'utilisateur est déjà authentifié, retour sur la page d'accueil
        if (isset($_COOKIE['PHP_AUTH'])) {
            return new RedirectResponse('/');
        }

        // Sinon, affiche le formulaire d'authentification normalement
        return new StandardLayoutView('pages/login');
    }

    public function login(): HttpResponse
    {
        // Tente d'authentifier l'utilisateur à l'aide des données du formulaire
        try {
            if (!isset($_POST['email']) || !isset($_POST['password'])) {
                throw new InvalidFormDataException('Invalid form data.');
            }

            // Récupère les données du formulaire
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Authentifie l'utilisateur en passant par le service dédié
            $authenticationService = new AuthenticationService();
            $authenticationService->authenticate($email, $password);

            // Redirige sur la page d'accueil
            return new RedirectResponse('/');
        }
        // En cas d'erreur liée à des identifiants incorrects
        catch (InvalidCredentialsException $exception) {
            // En fonction du type de l'erreur, affiche un message différent
            switch ($exception->getType()) {
                case InvalidCredentialsException::WRONG_EMAIL:
                    // TODO: message 'email non existant'
                    break;
                case InvalidCredentialsException::WRONG_PASSWORD:
                    // TODO: message 'mauvais mot de passe'
                    break;
                default:
                    // TODO: ajouter une erreur 'ce code ne devrait jamais être atteint'
            }
            // Redirige sur la page d'authentification
            return new RedirectResponse('/login');
        }
    }

    public function logout(): HttpResponse
    {
        // Supprime les informations d'authentification
        $authenticationService = new AuthenticationService();
        $authenticationService->forget();
        // Redirige vers la page d'accueil
        return new RedirectResponse('/');
    }
}
