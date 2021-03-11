<!-- question/preview -->
<li class="list-group-item list-group-item-action d-flex align-items-center">
    <div class="mr-auto">
        <strong>Question <?= $question->getOrder() ?> ➤</strong>
        <?= $question->getText() ?>
    </div>
    <div class="ml-4 d-flex">
        <a class="btn btn-primary btn-sm" href="/question/<?= $question->getId() ?>/edit">
            <i class="fas fa-pen"></i>
        </a>
        <form method="post" action="/question/<?= $question->getId() ?>/delete">
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</li>
