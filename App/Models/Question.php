<?php

namespace App\Models;

use Framework\Core\Model;

class Question extends Model
{
    protected ?int $id;
    protected ?int $number;
    protected ?string $question;
    protected ?string $answer1;
    protected ?string $answer2;
    protected ?string $answer3;
    protected ?string $answer4;
    protected ?int $answer;
    protected ?int $quizId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): void
    {
        $this->question = $question;
    }

    public function getAnswer1(): ?string
    {
        return $this->answer1;
    }

    public function setAnswer1(?string $answer1): void
    {
        $this->answer1 = $answer1;
    }

    public function getAnswer2(): ?string
    {
        return $this->answer2;
    }

    public function setAnswer2(?string $answer2): void
    {
        $this->answer2 = $answer2;
    }

    public function getAnswer3(): ?string
    {
        return $this->answer3;
    }

    public function setAnswer3(?string $answer3): void
    {
        $this->answer3 = $answer3;
    }

    public function getAnswer4(): ?string
    {
        return $this->answer4;
    }

    public function setAnswer4(?string $answer4): void
    {
        $this->answer4 = $answer4;
    }

    public function getAnswer(): ?int
    {
        return $this->answer;
    }

    public function setAnswer(?int $answer): void
    {
        $this->answer = $answer;
    }

    public function getQuizId(): ?int
    {
        return $this->quizId;
    }

    public function setQuizId(?int $quizId): void
    {
        $this->quizId = $quizId;
    }

}