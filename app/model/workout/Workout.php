<?php

class Workout
{
    private string $name;
    private string $description;

    private int $studentId;

    private int $trainerId;

    private string $createdAt;

    private string $updateAt;

    public function __construct()
    {
        $this->createdAt = date("Y-m-d H:i:s");
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function setStudentId(int $studentId): void
    {
        $this->studentId = $studentId;
    }

    public function getTrainerId(): int
    {
        return $this->trainerId;
    }

    public function setTrainerId(int $trainerId): void
    {
        $this->trainerId = $trainerId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updateAt;
    }

    public function setUpdatedAt(): void
    {
        $this->updateAt = date("Y-m-d H:i:s");
    }
}
