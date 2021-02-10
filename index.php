<?php


include './models/question.php';
include './models/answer.php';

// Etablit une connexion à la base de données
$databaseHandler = new PDO('mysql:dbname=php_quiz;host=127.0.0.1', 'root', 'root');
$databaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Calcule si l'utilisateur vient de répondre à une question pour le réutiliser plus tard
$hasAnswered = isset($_POST['answer']) && isset($_POST['current-question']);
// Si l'utilisateur vient de répondre à une question
if ($hasAnswered) {
  // Récupère la question à laquelle l'utilisateur vient de répondre dans la BDD
  $statement = $databaseHandler->prepare('SELECT * FROM `question` WHERE `id` = :id');
  $statement->execute([ ':id' => $_POST['current-question'] ]);
  $result = $statement->fetchAll();
  $questionData = $result[0];

  $previousQuestion = new Question(
    $questionData['id'],
    $questionData['order'],
    $questionData['text'],
    $questionData['right_answer_id']
  );

  // Calcule si la réponse donnée par l'utilisateur à la question précédente était la bonne réponse ou pas
  $userAnswerId = intval($_POST['answer']);
  $rightlyAnswered = $previousQuestion->getRightAnswerId() === $userAnswerId;

  // Si l'utilisateur a mal répondu à la question précédente
  if (!$rightlyAnswered) {
    // Récupère la bonne réponse à la question précédente dans la BDD
    $statement = $databaseHandler->prepare('SELECT * FROM `answer` WHERE `id` = :id');
    $statement->execute([ ':id' => $previousQuestion->getRightAnswerId() ]);
    $result = $statement->fetchAll();
    $answerData = $result[0];
    
    $previousQuestionRightAnswer = new Answer(
      $answerData['text'],
      $answerData['id'],
      $answerData['question_id']
    );
  }
  // Sinon (si l'utilisateur arrive sur la page pour la première fois)
} else {

}
  
  
  



// Récupère la première question du quiz dans la base de données
$statement = $databaseHandler->query('SELECT * FROM `question` WHERE `order` = 1');
// Récupère les résultats de la requête sous forme de tableau associatif
$result = $statement->fetchAll();

// Isole le premier résultat de la requête (sachant qu'elle est censée renvoyer un seul résultat)
$questionData = $result[0];
// Crée un objet Question à partir des données récupérées de la BDD sous forme de tableau associatif
$question = new Question(
  $questionData['id'],
  $questionData['order'],
  $questionData['text'],
  $questionData['right_answer_id']
);

$statement = $databaseHandler->prepare('SELECT * FROM `answer` WHERE `question_id` = :questionId');
$statement->execute([ ':questionId' => $question->getId() ]);

$result = $statement->fetchAll();

foreach ($result as $answerData) {
  $answers []= new Answer(
    $answerData['text'], 
    $answerData['id'],
    $answerData['question_id']
  );
};

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
