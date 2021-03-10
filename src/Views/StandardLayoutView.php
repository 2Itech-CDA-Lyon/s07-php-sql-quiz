<?php

namespace App\Views;

use App\Views\View;

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

        $this->includeTemplate($this->templateName);

        echo '<footer>' . PHP_EOL;
        $this->includeTemplate('layout/footer');
        echo '</footer>' . PHP_EOL;
    }
}
