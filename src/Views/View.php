<?php

namespace App\Views;

use App\Models\User;
use App\Interfaces\HttpResponse;
use App\Utils\AuthenticationService;

/**
 * Handles generation of HTML documents
 */
abstract class View implements HttpResponse
{
    /**
     * List of all variables needed in the template
     * @var array
     */
    protected array $variables;
    /**
     * Currently authenticated user
     * @var User|null
     */
    protected ?User $currentUser;

    /**
     * Create new view
     *
     * @param array $variables List of all variables needed in the template
     */
    public function __construct(array $variables = [])
    {
        $this->variables = $variables;

        // Récupère les données de l'utilisateur actuellement connecté
        $authenticationService = new AuthenticationService();
        $this->currentUser = $authenticationService->getAuthenticatedUser();
    }

    protected function includeTemplate(string $templateName)
    {
        // Crée une variable pour chaque entrée du tableau "variables"
        foreach ($this->variables as $name => $value) {
            $$name = $value;
        }

        $currentUser = $this->currentUser;

        include './templates/' . $templateName . '.php';
    }

    /**
     * Generate HTML code from view
     *
     * @return void
     */
    public function render(): void
    {
        echo '<!DOCTYPE html>' . PHP_EOL;
        echo '<html lang="en">' . PHP_EOL;
        echo '<head>' . PHP_EOL;

        // Passe la main à la classe concrète qui choisit elle-même comment écrire le contenu de la balise head
        $this->renderHead();

        echo '</head>' . PHP_EOL;
        echo '<body>' . PHP_EOL;

        // Passe la main à la classe concrète qui choisit elle-même comment écrire le contenu de la balise body
        $this->renderBody();

        echo '</body>' . PHP_EOL;
        echo '</html>';
    }

    /**
     * Render page head
     *
     * @return void
     */
    abstract protected function renderHead(): void;

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
