<?php

require_once './app/service/workout/WorkoutService.php';

class WorkoutController
{

    private WorkoutService $workoutService;

    public function __construct()
    {
        $this->workoutService = new WorkoutService();
    }

    public function insert(array $data): void
    {
        if ($data === null || empty($data)) return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->workoutService->insert($data);

            if ($response) {
                header('Location: ./app/view/workout/workouts.php');
                exit;
            } else {
                echo "Erro ao cadastrar treino.";
                require '/phpeso/index.php';
            }
        }
    }
    public function update(int $id, array $data): void
    {
        if ($data === null || empty($data) || $id === null || empty($id)) return;

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $response = $this->workoutService->update($id, $data);

            if ($response) {
                header('Location: ./app/view/workout/workouts.php');
                exit;
            } else {
                echo "Erro ao alterar o usuário.";
                require '/phpeso/index.php';
            }
        }
    }
    public function selectAll(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $response = $this->workoutService->selectAll();

            if ($response) {
                header('Location: ./app/view/workout/workouts.php');
            } else {
                echo "Erro ao buscar os treinos.";
                require '/phpeso/index.php';
            }
        }
    }

    public function delete(int $id, string $method): void
    {
        if ($id === null || empty($id)) return;

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $response = $this->workoutService->delete($id);

            if ($response) {
                header('Location: ./app/view/workout/workouts.php');
            } else {
                echo "Erro ao deletar treino.";
                require '/phpeso/index.php';
            }
        }
    }
}
