<?php

namespace App\Models;

use Framework\Core\Model;

class Attempt extends Model
{
    protected ?int $id;
    protected ?int $userId;
    protected ?int $quizId;
    protected ?int $correctCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function getQuizId(): ?int
    {
        return $this->quizId;
    }

    public function setQuizId(?int $quizId): void
    {
        $this->quizId = $quizId;
    }

    public function getCorrectCount(): ?int
    {
        return $this->correctCount;
    }

    public function setCorrectCount(?int $correctCount): void
    {
        $this->correctCount = $correctCount;
    }
}
