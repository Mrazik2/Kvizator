<?php

namespace App\Models;

use Framework\Core\Model;

class Answer extends Model
{
    protected ?int $id;
    protected ?int $attemptId;
    protected ?int $number;
    protected ?int $chosen;
    protected ?int $correct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getAttemptId(): ?int
    {
        return $this->attemptId;
    }

    public function setAttemptId(?int $attemptId): void
    {
        $this->attemptId = $attemptId;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    public function getChosen(): ?int
    {
        return $this->chosen;
    }

    public function setChosen(?int $chosen): void
    {
        $this->chosen = $chosen;
    }

    public function getCorrect(): ?int
    {
        return $this->correct;
    }

    public function setCorrect(?int $correct): void
    {
        $this->correct = $correct;
    }
}