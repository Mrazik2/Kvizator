<?php
/** @var int $attemptId */
/** @var int $questionCount */
/** @var \App\Models\Question $question */
/** @var int $chosen */
/** @var \Framework\Support\LinkGenerator $link */

$answers = [];
$answers[0] = $question?->getAnswer1();
$answers[1] = $question?->getAnswer2();
$answers[2] = $question?->getAnswer3();
$answers[3] = $question?->getAnswer4();
$correct = $question?->getAnswer();
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <div class="attempt-answer-view">

                <input type="hidden" name="attemptId" id="attemptId" value="<?= $attemptId ?>">
                <input type="hidden" name="questionCount" id="questionCount" value="<?= $questionCount ?>">

                <div class="mb-3">
                    <label for="question_text" class="form-label" id="question-label">Question <?=  $question->getNumber() ?>/<?= $questionCount ?></label>
                    <h3 id="question_text" class="form-control-plaintext"><?= htmlspecialchars($question->getQuestion()) ?></h3>
                </div>

                <fieldset class="mb-3" id="options">

                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <?php $num = $i + 1; $isCorrect = isset($correct) && ((int)$correct === $num); $isChosen = isset($chosen) && ((int)$chosen === $num); ?>
                        <div class="mb-2" <?= $answers[$i] === '' ? 'hidden' : '' ?> id="answer_div_<?= $num ?>">
                            <div id="answer_text_<?= $num ?>" class="p-2 rounded <?= $isCorrect ? 'border border-success' : ($isChosen ? 'border border-primary' : 'border border-transparent') ?>">
                                <?= htmlspecialchars($answers[$i]) ?>

                                <?php if ($isChosen): ?>
                                    <span class="badge bg-primary ms-2">Your choice</span>
                                <?php endif; ?>

                                <?php if ($isCorrect): ?>
                                    <span class="badge bg-success ms-2">Correct</span>
                                <?php endif; ?>
                            </div>
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
                    <a href="<?= $link->url('attempt.result', ['attemptId' => $attemptId]) ?>" type="button" class="btn btn-primary" id="result">Result</a>
                </div>

            </div>
        </div>
    </div>
</div>
