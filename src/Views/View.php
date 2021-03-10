<?php

namespace App\Views;

use App\Interfaces\HttpResponse;

/**
 * Handles generation of HTML documents
 */
abstract class View implements HttpResponse
{
    /**
     * Name of the template file to display
     * @var string
     */
    protected string $templateName;
    /**
     * List of all variables needed in the template
     * @var array
     */
    protected array $variables;

    /**
     * Create new view
     *
     * @param string $templateName Name of the template file to display
     * @param array $variables List of all variables needed in the template
     */
    public function __construct(string $templateName, array $variables = [])
    {
        $this->templateName = $templateName;
        $this->variables = $variables;
    }

    protected function includeTemplate(string $templateName)
    {
        // Crée une variable pour chaque entrée du tableau "variables"
        foreach ($this->variables as $name => $value) {
            $$name = $value;
        }

        include './templates/' . $templateName . '.php';
    }

    /**
     * Generate HTML code from view
     *
     * @return void
     */
    public function render(): void
    {
        // Génère le code HTML de la page
        $this->includeTemplate('head');
        echo '<body>' . PHP_EOL;

        // Passe la main à la classe concrète qui choisit elle-même comment écrire le contenu de la balise body
        $this->renderBody();

        echo '</body>' . PHP_EOL;
        echo '</html>';
    }

    /**
     * Render page body
     *
     * @return void
     */
    abstract protected function renderBody(): void;

    /**
     * Send response to client
     *
     * @return void
     */
    public function send(): void
    {
        $this->render();
    }
}
