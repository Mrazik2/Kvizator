<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Attempt;
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
        $attempt = new Attempt();
        $attempt->setUserId($this->user->isLoggedIn() ? $this->user->getIdentity()->getId() : null);
        $attempt->setQuizId($quizId);
        $attempt->setCorrectCount(0);
        $attempt->save();
        $attemptId = $attempt->getId();

        for ($i = 0; $i < $quiz?->getQuestionCount(); $i++) {
            $answer = new Answer();
            $answer->setAttemptId($attemptId);
            $answer->setNumber($i + 1);
            $answer->setChosen(0);
            $answer->setCorrect(0);
            $answer->save();
        }

        return $this->html(compact('question', 'attemptId', 'questionCount'));
    }

    public function delete(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
        }
        throw new \Exception("Chyba pri ukladani otazky.");
    }

    public function save(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
        }
        throw new \Exception("Chyba pri ukladani otazky.");
    }

    public function results(Request $request): Response
    {
        return $this->redirect($this->url('home.index'));
    }
}