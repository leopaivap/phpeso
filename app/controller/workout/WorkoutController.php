<?php

require_once __DIR__ . '/../../service/workout/WorkoutService.php';
require_once __DIR__ . '/../BaseController.php';
require_once __DIR__ . '/../../service/user/UserService.php';

class WorkoutController extends BaseController
{
    private WorkoutService $workoutService;
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->workoutService = new WorkoutService();
        $this->userService = new UserService();
    }

    public function list(): void
    {
        $workouts = $this->workoutService->selectAll();
        $students = $this->userService->selectAllByRole("client");
        $trainerList = $this->userService->selectAllByRole("trainer");

        $editing = false;
        $workout_form_data = [
            'id' => null,
            'name' => '',
            'description' => '',
            'student_id' => '',
            'trainer_id' => '',
        ];

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $editing = true;
            $id = $_GET['id'];
            $workout_data_from_db = $this->workoutService->findById($id);
            if ($workout_data_from_db) {
                $workout_form_data = $workout_data_from_db;
            }
        }
        require_once __DIR__ . '/../../view/workout/workouts.php';
    }

    public function insert(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->workoutService->insert($data);
            if ($response) {
                // CORREÇÃO: Redireciona para a ROTA de lista de treinos
                header('Location: ' . BASE_URL . 'index.php?controller=workout&action=list');
                exit;
            } else {
                echo "Erro ao cadastrar treino.";
            }
        }
    }

    public function update(int $id, array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->workoutService->update($id, $data);
            if ($response) {
                // CORREÇÃO: Redireciona para a ROTA de lista de treinos
                header('Location: ' . BASE_URL . 'index.php?controller=workout&action=list');
                exit;
            } else {
                echo "Erro ao alterar treino.";
            }
        }
    }

    public function selectAll(string $method): ?array
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

    public function findById($id, $method): ?array
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

    public function delete(int $id, array $data, string $method): void
    {
        if ($id === null || empty($id))
            return;

        if ($method === 'delete') { // 'delete' vindo da URL
            $response = $this->workoutService->delete($id);

            if ($response) {
                header('Location: /phpeso/index.php?controller=workout&action=list');
                exit;
            } else {
                echo "Erro ao deletar o item.";
                require 'index.php';
            }
        }
    }
}
