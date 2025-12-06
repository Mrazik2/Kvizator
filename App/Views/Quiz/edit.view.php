<?php

/** @var \App\Models\Quiz|null $quiz */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('editQuiz');
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3" id="formType"><?= $quiz ? 'Editovať kvíz' : 'Vytvoriť kvíz' ?></h4>
                    <form class="form-edit" method="post" action="<?= $link->url('quiz.save') ?>">

                        <?php if ($quiz && $quiz->getId()): ?>
                            <input type="hidden" name="id" value="<?= (int)$quiz->getId() ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="title" class="form-label">Názov</label>
                            <input id="title" name="title" type="text" class="form-control" required
                                   value="<?= $quiz && $quiz->getTitle() ? htmlspecialchars($quiz->getTitle(), ENT_QUOTES, 'UTF-8') : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Popis</label>
                            <textarea id="description" name="description" class="form-control" rows="4"><?= $quiz && $quiz->getDescription() ? htmlspecialchars($quiz->getDescription(), ENT_QUOTES, 'UTF-8') : '' ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="topic" class="form-label">Téma</label>
                                <input id="topic" name="topic" type="text" class="form-control" required
                                       value="<?= $quiz && $quiz->getTopic() ? htmlspecialchars($quiz->getTopic(), ENT_QUOTES, 'UTF-8') : '' ?>">
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label for="difficulty" class="form-label">Obtiažnosť</label>
                                <select id="difficulty" name="difficulty" class="form-select">
                                    <?php
                                    $current = $quiz && $quiz->getDifficulty() ? strtolower($quiz->getDifficulty()) : '';
                                    $options = [
                                        'easy' => 'Ľahká',
                                        'medium' => 'Stredná',
                                        'hard' => 'Ťažká',
                                    ];
                                    foreach ($options as $val => $label) {
                                        $sel = $val === $current ? ' selected' : '';
                                        echo "<option value=\"$val\"$sel>$label</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <!-- Save: always enabled -->
                                <button type="submit" name="save" value="save" class="btn btn-primary">Uložiť</button>

                                <!-- Finish: only enabled after quiz is saved (has id) -->
                                <button type="submit" name="finish" value="finish" class="btn btn-success ms-2">Dokončiť</button>
                            </div>

                            <div>
                                <!-- Edit questions: show as link; enabled only when quiz has an id -->
                                <a href="<?= $link->url('nic.nic', ['id' => $quiz?->getId()]) ?>" class="btn btn-outline-secondary ms-2" id="upravOtazky">Upraviť otázky</a>

                                <!-- Cancel: go back to home (adjust route if you prefer) -->
                                <a href="<?= $link->url('quiz.own') ?>" class="btn btn-link ms-2" onclick="return confirm('Naozaj chcete zrušiť? Neuložené zmeny sa stratia.');">Zrušiť</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
