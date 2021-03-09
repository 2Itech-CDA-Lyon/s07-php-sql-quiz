<div class="container">
    <h1>Mode création</h1>
    <h2>Questions</h2>
    <ol class="list-group">
        <?php foreach ($questions as $question): ?>
        <?php include './templates/question/preview.php' ?>
        <?php endforeach; ?>
    </ol>

    <form method="post" action="/question/create">
        <div class="mt-4 mb-3">
            <label for="newQuestion" class="form-label">Ajouter une nouvelle question</label>
            <input type="text" name="question-text" class="form-control" id="newQuestion" placeholder="Texte de la question" />
            <input type="hidden" name="question-order" value="<?= count($questions) + 1 ?>" />
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
