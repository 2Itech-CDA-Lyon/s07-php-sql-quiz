<?php

namespace App\Utils;

use App\Views\FlashMessage;

class FlashMessagesService
{
    /**
     * Store flash message in session
     *
     * @param string $message Message to store
     * @return void
     */
    public function addMessage(FlashMessage $flashMessage): void
    {
        // Demande à l'objet FlashMessage de se transformer en tableau associatif, afin de le stocker dans la session
        $_SESSION['message'] = $flashMessage->toArray();
    }

    /**
     * Get flash message stored in session
     *
     * @return FlashMessage|null
     */
    public function getMessage(): ?FlashMessage
    {
        // Si aucun message n'a été stocké dans la session, renvoie null
        if (!isset($_SESSION['message'])) {
            return null;
        }

        // Demande à la classe FlashMessage de construire un nouvel objet à partir du tableau associatif stocké en session
        return FlashMessage::fromArray($_SESSION['message']);
    }

    /**
     * Delete flash message from session
     *
     * @return void
     */
    public function deleteMessage(): void
    {
        // Supprime les informations du message stockées en session
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }
    }
}
