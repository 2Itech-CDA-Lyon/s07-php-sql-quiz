<?php

include './utils/Database.php';

include './models/question.php';
include './models/answer.php';


$databaseHandler = new Database();

// Calcule si l'utilisateur vient de répondre à une question pour le réutiliser plus tard
$hasAnswered = isset($_POST['answer']) && isset($_POST['current-question']);
// Si l'utilisateur vient de répondre à une question
if ($hasAnswered) {
  // Récupère la question à laquelle l'utilisateur vient de répondre dans la BDD
  $statement = $databaseHandler->fetchFromTableById('question', $_POST['current-question']);
  $result = $statement->fetchAll(PDO::FETCH_FUNC,
    function(...$params) {
      return new Question(...$params);
    }
  );
  $previousQuestion = $result[0];

  // Calcule si la réponse donnée par l'utilisateur à la question précédente était la bonne réponse ou pas
  $userAnswerId = intval($_POST['answer']);
  $rightlyAnswered = $previousQuestion->getRightAnswerId() === $userAnswerId;

  // Si l'utilisateur a mal répondu à la question précédente
  if (!$rightlyAnswered) {
    // Récupère la bonne réponse à la question précédente dans la BDD
    $statement = $databaseHandler->fetchFromTableById('answer', $previousQuestion->getRightAnswerId());
    $result = $statement->fetchAll(PDO::FETCH_FUNC,
      function(...$params) {
        return new Answer(...$params);
      }
    );
    $previousQuestionRightAnswer = $result[0];
  }
  // Sinon (si l'utilisateur arrive sur la page pour la première fois)
} else {

}
  
  
  


// Récupère la première question du quiz dans la base de données
// $statement = $databaseHandler->query('SELECT * FROM `question` WHERE `order` = 1');
$statement = $databaseHandler->fetchFromTableWhere('question', [ 'order' => 1 ]);

// Récupère les résultats de la requête sous forme d'objets
$result = $statement->fetchAll(PDO::FETCH_FUNC,
  function(...$params) {
    return new Question(...$params);
  }
);
$question = $result[0];


// Récupère toutes les réponses associées à cette question dans la base de données
$statement = $databaseHandler->fetchFromTableWhere('answer', [ 'question_id' => $question->getId() ]);
$answers = $statement->fetchAll(PDO::FETCH_FUNC,
  function(...$params) {
    return new Answer(...$params);
  }
);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
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
    <h1>Quizz</h1>

    <?php if ($hasAnswered): ?>
      <?php if ($rightlyAnswered): ?>
        <div id="answer-result" class="alert alert-success">
          <i class="fas fa-thumbs-up"></i> Bravo, c'était la bonne réponse!
        </div>
      <?php else: ?>
        <div id="answer-result" class="alert alert-danger">
          <i class="fas fa-thumbs-down"></i> Hé non! La bonne réponse était <strong><?= $previousQuestionRightAnswer->getText() ?>.</strong>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <h2 class="mt-4">Question n°<span id="question-id"><?= $question->getOrder() ?></span></h2>
    <form id="question-form" method="post">
      <p id="current-question-text" class="question-text"><?= $question->getText() ?></p>
      <div id="answers" class="d-flex flex-column">

        <?php foreach ($answers as $key => $answer): ?>
        <div class="custom-control custom-radio mb-2">
          <input class="custom-control-input" type="radio" name="answer" id="answer<?= $key ?>" value="<?= $answer->getId() ?>">
          <label class="custom-control-label" for="answer<?= $key ?>"><?php echo $answer->getText() ?></label>
        </div>
        <?php endforeach; ?>
        
      </div> 
      <input type="hidden" name="current-question" value="<?= $question->getId() ?>" />
      <button type="submit" class="btn btn-primary">Valider</button>
    </form>
  </div>
</body>
