<?php
/** @var int $attemptId */
/** @var \App\Models\Quiz $quiz */
/** @var int|float $betterThanPercent */
/** @var int $correctCount */
/** @var int $liked */
/** @var \Framework\Support\LinkGenerator $link */

$percent = round(($correctCount / $quiz->getQuestionCount()) * 100, 2);

?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <div class="card" id="resultCard">

                <input type="hidden" name="quizId" id="quizId" value="<?= $quiz->getId() ?>">
                <input type="hidden" name="liked" id="liked" value="<?= $liked ?>">

                <div class="card-body text-center">
                    <h2 class="card-title">Quiz results</h2>

                    <p class="lead mb-1"><?= htmlspecialchars($quiz->getTitle()) ?></p>
                    <p class="lead mb-1">You answered <strong><?= htmlspecialchars($correctCount) ?></strong> of <strong><?= htmlspecialchars($quiz->getQuestionCount()) ?></strong> questions correctly.</p>

                    <div class="progress mb-3" id="progressDiv">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100"><?= $percent ?>%</div>
                    </div>

                    <p class="mb-3">You performed better than <strong><?= $betterThanPercent ?>%</strong> of users who took this quiz.</p>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="<?= $link->url('attempt.answer', ['attemptId' => $attemptId]) ?>" class="btn btn-secondary">Answers</a>
                        <button type="button" class="btn btn-outline-secondary" id="like-button"></button>
                        <a href="<?= $link->url('home.index') ?>" class="btn btn-outline-primary">Home</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
