<?php
/** @var \App\Models\Attempt[] $attempts */
/** @var \Framework\Support\LinkGenerator $link */

use App\Models\Quiz;
use App\Models\User;

?>

<div class="container my-4">
    <div class="row g-3">
        <?php if (empty($attempts)): ?>
            <div class="col-12">
                <div class="alert alert-info mb-0">No attempts found.</div>
            </div>
        <?php else: ?>
            <?php foreach ($attempts as $attempt): ?>
                <?php
                $quiz = Quiz::getOne($attempt->getQuizId());
                $id = $quiz->getId();
                $title = htmlspecialchars($quiz->getTitle(), ENT_QUOTES, 'UTF-8');
                $desc = $quiz->getDescription();
                $descEsc = $desc ? nl2br(htmlspecialchars($desc, ENT_QUOTES, 'UTF-8')) : '<small class="text-muted">No description</small>';
                $username = User::getOne($quiz->getCreatorId())?->getUsername() ?? 'Unknown';
                $usernameEsc = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
                $qCount = (int)$quiz->getQuestionCount();
                $cCount = (int)$attempt->getCorrectCount();

                $topic = method_exists($quiz, 'getTopic') ? $quiz->getTopic() : null;
                $topicEsc = $topic ? htmlspecialchars($topic, ENT_QUOTES, 'UTF-8') : '';

                $difficultyRaw = method_exists($quiz, 'getDifficulty') ? strtolower((string)$quiz->getDifficulty()) : 'unknown';
                switch ($difficultyRaw) {
                    case 'easy':
                        $diffClass = 'bg-success text-white';
                        $diffLabel = 'Easy';
                        break;
                    case 'medium':
                    case 'intermediate':
                        $diffClass = 'bg-warning text-dark';
                        $diffLabel = 'Medium';
                        break;
                    case 'hard':
                        $diffClass = 'bg-danger text-white';
                        $diffLabel = 'Hard';
                        break;
                    default:
                        $diffClass = 'bg-secondary text-white';
                        $diffLabel = ucfirst($difficultyRaw ?: 'Unknown');
                        break;
                }

                $resultUrl = $link->url('attempt.result', ['attemptId' => $attempt->getId()]);
                ?>
                <div class="col-12 col-md-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="text-start">
                                    <?php if ($topicEsc): ?>
                                        <small class="text-muted"><?= $topicEsc ?></small>
                                    <?php else: ?>
                                        <small class="text-muted">General</small>
                                    <?php endif; ?>
                                </div>

                                <div class="text-end">
                                    <small class="<?= $diffClass ?> px-2 py-1 rounded" style="font-size:0.8rem;"><?= htmlspecialchars($diffLabel, ENT_QUOTES, 'UTF-8') ?></small>
                                </div>
                            </div>

                            <h5 class="card-title mb-2">
                                <span class="text-dark fw-semibold"><?= $title ?></span>
                            </h5>

                            <p class="card-text text-muted mb-3" style="flex:1; overflow:hidden;">
                                <?= $descEsc ?>
                            </p>

                        </div>

                        <div class="card-footer bg-transparent border-0 mt-auto py-3">
                            <div class="mb-2">
                                <span class="text-secondary"><?= $cCount ?>/<?= $qCount ?> <?= $qCount === 1 ? 'question' : 'questions' ?> correct</span>
                            </div>

                            <div>
                                <small class="text-secondary">By: <?= $usernameEsc ?></small>
                            </div>

                            <div class="row g-2">
                                <div class="col-12">
                                    <a href="<?= $resultUrl ?>" class="btn btn-primary w-100" role="button" aria-label="show result <?= $title ?>">Show Result</a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

