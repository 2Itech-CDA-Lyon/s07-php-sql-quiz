<?php

namespace App\Views;

use App\Interfaces\HttpResponse;

/**
 * Handles redirections
 */
class RedirectResponse implements HttpResponse
{
    /**
     * URL to redirect to
     * @var string
     */
    private string $location;

    /**
     * Create new redirect response
     *
     * @param string $location URL to redirect to
     */
    public function __construct(string $location)
    {
        $this->location = $location;
    }

    /**
     * Redirect to a different route
     *
     * @return void
     */
    public function redirect()
    {
        header('Location: ' . $this->location);
    }

    /**
     * Send response to client
     *
     * @return void
     */
    public function send(): void
    {
        $this->redirect();
    }
}
