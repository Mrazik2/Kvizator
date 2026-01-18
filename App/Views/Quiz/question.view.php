<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var int $quizId */
/** @var int $questionCount */
/** @var \App\Models\Question|null $question */

$options = [];
$options[0] = $question?->getOption1();
$options[1] = $question?->getOption2();
$options[2] = $question?->getOption3();
$options[3] = $question?->getOption4();
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <form action="<?= $link->url('quiz.question')?>" method="post" class="question-form">

                <input type="hidden" name="quizId" value="<?= $quizId ?>">

                <div class="mb-3">
                    <label for="question_text" class="form-label">Question 1/<?= $questionCount ?></label>
                    <textarea id="question_text" name="text" class="form-control" rows="3" required><?= $question ? $question->getQuestion() : '' ?></textarea>
                </div>

                <fieldset class="mb-3">
                    <legend class="col-form-label">Answers (choose the correct one)</legend>

                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <?php $aid = 'answer_' . $i; ?>
                        <?php $rid = 'radio_' . $i; ?>
                        <div class="input-group mb-2 align-items-center">
                            <div class="input-group-text">
                                <input id="<?= $rid ?>"  class="form-check-input mt-0" type="radio" name="correct" value="<?= $i ?>" aria-label="Correct answer <?= $i + 1 ?>" <?= $i === ($question ? $question->getAnswer() - 1 : 0) ? 'checked' : '' ?>>
                            </div>
                            <label for="<?= $aid ?>" class="visually-hidden">Answer <?= $i + 1 ?></label>
                            <input id="<?= $aid ?>" type="text" name="answers[]" class="form-control" placeholder="Answer <?= $i + 1 ?>" value="<?= $question ? $options[$i] : '' ?>"  required>
                        </div>
                    <?php endfor; ?>

                </fieldset>

                <div class="d-flex align-items-center mb-3">
                    <div class="flex-fill d-flex justify-content-start">
                        <button type="button" class="btn btn-outline-secondary" id="prev-question">Previous</button>
                    </div>

                    <div class="d-flex align-items-center gap-2 justify-content-center">
                        <label for="goto_number" class="visually-hidden">Go to question</label>
                        <input id="goto_number" type="number" class="form-control" placeholder="No.">
                        <button type="button" class="btn btn-outline-primary" id="goto-question">Go</button>
                    </div>

                    <div class="flex-fill d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary" id="next-question">Next</button>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary" id="new-question">New Question</button>
                    <button type="button" class="btn btn-secondary" id="go-back">Back to quiz</button>
                </div>

            </form>
        </div>
    </div>
</div>
