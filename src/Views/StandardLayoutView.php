<?php

namespace App\Views;

use App\Views\View;
use App\Utils\FlashMessagesService;

/**
 * Handles generation of HTML documents including a standard layout with header and footer
 */
class StandardLayoutView extends View
{
    /**
     * Name of the template file to display
     * @var string
     */
    protected string $templateName;

    /**
     * Create new standard layout view
     *
     * @param string $templateName
     * @param array $variables
     */
    public function __construct(string $templateName, array $variables = [])
    {
        parent::__construct($variables);
        $this->templateName = $templateName;
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
        $this->includeTemplate('head/fontawesome');
        $this->includeTemplate('head/standard-layout');
    }

    /**
     * Render page body
     *
     * @return void
     */
    protected function renderBody(): void
    {
        $flashMessagesService = new FlashMessagesService();

        echo '<header>' . PHP_EOL;
        $this->includeTemplate('layout/header');
        echo '</header>' . PHP_EOL;

        echo '<div class="container mt-4">' . PHP_EOL;
        $flashMessages = $flashMessagesService->getMessages();
        foreach ($flashMessages as $flashMessage) {
            include './templates/layout/flash-message.php';
        }
        $flashMessagesService->deleteMessages();
        echo '</div>';

        echo '<main class="Main">' . PHP_EOL;
        $this->includeTemplate($this->templateName);
        echo '</main>' . PHP_EOL;

        echo '<footer class="Footer">' . PHP_EOL;
        $this->includeTemplate('layout/footer');
        echo '</footer>' . PHP_EOL;
    }
}
