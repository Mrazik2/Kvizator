<?php
/** @var \App\Models\Quiz[] $quizzes */
/** @var \Framework\Support\LinkGenerator $link */
/** @var string $filter */
/** @var string $message */
?>

<div class="container my-4">
    <div class="row g-3">

        <div class="col-12">
            <?php
            $currentFilter = $filter ?? 'unpublished';
            $urlUnpublished = $link->url('quiz.own', ['filter' => 'unpublished']);
            $urlPublished = $link->url('quiz.own', ['filter' => 'published']);
            ?>
            <div class="btn-group mb-3" role="group" aria-label="Quiz filter">
                <a href="<?= $urlUnpublished ?>" class="btn <?= $currentFilter !== 'published' ? 'btn-primary' : 'btn-outline-secondary' ?>">Unpublished</a>
                <a href="<?= $urlPublished ?>" class="btn <?= $currentFilter === 'published' ? 'btn-primary' : 'btn-outline-secondary' ?>">Published</a>
            </div>
        </div>
        <?php if ($message && $message !== ''): ?>
            <div class="text-center text-danger mb-3" id="message">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <?php if (empty($quizzes)): ?>
            <div class="col-12">
                <div class="alert alert-info mb-0">No quizzes found for the selected filter.</div>
            </div>
        <?php else: ?>
            <?php foreach ($quizzes as $quiz): ?>
                <?php
                $id = $quiz->getId();
                $title = htmlspecialchars($quiz->getTitle(), ENT_QUOTES, 'UTF-8');
                $desc = $quiz->getDescription();
                $descEsc = $desc ? nl2br(htmlspecialchars($desc, ENT_QUOTES, 'UTF-8')) : '<small class="text-muted">No description</small>';
                $qCount = (int)$quiz->getQuestionCount();

                // Topic and difficulty
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

                $editUrl = $link->url('quiz.edit', ['id' => $id]);
                $deleteUrl = $link->url('quiz.delete', ['id' => $id, 'filter' => $currentFilter]);
                $publishUrl = $link->url('quiz.publish', ['id' => $id, 'filter' => $currentFilter]);
                $viewStatsUrl = $link->url('quiz.stats', ['id' => $id]);
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
                                <span class="text-secondary"><?= $qCount ?> <?= $qCount === 1 ? 'question' : 'questions' ?></span>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="<?= $editUrl ?>" class="btn btn-primary w-100" role="button" aria-label="Edit quiz <?= $title ?>">Edit Quiz</a>
                                </div>
                                <div class="col-6">
                                    <form action="<?= $deleteUrl ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger w-100">Delete Quiz</button>
                                    </form>
                                </div>
                                <?php if ($qCount > 0 && $quiz->getPublished() === 0): ?>
                                <div class="col-12">
                                    <a href="<?= $publishUrl ?>" class="btn btn-success w-100">Publish Quiz</a>
                                </div>
                                <?php endif; ?>
                                <?php if ($quiz->getPublished() === 1): ?>
                                    <div class="col-12">
                                        <a href="<?= $viewStatsUrl ?>" class="btn btn-success w-100">View Quiz Stats</a>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

