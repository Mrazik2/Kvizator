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
        $quizId = $request->hasValue('id') ? $request->value('id') : null;
        $questionCount = Quiz::getOne($quizId)?->getQuestionCount() ?? 0;
        $question = Question::getAll("quizId = ? AND number = ?", [$quizId, 1])[0] ?? null;
        if ($quizId === null || $questionCount === 0 || $question === null) {
            return $this->redirect($this->url('home.index'));
        }
        return $this->html(compact('question', 'quizId', 'questionCount'));
    }
}