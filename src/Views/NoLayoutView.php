<?php

namespace App\Views;

use App\Views\View;

/**
 * Handles generation of HTML documents with no specific layout
 */
class NoLayoutView extends View
{
    /**
     * Name of the template file to display
     * @var string
     */
    protected string $templateName;
    /**
     * Name of the stylesheet needed to display page properly
     * @var string
     */
    protected string $stylesheet;

    /**
     * Create new no layout view
     *
     * @param string $templateName Name of the template file to display
     * @param string $stylesheet Name of the stylesheet needed to display page properly
     * @param array $variables List of all variables needed in the template
     */
    public function __construct(string $templateName, string $stylesheet, array $variables = [])
    {
        parent::__construct($variables);
        $this->templateName = $templateName;
        $this->stylesheet = $stylesheet;
    }

    /**
     * Render page head
     *
     * @return void
     */
    protected function renderHead(): void
    {
        $this->includeTemplate('head/meta');
        $this->includeTemplate('head/bootstrap');
        echo '<link rel="stylesheet" href="/css/' . $this->stylesheet . '.css" />';
    }

    /**
     * Render page body
     *
     * @return void
     */
    protected function renderBody(): void
    {
        $this->includeTemplate($this->templateName);
    }
}
