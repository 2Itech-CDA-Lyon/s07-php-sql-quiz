<?php

namespace App\Views;

use App\Views\View;

/**
 * Handles generation of HTML documents including a standard layout with header and footer
 */
class StandardLayoutView extends View
{
    /**
     * Render page body
     *
     * @return void
     */
    protected function renderBody(): void
    {
        // Inclut 
        echo '<header>' . PHP_EOL;
        $this->includeTemplate('layout/header');
        echo '</header>' . PHP_EOL;

        echo '<main class="Main">' . PHP_EOL;
        $this->includeTemplate($this->templateName);
        echo '</main>' . PHP_EOL;

        echo '<footer class="Footer">' . PHP_EOL;
        $this->includeTemplate('layout/footer');
        echo '</footer>' . PHP_EOL;
    }
}
