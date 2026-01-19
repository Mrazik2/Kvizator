<?php

namespace App\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\EmptyResponse;
use Framework\Http\Responses\Response;
use App\Models\Question;

class QuizController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        if ($action === 'others') {
            return true;
        }
        if ($action === 'question' && $request->hasValue('id') && Quiz::getOne($request->value('id'))?->getPublished() === 1) {
            return false;
        }
        return $this->user->isLoggedIn();
    }

    public function index(Request $request): Response
    {
        return $this->redirect($this->url("quiz.edit"));
    }

    public function edit(Request $request): Response
    {
        $quiz = null;

        if ($request->hasValue('id')) {
            $quizId = $request->value('id');
            if (is_numeric($quizId)) {
                $found = Quiz::getOne($quizId);
                if ($found !== null) {
                    $quiz = $found;
                }
            }
        }
        return $this->html(compact('quiz'));
    }

    public function save(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
            $title = $data->title;
            $topic = $data->topic;
            $difficulty = $data->difficulty;
            $description = $data->description;
            $quizId = $data->quizId;
            $quiz = $quizId !== "-1" ? Quiz::getOne((int)$quizId) : new Quiz();
            $quiz->setTitle($title);
            $quiz->setTopic($topic);
            $quiz->setDifficulty($difficulty);
            $quiz->setDescription($description);
            if ($quizId === "-1") {
                $quiz->setPublished(0);
                $quiz->setCreatorId($this->user->getIdentity()->getId());
                $quiz->setQuestionCount(0);
            }
            $quiz->save();

            return $this->json(['quizId' => $quiz->getId()]);
        }
        return $this->redirect($this->url("quiz.edit"));
    }

    public function delete(Request $request): Response {
        if ($request->hasValue('id')) {
            $id = $request->value('id');
            if (is_numeric($id)) {
                $quiz = Quiz::getOne($id);
                if ($quiz !== null) {
                    $quiz->delete();
                }
            }
        }
        $filter = $request->hasValue('filter') ? $request->value('filter') : 'unpublished';
        return $this->redirect($this->url("quiz.own", ['filter' => $filter, 'message' => '']));
    }

    public function publish(Request $request): Response {
        $message = '';
        if ($request->hasValue('id')) {
            $id = $request->value('id');
            if (is_numeric($id)) {
                $quiz = Quiz::getOne($id);
                if ($quiz !== null && $quiz->getQuestionCount() > 0) {
                    $questions = Question::getAll("quizId = ?", [$quiz->getId()]);
                    $ok = true;
                    foreach ($questions as $question) {
                        if ($question->getQuestion() === null || trim($question->getQuestion()) === '') {
                            $ok = false;
                            break;
                        }
                        $emptyCount = 0;
                        $answers = [
                            $question->getAnswer1(),
                            $question->getAnswer2(),
                            $question->getAnswer3(),
                            $question->getAnswer4()
                        ];
                        for ($i = 0; $i < 4; $i++) {
                            if ($answers[$i] === null || trim($answers[$i]) === '') {
                                if ( ($i + 1) === $question->getAnswer() ) {
                                    $ok = false;
                                }
                                $emptyCount++;
                            }
                        }
                        if ($emptyCount > 2) {
                            $ok = false;
                        }
                        if (!$ok) {
                            break;
                        }
                    }
                    if ($ok) {
                        $quiz->setPublished(1);
                        $quiz->save();
                    } else {
                        $message = 'Nie všetky otázky sú správne vyplnené.';
                    }
                }
            }
        }
        $filter = $request->hasValue('filter') ? $request->value('filter') : 'unpublished';
        return $this->redirect($this->url("quiz.own", ['filter' => $filter, 'message' => $message]));
    }

    public function others(Request $request): Response {
        if ($this->user->isLoggedIn()) {
            $quizzes = Quiz::getAll("creatorId <> ?", [$this->user->getIdentity()->getId()]);
        } else {
            $quizzes = Quiz::getAll();
        }
        return $this->html(compact('quizzes'));
    }

    public function own(Request $request): Response {
        $filter = $request->hasValue('filter') ? $request->value('filter') : 'unpublished';
        $userId = $this->user->getIdentity()->getId();
        $message = $request->hasValue('message') ? $request->value('message') : '';

        if ($filter === 'published') {
            // only published quizzes
            $quizzes = Quiz::getAll("creatorId = ? AND published = ?", [$userId, 1]);
        } else {
            // default: only unpublished (published = 0 or NULL)
            $quizzes = Quiz::getAll("creatorId = ? AND published = ?", [$userId, 0]);
        }

        return $this->html(compact('quizzes', 'filter', 'message'));
    }
}
