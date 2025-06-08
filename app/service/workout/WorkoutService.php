<?php

require_once "./app/model/workout/Workout.php";
require_once "./app/service/ServiceInterface.php";
require_once "./app/repository/workout/WorkoutRepository.php";

// require_once "./app/exception/workout/InvalidWorkoutXException.php";

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

        if ($response) return true;

        return false;
    }

    public function update(int $id, array $data): bool
    {
        $workout = $this->createWorkout($data);
        $response = false;

        if ($workout != null) {
            $response = $this->workoutRepository->update($id, $workout);
        }

        if ($response) return true;

        return false;
    }

    public function delete(int $id): bool
    {
        $response = false;

        if ($id != null && !empty($id)) {
            $response = $this->workoutRepository->delete($id);
        }

        if ($response) return true;

        return false;
    }

    public function selectAll(): array
    {
        $response = $this->workoutRepository->selectAll();

        if (!empty($response) && $response != null) {
            return $response;
        }

        return [];
    }

    private function createWorkout(array $data): Workout | null
    {
        $isValidWorkoutData = $this->validateWorkoutData($data);

        if ($isValidWorkoutData) {

            $workout = new Workout();
            // TODO --> Setar atributos obj workout

            return $workout;
        }

        return null;
    }

    private function validateWorkoutData(array $data): bool

    {
        $errors = [];
        // TODO --> Validar campos e Criar Exceptions

        if (empty($errors))
            return true;

        return false;
    }
}
