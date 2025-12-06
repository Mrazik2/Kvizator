<?php

namespace App\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class QuizController extends BaseController
{

    public function index(Request $request): Response
    {
        return $this->redirect($this->url("creation.edit"));
    }

    public function edit(Request $request): Response
    {
        $quiz = null;

        // expect 'quiz' param to be an id (sent after save)
        if ($request->hasValue('id')) {
            $quizId = $request->value('id');
            if (is_numeric($quizId)) {
                $found = Quiz::getAll("id = ?", [(int)$quizId]);
                if (!empty($found)) {
                    $quiz = $found[0];
                }
            }
        }

        return $this->html(compact('quiz'));
    }

    public function save(Request $request): Response
    {
        if ($request->hasValue('save')) {
            $title = $request->value('title');
            $topic = $request->value('topic');
            $difficulty = $request->value('difficulty');
            $description = $request->hasValue('description') ? $request->value('description') : '';
            $quiz = $request->hasValue('id') ? Quiz::getOne($request->value('id')) : new Quiz();
            $quiz->setTitle($title);
            $quiz->setTopic($topic);
            $quiz->setDifficulty($difficulty);
            $quiz->setDescription($description);
            $quiz->setCreatorId(User::getAll("username = ?", [$this->user->getName()])[0]->getId());
            $quiz->setQuestionCount(0);
            $quiz->save();

            // redirect using the saved quiz id (not the whole object)
            return $this->redirect($this->url("quiz.edit", ['quiz' => $quiz->getId()]));
        } else if ($request->hasValue('finish')) {
            return $this->redirect($this->url("quiz.own"));
        }
        return $this->redirect($this->url("quiz.edit"));
    }

    public function delete(Request $request): Response {
        if ($request->hasValue('id')) {
            $id = $request->value('id');
            if (is_numeric($id)) {
                $quiz = Quiz::getOne((int)$id);
                if (!empty($quiz)) {
                    $quiz->delete();
                }
            }
        }
        return $this->redirect($this->url("quiz.own"));
    }

    public function others(Request $request): Response {
        if ($this->user->isLoggedIn()) {
            $quizzes = Quiz::getAll("creatorId <> ?", [User::getAll("username = ?", [$this->user->getName()])[0]->getId()]);
        } else {
            $quizzes = Quiz::getAll();
        }
        return $this->html(compact('quizzes'));
    }

    public function own(Request $request): Response {
        $quizzes = Quiz::getAll("creatorId = ?", [User::getAll("username = ?", [$this->user->getName()])[0]->getId()]);
        return $this->html(compact('quizzes'));
    }
}