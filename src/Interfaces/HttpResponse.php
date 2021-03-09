<?php

namespace App\Interfaces;

/**
 * Ensures compatibility between all types of responses to client
 */
interface HttpResponse
{
    /**
     * Send response to client
     *
     * @return void
     */
    public function send(): void;
}
