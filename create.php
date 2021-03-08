<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\Question;

$questions = Question::findAll();

?>

<?php include './templates/head.php' ?>
<body>
    <div class="container">
        <h1>Mode création</h1>
        <h2>Questions</h2>
        <ol class="list-group">
            <?php foreach ($questions as $question): ?>
            <li class="list-group-item list-group-item-action d-flex align-items-center">
                <div class="mr-auto">
                    <strong>Question <?= $question->getOrder() ?> ➤</strong>
                    <?= $question->getText() ?>
                </div>
                <div class="ml-4 d-flex">
                    <a class="btn btn-primary btn-sm" href="/question-edit.php?id=<?= $question->getId() ?>">
                        <i class="fas fa-pen"></i>
                    </a>
                    <form method="post" action="/actions/delete-question.php">
                        <input type="hidden" name="question-id" value="<?= $question->getId() ?>" />
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>

        <form method="post" action="/actions/save-question.php">
            <div class="mt-4 mb-3">
                <label for="newQuestion" class="form-label">Ajouter une nouvelle question</label>
                <input type="text" name="question-text" class="form-control" id="newQuestion" placeholder="Texte de la question" />
                <input type="hidden" name="question-order" value="<?= count($questions) + 1 ?>" />
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>