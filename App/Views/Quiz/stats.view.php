<?php
/** @var \App\Models\Quiz $quiz */
/** @var int|float $averageCorrect */
/** @var int $likedCount */
/** @var int $attemptsCount */
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <div class="card" id="resultCard">

                <div class="card-body text-center">
                    <h2 class="card-title">Quiz stats</h2>

                    <p class="lead mb-1"><?= htmlspecialchars($quiz->getTitle()) ?></p>
                    <p class="mb-1">Your quiz was played <?= $attemptsCount ?> times.</p>
                    <p class="mb-1">Average percentage of correct answers:</p>

                    <div class="progress mb-3" id="progressDiv">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $averageCorrect ?>%" aria-valuenow="<?= $averageCorrect ?>" aria-valuemin="0" aria-valuemax="100"><?= $averageCorrect ?>%</div>
                    </div>

                    <p class="mb-3">Your quiz was liked <?= $likedCount ?> times!</p>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="<?= $link->url('quiz.own') ?>" class="btn btn-outline-primary">Back</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
