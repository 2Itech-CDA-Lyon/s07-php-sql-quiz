<!-- layout/flash-message -->
<div class="alert alert-<?= $flashMessage->getType() ?>" role="alert">
    <?= $flashMessage->getMessage() ?>
</div>
