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
            <form id="question-form" method="post" action="/question/<?= $question->getId() ?>/answer">
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
                