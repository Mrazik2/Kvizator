<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Like;
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

    public function evaluate(Request $request): Response
    {
        $attempt = $request->hasValue('attemptId') ? Attempt::getOne($request->value('attemptId')) : null;
        if ($attempt === null) {
            return $this->redirect($this->url('home.index'));
        }
        $answers = Answer::getAll("attemptId = ?", [$attempt->getId()]);
        $questions = Question::getAll("quizId = ?", [$attempt->getQuizId()]);
        if (count($answers) !== count($questions)) {
            return $this->redirect($this->url('home.index'));
        }
        $correctCount = 0;
        for ($i = 0; $i < count($answers); $i++) {
            if ($answers[$i]->getChosen() === $questions[$i]->getAnswer()) {
                $answers[$i]->setCorrect(1);
                $correctCount++;
            }
            $answers[$i]->save();
        }
        $attempt->setCorrectCount($correctCount);
        $attempt->save();

        return $this->redirect($this->url('attempt.result', ['attemptId' => $attempt->getId()]));
    }

    public function result(Request $request): Response
    {
        $attemptId = $request->hasValue('attemptId') ? $request->value('attemptId') : null;
        $attempt = Attempt::getOne($attemptId);
        $correctCount = $attempt->getCorrectCount();
        $quiz = Quiz::getOne($attempt->getQuizId());
        $allAttempts = Attempt::getCount("quizId = ? AND id <> ?", [$quiz->getId(), $attemptId]);
        $worseAttempts = Attempt::getCount("quizId = ? AND correctCount < ?", [$quiz->getId(), $correctCount]);
        $betterThanPercent = $allAttempts > 0 ? round(($worseAttempts / $allAttempts) * 100, 2) : 100.0;
        $liked = $this->user->isLoggedIn() ? Like::getCount("quizId = ? AND userId = ?", [$quiz->getId(), $this->user->getIdentity()->getId()]) : 0;

        return $this->html(compact('attemptId', 'quiz', 'correctCount', 'betterThanPercent', 'liked'));
    }

    public function like(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
            if ($this->user->isLoggedIn()) {
                $like = Like::getCount("quizId = ? AND userId = ?", [$data->quizId, $this->user->getIdentity()->getId()]) === 0 ? new Like() : null;
                if ($like !== null) {
                    $like->setQuizId($data->quizId);
                    $like->setUserId($this->user->getIdentity()->getId());
                    $like->save();
                    return new EmptyResponse();
                } else {
                    throw new \Exception("Uzivatel uz lajkol tento quiz.");
                }
            } else {
                throw new \Exception("Uzivatel nie je prihlaseny.");
            }
        } else {
            throw new \Exception("Request nie je ajax.");
        }
    }

    public function unlike(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
            if ($this->user->isLoggedIn()) {
                $like = Like::getAll("quizId = ? AND userId = ?", [$data->quizId, $this->user->getIdentity()->getId()])[0] ?? null;
                if ($like !== null) {
                    $like->delete();
                    return new EmptyResponse();
                } else {
                    throw new \Exception("Uzivatel este nelajkol tento quiz.");
                }
            } else {
                throw new \Exception("Uzivatel nie je prihlaseny.");
            }
        } else {
            throw new \Exception("Request nie je ajax.");
        }
    }

    public function answer(Request $request): Response
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
                    'chosen' => Answer::getAll("attemptId = ? AND number = ?", [$data->attemptId, $data->number])[0]->getChosen(),
                    'correct' => $question->getAnswer()
                ]);
            } else {
                throw new \Exception("Otazka nenajdena.");
            }
        }

        $attemptId = $request->hasValue('attemptId') ? $request->value('attemptId') : null;
        $attempt = Attempt::getOne($attemptId);
        if ($attempt === null) {
            return $this->redirect($this->url('home.index'));
        }
        $questionCount = Quiz::getOne($attempt->getQuizId())->getQuestionCount();
        $question = Question::getAll("quizId = ? AND number = ?", [$attempt->getQuizId(), 1])[0];
        $chosen = Answer::getAll("attemptId = ? AND number = ?", [$attemptId, 1])[0]->getChosen();
        return $this->html(compact('question', 'attemptId', 'questionCount', 'chosen'));
    }
}