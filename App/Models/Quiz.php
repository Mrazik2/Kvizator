<?php

namespace App\Models;

use Framework\Core\Model;

class Quiz extends Model
{
    protected ?int $id;
    protected ?string $title;
    protected ?string $description;
    protected ?string $topic;
    protected ?string $difficulty;
    protected ?int $published;

    protected ?int $creatorId;
    protected ?string $questionCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(?string $topic): void
    {
        $this->topic = $topic;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(?string $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function getCreatorId(): ?int
    {
        return $this->creatorId;
    }

    public function setCreatorId(?int $creatorId): void
    {
        $this->creatorId = $creatorId;
    }

    public function getQuestionCount(): ?string
    {
        return $this->questionCount;
    }

    public function setQuestionCount(?string $questionCount): void
    {
        $this->questionCount = $questionCount;
    }

    public function getPublished(): ?int
    {
        return $this->published;
    }

    public function setPublished(?int $published): void
    {
        $this->published = $published;
    }


}