<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Question;
use App\Models\Quiz;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\EmptyResponse;
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
            $question = Question::getAll("quizId = ? AND number = ?", [Attempt::getOne($data->attemptId)->getQuizId(), $data->number])[0] ?? null;
            if ($question !== null) {
                return $this->json([
                    'questionText' => $question->getQuestion(),
                    'answers' => [
                        $question->getAnswer1(),
                        $question->getAnswer2(),
                        $question->getAnswer3(),
                        $question->getAnswer4()
                    ],
                    'chosen' => Answer::getAll("attemptId = ? AND number = ?", [$data->attemptId, $data->number])[0]->getChosen()
                ]);
            } else {
                throw new \Exception("Otazka nenajdena.");
            }

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
            $attempt = Attempt::getOne($data->attemptId);
            if ($attempt !== null) {
                $attempt->delete();
                return new EmptyResponse();
            } else {
                throw new \Exception("Pokus nenajdeny.");
            }
        }
        throw new \Exception("Request nie je ajax.");
    }

    public function save(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
            $answer = Answer::getAll("attemptId = ? AND number = ?", [$data->attemptId, $data->number])[0] ?? null;
            if ($answer !== null) {
                $answer->setChosen($data->chosen);
                $answer->save();
                return new EmptyResponse();
            } else {
                throw new \Exception("Odpoved nenajdena.");
            }
        }
        throw new \Exception("Request nie je ajax.");
    }

    public function results(Request $request): Response
    {
        return $this->redirect($this->url('home.index'));
    }
}