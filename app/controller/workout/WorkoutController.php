<?php

require_once __DIR__ . '/../../service/workout/WorkoutService.php';
require_once __DIR__ . '/../BaseController.php';

class WorkoutController extends BaseController
{

    private WorkoutService $workoutService;

    public function __construct()
    {
        parent::__construct();

        $this->workoutService = new WorkoutService();
    }

    public function insert(array $data): void
    {
        if ($data === null || empty($data))
            return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->workoutService->insert($data);

            if ($response) {
                header('Location: ./app/view/workout/workouts.php');
                exit;
            } else {
                echo "Erro ao cadastrar treino.";
                require 'index.php';
            }
        }
    }
    public function update(int $id, array $data): void
    {
        if ($data === null || empty($data) || $id === null || empty($id))
            return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->workoutService->update($id, $data);

            if ($response) {
                header('Location: ./app/view/workout/workouts.php');
                exit;
            } else {
                echo "Erro ao alterar treino.";
                require 'index.php';
            }
        }
    }
    public function selectAll(string $method): array|null
    {
        if ($method === 'GET') {
            $workouts = $this->workoutService->selectAll();

            if ($workouts) {
                return $workouts;
            } else if (empty($workouts)) {
                return [];
            } else {
                echo "Erro ao buscar os treinos.";
                return null;
            }
        }
        return null;
    }

    public function findById($id, $method): array|null
    {
        if ($method === "GET") {
            $workout = $this->workoutService->findById($id);
            if ($workout) {
                return $workout;
            }
            return null;
        }
        return null;
    }

    public function delete(int $id, string $method): void
    {
        if ($id === null || empty($id))
            return;

        if ($method === 'DELETE') {
            $response = $this->workoutService->delete($id);

            if ($response) {
                header('Location: ./app/view/workout/workouts.php');
            } else {
                echo "Erro ao deletar treino.";
                require 'index.php';
            }
        }
    }
}
