<?php

namespace App\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\EmptyResponse;
use Framework\Http\Responses\Response;

class QuestionController extends BaseController
{

    public function authorize(Request $request, string $action): bool
    {
        if ($action === 'edit' && $request->hasValue('id') && Quiz::getOne($request->value('id'))?->getPublished() === 1) {
            return false;
        }
        return true;
    }

    public function index(Request $request): Response
    {
        return $this->redirect($this->url('question.edit'));
    }

    public function edit(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
            $question = Question::getAll("quizId = ? AND number = ?", [$data->quizId, $data->number])[0] ?? null;
            if ($question !== null) {
                return $this->json([
                    'questionText' => $question->getQuestion(),
                    'answers' => [
                        $question->getAnswer1(),
                        $question->getAnswer2(),
                        $question->getAnswer3(),
                        $question->getAnswer4()
                    ],
                    'correct' => $question->getAnswer()
                ]);
            } else {
                throw new \Exception("Otazka nenajdena.");
            }
        }

        $quizId = $request->hasValue('id') ? $request->value('id') : null;
        $questionCount = Quiz::getOne($quizId)->getQuestionCount();
        $questionCount = $questionCount > 0 ? $questionCount : 1;
        $question = Question::getAll("quizId = ? AND number = ?", [$quizId, 1])[0] ?? null;
        return $this->html(compact('quizId', 'question', 'questionCount'));
    }

    public function save(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
            $quizId = $data->quizId;
            $number = $data->number;
            $questionText = $data->questionText;
            $answers = $data->answers;
            $correct = $data->correct;

            $question = Question::getAll("quizId = ? AND number = ?", [$quizId, $number])[0] ?? new Question();
            $question->setQuizId($quizId);
            $question->setNumber($number);
            $question->setQuestion($questionText);
            $question->setAnswer1($answers[0]);
            $question->setAnswer2($answers[1]);
            $question->setAnswer3($answers[2]);
            $question->setAnswer4($answers[3]);
            $question->setAnswer($correct);
            $question->save();

            $quiz = Quiz::getOne($quizId);
            if ($quiz !== null && $number > $quiz->getQuestionCount()) {
                $quiz->setQuestionCount($number);
                $quiz->save();
            }

            return new EmptyResponse();
        }
        throw new \Exception("Chyba pri ukladani otazky.");
    }

    public function delete(Request $request): Response
    {
        if ($request->isAjax()) {
            $data = $request->json();
            $quizId = $data->quizId;
            $number = $data->number;

            $question = Question::getAll("quizId = ? AND number = ?", [$quizId, $number])[0] ?? null;
            if ($question !== null) {
                $question->delete();

                $subsequentQuestions = Question::getAll("quizId = ? AND number > ?", [$quizId, $number]);
                foreach ($subsequentQuestions as $subQuestion) {
                    $subQuestion->setNumber($subQuestion->getNumber() - 1);
                    $subQuestion->save();
                }

                $quiz = Quiz::getOne($quizId);
                if ($quiz !== null) {
                    $quiz->setQuestionCount($quiz->getQuestionCount() - 1);
                    $quiz->save();
                }
            }

            return new EmptyResponse();
        }
        throw new \Exception("Chyba pri mazani otazky.");
    }
}