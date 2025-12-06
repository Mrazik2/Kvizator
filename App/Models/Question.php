<?php

namespace App\Models;

use Framework\Core\Model;

class Question extends Model
{
    protected ?int $id;
    protected ?int $number;
    protected ?string $text;
    protected ?string $answer;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): void
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