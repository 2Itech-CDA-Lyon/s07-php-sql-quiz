<?php

namespace App\Views;

/**
 * Handles generation of HTML documents
 */
class View {
    /**
     * Name of the template file to display
     * @var string
     */
    private string $templateName;
    /**
     * List of all variables needed in the template
     * @var array
     */
    private array $variables;

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

    /**
     * Generate HTML code from view
     *
     * @return void
     */
    public function send(): void
    {
        // Crée une variable pour chaque entrée du tableau "variables"
        foreach ($this->variables as $name => $value) {
            $$name = $value;
        }

        // Génère le code HTML de la page
        include './templates/head.php';
        echo '<body>' . PHP_EOL;
        include './templates/' . $this->templateName . '.php';
        echo '</body>' . PHP_EOL;
        echo '</html>';
    }
}
