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
        return $this->redirect($this->url("quiz.own", ['filter' => $filter]));
    }

    public function publish(Request $request): Response {
        if ($request->hasValue('id')) {
            $id = $request->value('id');
            if (is_numeric($id)) {
                $quiz = Quiz::getOne($id);
                if ($quiz !== null && $quiz->getQuestionCount() > 0) {
                    $quiz->setPublished(1);
                    $quiz->save();
                }
            }
        }
        $filter = $request->hasValue('filter') ? $request->value('filter') : 'unpublished';
        return $this->redirect($this->url("quiz.own", ['filter' => $filter]));
    }

    public function question(Request $request): Response {
        if ($request->isAjax()) {
            $data = $request->json();
        }

        $quizId = $request->hasValue('id') ? $request->value('id') : null;
        $questionCount = Quiz::getOne($quizId)->getQuestionCount();
        $questionCount = $questionCount > 0 ? $questionCount : 1;
        $question = Question::getAll("quizId = ? AND number = ?", [$quizId, 1])[0] ?? null;
        return $this->html(compact('quizId', 'question', 'questionCount'));
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

        if ($filter === 'published') {
            // only published quizzes
            $quizzes = Quiz::getAll("creatorId = ? AND published = ?", [$userId, 1]);
        } else {
            // default: only unpublished (published = 0 or NULL)
            $quizzes = Quiz::getAll("creatorId = ? AND published = ?", [$userId, 0]);
        }

        return $this->html(compact('quizzes', 'filter'));
    }
}