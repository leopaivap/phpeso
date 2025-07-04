<?php

require_once __DIR__ . "/../../model/workout/Workout.php";
require_once __DIR__ . "/../../service/ServiceInterface.php";
require_once __DIR__ . "/../../repository/workout/WorkoutRepository.php";
require_once __DIR__ . "/../../exception/workout/InvalidWorkoutNameException.php";
require_once __DIR__ . "/../../exception/workout/InvalidWorkoutDescriptionException.php";
require_once __DIR__ . "/../../exception/workout/InvalidWorkoutStudentException.php";
require_once __DIR__ . "/../../exception/workout/InvalidWorkoutTrainerException.php";

class WorkoutService implements ServiceInterface
{
    private WorkoutRepository $workoutRepository;
    public function __construct()
    {
        $this->workoutRepository = new WorkoutRepository();
    }

    public function insert(array $data): bool
    {
        $workout = $this->createWorkout($data);
        $response = false;

        if ($workout !== null) {
            $response = $this->workoutRepository->insert($workout);
        }

        if ($response)
            return true;

        return false;
    }

    public function update(int $id, array $data): bool
    {
        $workout = $this->createWorkout($data);
        $response = false;

        if ($workout != null) {
            $workout->setUpdatedAt();
            $response = $this->workoutRepository->update($id, $workout);
        }

        if ($response)
            return true;

        return false;
    }

    public function delete(int $id): bool
    {
        $response = false;

        if ($id != null && !empty($id)) {
            $response = $this->workoutRepository->delete($id);
        }

        if ($response)
            return true;

        return false;
    }

    public function selectAll(): array
    {
        $workouts = $this->workoutRepository->selectAll();

        if (!empty($workouts) && $workouts != null) {
            return $workouts;
        }

        return [];
    }

    public function findById(int $id): ?array
    {
        $workoutData = $this->workoutRepository->findById($id);
        if (!empty($workoutData) && $workoutData != null) {
            return $workoutData;
        }

        return null;
    }

    private function createWorkout(array $data): Workout|null
    {
        $isValidWorkoutData = $this->validateWorkoutData($data);

        if ($isValidWorkoutData) {

            $workout = new Workout();
            $workout->setName($data['name']);
            $workout->setDescription($data['description']);
            $workout->setStudentId($data['student_id']);
            $workout->setTrainerId($data['trainer_id']);

            return $workout;
        }

        return null;
    }

    private function validateWorkoutData(array $data): bool
    {
        $errors = [];
        if (empty($data['name']) || strlen(trim($data['name'])) < 5 || strlen(trim($data['name'])) > 30) {
            $errors[] = 'O campo "Nome do Treino" é obrigatório e deve ter entre 5 e 30 caracteres.';
            throw new InvalidWorkoutNameException();
        }

        if (empty($data['description']) || strlen(trim($data['description'])) < 5 || strlen(trim($data['description'])) > 55) {
            $errors[] = 'O campo "Descrição" é obrigatório e deve ter entre 5 e 55 caracteres.';
            throw new InvalidWorkoutDescriptionException();
        }

        if (empty($data['student_id'])) {
            $errors[] = 'O campo "Aluno" é obrigatório.';
            throw new InvalidWorkoutStudentException();
        }

        if (empty($data['trainer_id'])) {
            $errors[] = 'O campo "Treinador" é obrigatório.';
            throw new InvalidWorkoutTrainerException();
        }

        if (empty($errors))
            return true;

        return false;
    }
}
