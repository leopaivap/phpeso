<?php

require_once __DIR__ . "/../../model/workout/Workout.php";
require_once __DIR__ . "/../../service/ServiceInterface.php";
require_once __DIR__ . "/../../repository/workout/WorkoutRepository.php";
require_once __DIR__ . "/../../exception/workout/InvalidWorkoutNameException.php";
require_once __DIR__ . "/../../exception/workout/InvalidWorkoutDescriptionException.php";

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
        if ($workout !== null) {
            $newWorkoutId = $this->workoutRepository->insert($workout);
            if ($newWorkoutId) {
                if (!empty($data['client_ids']))
                    $this->workoutRepository->assignToClients($newWorkoutId, $data['client_ids']);
                if (!empty($data['exercise_ids']))
                    $this->workoutRepository->linkExercises($newWorkoutId, $data['exercise_ids']);
                return true;
            }
        }
        return false;
    }

    public function update(int $id, array $data): bool
    {
        $workout = $this->createWorkout($data);
        if ($workout != null) {
            $workout->setUpdatedAt();
            $this->workoutRepository->update($id, $workout);
            $this->workoutRepository->assignToClients($id, $data['client_ids'] ?? []);
            $this->workoutRepository->linkExercises($id, $data['exercise_ids'] ?? []);
            return true;
        }
        return false;
    }

    public function delete(int $id): bool
    {
        return $this->workoutRepository->delete($id);
    }

    public function selectAll(int $user_id, string $user_role): array
    {
        if ($user_role === 'client') {
            return $this->workoutRepository->findAssignedToClient($user_id);
        }
        $trainer_id = ($user_role === 'trainer') ? $user_id : null;
        return $this->workoutRepository->selectAll($trainer_id);
    }

    public function findById(int $id): ?array
    {
        return $this->workoutRepository->findById($id);
    }

    public function findExercisesForWorkout(int $id): array
    {
        return $this->workoutRepository->findExercisesForWorkout($id);
    }

    private function createWorkout(array $data): ?Workout
    {
        if ($this->validateWorkoutData($data)) {
            $workout = new Workout();
            $workout->setName($data['name']);
            $workout->setDescription($data['description']);
            $workout->setTrainerId($_SESSION['user_id']); // Admin ou Trainer
            return $workout;
        }
        return null;
    }

    private function validateWorkoutData(array $data): bool
    {
        if (empty($data['name']))
            throw new InvalidWorkoutNameException();
        if (empty($data['description']))
            throw new InvalidWorkoutDescriptionException();
        return true;
    }
}