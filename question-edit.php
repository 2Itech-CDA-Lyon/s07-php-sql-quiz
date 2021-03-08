<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\Question;

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

<?php include './templates/head.php' ?>
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