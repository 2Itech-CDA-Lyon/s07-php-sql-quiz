<?php

include './utils/Database.php';
include './models/question.php';


// Si aucun paramètre "id" n'a été fourni, affiche un message d'erreur
if(!isset($_GET['id'])){
    http_response_code(400);
    echo 'Aucune question n\'a été sélactionnée';
    die();
}

// Récupère la question associée à l'ID fourni
$id = $_GET['id'];
$question = Question::findById($id);

// Si l'ID fourni ne correspond à aucune question en BDD, affiche un message d'erreur
if($question == null){
    http_response_code(404);
    echo 'Cette question n\'existe pas';
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h1>Mode édition</h1>
        <h2>Question n°<?= $question->getOrder() ?></h2>

        <form method="post" action="/actions/save-question.php">
            <div class="mt-4 mb-3">
                <label for="editQuestion" class="form-label">Texte</label>
                <input type="text" name="question-text" class="form-control" id="editQuestion" value="<?= $question->getText();?>" />
                <input type="hidden" name="question-id" value="<?= $id ?>" />
                <input type="hidden" name="question-order" value="<?= $question->getOrder() ?>" />
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a class="btn btn-secondary" href="/create.php">Retour</a>
            </div>
        </form>
    </div>
</body>
</html>