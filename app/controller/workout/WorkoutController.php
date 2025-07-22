<?php

require_once __DIR__ . '/../../service/workout/WorkoutService.php';
require_once __DIR__ . '/../../service/exercise/ExerciseService.php';
require_once __DIR__ . '/../BaseController.php';
require_once __DIR__ . '/../../service/user/UserService.php';

class WorkoutController extends BaseController
{
    private WorkoutService $workoutService;
    private UserService $userService;
    private ExerciseService $exerciseService;

    public function __construct()
    {
        parent::__construct();
        $this->workoutService = new WorkoutService();
        $this->userService = new UserService();
        $this->exerciseService = new ExerciseService();
    }

    public function list(array $data = []): void
    {
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        $workouts = $this->workoutService->selectAll($user_id, $user_role);
        $clients = ($user_role !== 'client') ? $this->userService->selectAllByRole("client") : [];

        $trainers = ($user_role === 'admin') ? $this->userService->selectAllByRole("trainer") : [];

        $trainer_id_for_exercises = ($user_role === 'trainer') ? $user_id : null;
        $available_exercises = ($user_role !== 'client') ? $this->exerciseService->selectAll($trainer_id_for_exercises) : [];

        $editing = false;
        $workout_form_data = ['id' => null, 'name' => '', 'description' => '', 'client_ids' => [], 'exercise_ids' => []];

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->checkOwnership($_GET['id']);
            $editing = true;
            $workout_data_from_db = $this->workoutService->findById($_GET['id']);
            if ($workout_data_from_db) {
                $workout_form_data = $workout_data_from_db;
            }
        }
        require_once __DIR__ . '/../../view/workout/workouts.php';
    }

    public function getDetails(int $id, array $data = []): void
    {
        header('Content-Type: application/json');
        $details = $this->workoutService->findExercisesForWorkout($id);
        echo json_encode($details);
        exit;
    }

    public function insert(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->workoutService->insert($data)) {
                $_SESSION['success_message'] = 'Treino cadastrado com sucesso!';
            } else {
                $_SESSION['error_message'] = 'Erro ao cadastrar treino. Verifique os campos.';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=workout&action=list');
        exit;
    }

    public function update(int $id, array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkOwnership($id);
            if ($this->workoutService->update($id, $data)) {
                $_SESSION['success_message'] = 'Treino atualizado com sucesso!';
            } else {
                $_SESSION['error_message'] = 'Erro ao atualizar treino.';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=workout&action=list');
        exit;
    }

    public function delete(int $id, array $data = []): void
    {
        $this->checkOwnership($id);
        if ($this->workoutService->delete($id)) {
            $_SESSION['success_message'] = 'Treino apagado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao apagar treino.';
        }
        header('Location: ' . BASE_URL . 'index.php?controller=workout&action=list');
        exit;
    }

    private function checkOwnership(int $workoutId): void
    {
        if (in_array($_SESSION['user_role'], ['admin', 'client']))
            return;

        $workout = $this->workoutService->findById($workoutId);
        if (!$workout || $workout['trainer_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . 'index.php?controller=workout&action=list');
            exit;
        }
    }
}