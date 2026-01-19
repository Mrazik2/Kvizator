<?php

/** @var \App\Models\Quiz|null $quiz */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3" id="formType"><?= $quiz ? 'Edit quiz' : 'Create quiz' ?></h4>
                    <form class="quiz-edit" method="post" action="<?= $link->url('quiz.save') ?>">

                        <input type="hidden" name="id" value="<?= $quiz !== null ? $quiz->getId() : -1 ?>" id="quizId">

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input id="title" name="title" type="text" class="form-control" required
                                   value="<?= $quiz && $quiz->getTitle() ? htmlspecialchars($quiz->getTitle(), ENT_QUOTES, 'UTF-8') : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="4"><?= $quiz && $quiz->getDescription() ? htmlspecialchars($quiz->getDescription(), ENT_QUOTES, 'UTF-8') : '' ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="topic" class="form-label">Topic</label>
                                <input id="topic" name="topic" type="text" class="form-control" required
                                       value="<?= $quiz && $quiz->getTopic() ? htmlspecialchars($quiz->getTopic(), ENT_QUOTES, 'UTF-8') : '' ?>">
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label for="difficulty" class="form-label">Difficulty</label>
                                <select id="difficulty" name="difficulty" class="form-select">
                                    <?php
                                    $current = $quiz && $quiz->getDifficulty() ? strtolower($quiz->getDifficulty()) : '';
                                    $options = [
                                        'easy' => 'Easy',
                                        'medium' => 'Medium',
                                        'hard' => 'Hard',
                                    ];
                                    foreach ($options as $val => $label) {
                                        $sel = $val === $current ? ' selected' : '';
                                        echo "<option value=\"$val\"$sel>$label</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6 d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2">
                                <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>

                                <a href="<?= $link->url('quiz.own') ?>" class="btn btn-success ms-sm-2" id="finish">Finish</a>
                            </div>

                            <div class="col-6 d-flex flex-column flex-sm-row align-items-end align-items-sm-center justify-content-end gap-2">
                                <?php if (!$quiz || $quiz->getPublished() === 0): ?>
                                    <a href="<?= $link->url('question.edit', ['id' => $quiz?->getId()]) ?>" class="btn btn-outline-secondary" id="upravOtazky">Questions</a>
                                <?php endif; ?>

                                <a href="<?= $link->url('quiz.own') ?>" class="btn btn-link ms-sm-2" onclick="return confirm('Naozaj chcete zrušiť? Neuložené zmeny sa stratia.');">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
