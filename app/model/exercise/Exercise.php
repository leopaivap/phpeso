<?php

class Exercise
{
    private string $name;
    private string $exercise_type;
    private int $muscle_group_id;
    private string $difficulty;
    private string $description;
    private string $createdAt;

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

    public function getExerciseType(): string
    {
        return $this->exercise_type;
    }

    public function setExerciseType(string $type): void
    {
        $this->exercise_type = $type;
    }

    public function getMuscleGroupId(): int
    {
        return $this->muscle_group_id;
    }

    public function setMuscleGroupId(int $id): void
    {
        $this->muscle_group_id = $id;
    }

    public function getDifficulty(): string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
