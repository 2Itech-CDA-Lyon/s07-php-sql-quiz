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
