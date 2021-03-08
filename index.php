<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\Answer;
use App\Models\Question;

// Calcule si l'utilisateur vient de répondre à une question pour le réutiliser plus tard
$hasAnswered = isset($_POST['answer']) && isset($_POST['current-question']);
// Si l'utilisateur vient de répondre à une question
if ($hasAnswered) {
  // Récupère la question à laquelle l'utilisateur vient de répondre dans la BDD
  $previousQuestion = Question::findById($_POST['current-question']);

  // Calcule si la réponse donnée par l'utilisateur à la question précédente était la bonne réponse ou pas
  $userAnswerId = intval($_POST['answer']);
  $rightlyAnswered = $previousQuestion->getRightAnswerId() === $userAnswerId;

  // Si l'utilisateur a mal répondu à la question précédente
  if (!$rightlyAnswered) {
    // Récupère la bonne réponse à la question précédente dans la BDD
    $previousQuestionRightAnswer = Answer::findById($previousQuestion->getRightAnswerId());
  }
}

// Récupère la première question du quiz dans la base de données
$result = Question::findWhere([ 'order' => 1 ]);
$question = $result[0];

// Récupère toutes les réponses associées à cette question dans la base de données
$answers = Answer::findWhere([ 'question_id' => $question->getId() ]);

?>

<?php include './templates/head.php' ?>
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
</html>