<?php

namespace App\Models;

use Framework\Core\Model;

class Question extends Model
{
    protected ?int $id;
    protected ?int $number;
    protected ?string $question;
    protected ?string $option1;
    protected ?string $option2;
    protected ?string $option3;
    protected ?string $option4;
    protected ?int $optionNum;
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

    public function getOption1(): ?string
    {
        return $this->option1;
    }

    public function setOption1(?string $option1): void
    {
        $this->option1 = $option1;
    }

    public function getOption2(): ?string
    {
        return $this->option2;
    }

    public function setOption2(?string $option2): void
    {
        $this->option2 = $option2;
    }

    public function getOption3(): ?string
    {
        return $this->option3;
    }

    public function setOption3(?string $option3): void
    {
        $this->option3 = $option3;
    }

    public function getOption4(): ?string
    {
        return $this->option4;
    }

    public function setOption4(?string $option4): void
    {
        $this->option4 = $option4;
    }

    public function getOptionNum(): ?int
    {
        return $this->optionNum;
    }

    public function setOptionNum(?int $optionNum): void
    {
        $this->optionNum = $optionNum;
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