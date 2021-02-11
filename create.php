<?php

include './utils/Database.php';

include './models/question.php';

$questions = Question::find();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode création</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h1>Mode création</h1>
        <h2>Questions</h2>
        <ol class="list-group">
            <?php foreach ($questions as $question): ?>
            <li class="list-group-item"><?= $question->getText()  ?></li>
            <?php endforeach; ?>
        </ol>

        <form method="post" action="/actions/create-question.php">
            <div class="mt-4 mb-3">
                <label for="newQuestion" class="form-label">Ajouter une nouvelle question</label>
                <input type="text" name="question-text" class="form-control" id="newQuestion" placeholder="Texte de la question" />
                <input type="hidden" name="question-count" value="<?= count($questions) ?>" />
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</body>
</html>