<div class="container">
    <h1>Mode édition</h1>
    <h2>Question n°<?= $question->getOrder() ?></h2>

    <form method="post">
        <div class="mt-4 mb-3">
            <label for="editQuestion" class="form-label">Texte</label>
            <input type="text" name="question-text" class="form-control" id="editQuestion" value="<?= $question->getText();?>" />
            <input type="hidden" name="question-id" value="<?= $question->getId() ?>" />
            <input type="hidden" name="question-order" value="<?= $question->getOrder() ?>" />
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a class="btn btn-secondary" href="/create">Retour</a>
        </div>
    </form>
</div>
