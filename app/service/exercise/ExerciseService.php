<?php

require_once __DIR__ . "/../../model/exercise/Exercise.php";
require_once __DIR__ . "/../../service/ServiceInterface.php";
require_once __DIR__ . "/../../repository/exercise/ExerciseRepository.php";
require_once __DIR__ . "/../../exception/ValidationException.php";
require_once __DIR__ . "/../../exception/exercise/InvalidExerciseNameException.php";
require_once __DIR__ . "/../../exception/exercise/InvalidExerciseDifficultyException.php";
require_once __DIR__ . "/../../exception/exercise/InvalidExerciseTypeException.php";
require_once __DIR__ . "/../../exception/exercise/InvalidExerciseDescriptionException.php";
require_once __DIR__ . "/../../exception/exercise/InvalidExerciseMuscleGroupException.php";

class ExerciseService implements ServiceInterface
{
    private ExerciseRepository $exerciseRepository;
    public function __construct()
    {
        $this->exerciseRepository = new ExerciseRepository();
    }

    public function insert(array $data): bool
    {
        try {
            $exercise = $this->createExercise($data);
            $newId = $this->exerciseRepository->insert($exercise);
            return $newId !== null;
        } catch (ValidationException $e) {
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $exercise = $this->createExercise($data);
            return $this->exerciseRepository->update($id, $exercise);
        } catch (ValidationException $e) {
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }

    public function delete(int $id): bool
    {
        return $this->exerciseRepository->delete($id);
    }

    public function selectAll(int $trainer_id = null): array
    {
        return $this->exerciseRepository->selectAll($trainer_id);
    }

    private function createExercise(array $data): Exercise
    {
        $this->validateExerciseData($data);
        $exercise = new Exercise();
        $exercise->setName($data['exercise_name']);
        $exercise->setExerciseType($data['exercise_type']);
        $exercise->setDescription($data['description']);
        $exercise->setMuscleGroupId($data['muscle_group']);
        $exercise->setDifficulty($data['difficulty']);

        $exercise->setTrainerId($_SESSION['user_id']);
        return $exercise;
    }

    private function validateExerciseData(array $data): void
    {
        if (empty($data['exercise_name']) || strlen(trim($data['exercise_name'])) < 3)
            throw new InvalidExerciseNameException();
        if (empty($data['exercise_type']))
            throw new InvalidExerciseTypeException();
        if (empty($data['description']))
            throw new InvalidExerciseDescriptionException();
        if (empty($data['muscle_group']))
            throw new InvalidExerciseMuscleGroupException();
        if (empty($data['difficulty']))
            throw new InvalidExerciseDifficultyException();
    }
}