<?php
/** @var int $attemptId */
/** @var int $questionCount */
/** @var \App\Models\Question $question */

$answers = [];
$answers[0] = $question?->getAnswer1();
$answers[1] = $question?->getAnswer2();
$answers[2] = $question?->getAnswer3();
$answers[3] = $question?->getAnswer4();
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <form action="#" method="post" class="attempt-question-form">
                <input type="hidden" name="attemptId" id="attemptId" value="<?= $attemptId ?>">
                <input type="hidden" name="questionCount" id="questionCount" value="<?= $questionCount ?>">

                <div class="mb-3">
                    <label for="question_text" class="form-label" id="question-label">Question <?=  $question->getNumber() ?>/<?= $questionCount ?></label>
                    <h3 id="question_text" class="form-control-plaintext"><?= htmlspecialchars($question->getQuestion()) ?></h3>
                </div>

                <fieldset class="mb-3" id="options">

                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <?php $rid = 'answer_radio_' . $i + 1; ?>
                        <div class="form-check mb-2" <?= $answers[$i] === '' ? 'hidden' : '' ?> id="answer_div_<?= $i + 1 ?>">
                            <input class="form-check-input" type="radio" name="answer" id="<?= $rid ?>">
                            <label class="form-check-label" for="<?= $rid ?>" id="answer_text_<?= $i + 1 ?>"><?= htmlspecialchars($answers[$i]) ?></label>
                        </div>
                    <?php endfor; ?>

                </fieldset>

                <div class="d-flex align-items-center mb-3">
                    <div class="flex-fill d-flex justify-content-start">
                        <button type="button" class="btn btn-outline-secondary" id="prev-question">Previous</button>
                    </div>

                    <div class="d-flex align-items-center gap-2 justify-content-center">
                        <label for="goto-number" class="visually-hidden">Go to question</label>
                        <input id="goto-number" type="number" class="form-control" placeholder="No.">
                        <button type="button" class="btn btn-outline-primary" id="goto-question">Go</button>
                    </div>

                    <div class="flex-fill d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary" id="next-question">Next</button>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary" id="clear-answer">Clear Answer</button>
                    <button type="button" class="btn btn-primary" id="submit-attempt">Submit Quiz</button>
                    <button type="button" class="btn btn-danger" id="abandon-attempt">Abandon Quiz</button>
                </div>

            </form>
        </div>
    </div>
</div>
