<?php

namespace App\Controllers;

use App\Models\User;
use App\Views\RedirectResponse;
use App\Interfaces\HttpResponse;
use App\Views\StandardLayoutView;

class SecurityController
{
    public function loginForm(): HttpResponse
    {
        return new StandardLayoutView('pages/login');
    }

    public function login(): HttpResponse
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Récupère l'utilisateur correspondant à l'adresse e-mail fournie
        $result = User::findWhere([ 'email' => $email ]);

        // Si aucun utilisateur avec l'adresse demandée n'existe
        if (empty($result)) {
            // Retour sur la page d'authentification avec un message d'erreur
            return new RedirectResponse('/login');
        }

        $user = $result[0];

        // Vérifie si le mot de passe fourni correspond au mot de passe défini en BDD
        if ($password === $user->getPassword()) {
            setcookie('PHP_AUTH', $user->getId());
            return new RedirectResponse('/');
        } else {
            // Retour sur la page d'authentification avec un message d'erreur
            return new RedirectResponse('/login');
        }
    }

    public function logout(): HttpResponse
    {
        // Si l'utilisateur est bien authentifié
        if (isset($_COOKIE['PHP_AUTH'])) {
            // Supprime le cookie
            unset($_COOKIE['PHP_AUTH']);
            setcookie('PHP_AUTH', '', time() - 3600, '/');
        }
        // Redirige vers la page d'accueil
        return new RedirectResponse('/');
    }
}
