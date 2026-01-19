<?php

namespace App\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class AttemptController extends BaseController
{

    public function index(Request $request): Response
    {
        return $this->redirect($this->url('attempt.question'));
    }

    public function question(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
        }

        $quizId = $request->hasValue('id') ? $request->value('id') : null;
        if ($quizId === null) {
            return $this->redirect($this->url('home.index'));
        }
        $quiz = Quiz::getOne($quizId);
        $questionCount = $quiz?->getQuestionCount() ?? 0;
        $question = Question::getAll("quizId = ? AND number = ?", [$quizId, 1])[0] ?? null;
        if ($questionCount === 0 || $question === null) {
            return $this->redirect($this->url('home.index'));
        }


        return $this->html(compact('question', 'attemptId', 'questionCount'));
    }

    public function delete(Request $request): Response
    {
        return $this->redirect($this->url('home.index'));
    }

    public function save(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
        }
        return $this->redirect($this->url('home.index'));
    }

    public function results(Request $request): Response
    {
        return $this->redirect($this->url('home.index'));
    }
}