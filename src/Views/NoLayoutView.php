<?php

namespace App\Views;

use App\Views\View;

class NoLayoutView extends View
{
    protected function renderBody(): void
    {
        $this->includeTemplate($this->templateName);
    }
}
