<?php

require_once "./app/model/exercise/Exercise.php";
require_once "./app/service/ServiceInterface.php";
require_once "./app/repository/exercise/ExerciseRepository.php";
require_once "./app/exception/exercise/InvalidExerciseNameException.php";
require_once "./app/exception/exercise/InvalidExerciseDifficultyException.php";
require_once "./app/exception/exercise/InvalidExerciseTypeException.php";
require_once "./app/exception/exercise/InvalidExerciseDescriptionException.php";
require_once "./app/exception/exercise/InvalidExerciseMuscleGroupException.php";

class ExerciseService implements ServiceInterface
{
    private ExerciseRepository $exerciseRepository;
    public function __construct()
    {
        $this->exerciseRepository = new ExerciseRepository();
    }

    public function insert(array $data): bool
    {
        $exercise = $this->createExercise($data);
        $response = false;

        if ($exercise !== null) {
            $response = $this->exerciseRepository->insert($exercise);
        }

        if ($response) return true;

        return false;
    }

    public function update(int $id, array $data): bool
    {
        $exercise = $this->createExercise($data);
        $response = false;

        if ($exercise != null) {
            $response = $this->exerciseRepository->update($id, $exercise);
        }

        if ($response) return true;

        return false;
    }

    public function delete(int $id): bool
    {
        $response = false;

        if ($id != null && !empty($id)) {
            $response = $this->exerciseRepository->delete($id);
        }

        if ($response) return true;

        return false;
    }

    public function selectAll(): array
    {
        $response = $this->exerciseRepository->selectAll();

        if (!empty($response) && $response != null) {
            return $response;
        }

        return [];
    }

    private function createExercise(array $data): Exercise | null
    {
        $isValidExerciseData = $this->validateExerciseData($data);

        if ($isValidExerciseData) {

            $exercise = new Exercise();
            $exercise->setName($data['exercise_name']);
            $exercise->setExerciseType($data['exercise_type']);
            $exercise->setDescription($data['description']);
            $exercise->setMuscleGroupId($data['muscle_group']);
            $exercise->setDifficulty($data['difficulty']);

            return $exercise;
        }

        return null;
    }

    private function validateExerciseData(array $data): bool

    {
        $errors = [];
        if (empty($data['exercise_name']) || strlen(trim($data['exercise_name'])) < 5 || strlen(trim($data['exercise_name'])) > 30) {
            $errors[] = 'O campo "Nome do Exercício" é obrigatório e deve ter entre 5 e 30 caracteres.';
            throw new InvalidExerciseNameException();
        }

        if (empty($data['exercise_type']) || strlen(trim($data['exercise_type'])) < 5 || strlen(trim($data['exercise_type'])) > 30) {
            $errors[] = 'O campo "Tipo de Exercício" é obrigatório e deve ter entre 5 e 30 caracteres.';
            throw new InvalidExerciseTypeException();
        }
        if (empty($data['description']) || strlen(trim($data['description'])) < 5 || strlen(trim($data['description'])) > 55) {
            $errors[] = 'O campo "Descrição" é obrigatório e deve ter entre 5 e 55 caracteres.';
            throw new InvalidExerciseDescriptionException();
        }

        if (empty($data['muscle_group'])) {
            $errors[] = 'O campo "Grupo Muscular" é obrigatório.';
            throw new InvalidExerciseMuscleGroupException();
        }

        if (empty($data['difficulty'])) {
            $errors[] = 'O campo "Dificuldade" é obrigatório.';
            throw new InvalidExerciseDifficultyException();
        }

        if (empty($errors))
            return true;

        return false;
    }
}
