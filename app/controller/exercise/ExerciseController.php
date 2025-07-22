<?php

require_once __DIR__ . '/../../service/exercise/ExerciseService.php';
require_once __DIR__ . '/../BaseController.php';
require_once __DIR__ . '/../../repository/muscle-group/MuscleGroupRepository.php';
require_once __DIR__ . '/../../repository/exercise/ExerciseRepository.php';

class ExerciseController extends BaseController
{
    private ExerciseService $exerciseService;

    public function __construct()
    {
        parent::__construct();
        $this->exerciseService = new ExerciseService();
    }

    public function list(array $data = []): void
    {
        $user_role = $_SESSION['user_role'];
        if ($user_role === 'client') {
            header('Location: ' . BASE_URL . 'index.php?controller=workout&action=list');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $trainer_id_to_filter = ($user_role === 'trainer') ? $user_id : null;
        $exercises = $this->exerciseService->selectAll($trainer_id_to_filter);

        $muscleGroupRepository = new MuscleGroupRepository();
        $muscleGroups = $muscleGroupRepository->selectAll();

        $editing = false;
        $exercise_form_data = ['id' => null, 'name' => '', 'exercise_type' => '', 'description' => '', 'muscle_group_id' => '', 'difficulty' => 'beginner'];

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->checkOwnership($_GET['id']);
            $editing = true;
            $repo = new ExerciseRepository();
            $exercise_form_data = $repo->findById($_GET['id']) ?: $exercise_form_data;
        }

        require_once __DIR__ . '/../../view/exercise/exercises.php';
    }

    public function insert(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($_SESSION['user_role'], ['admin', 'trainer'])) {
            if ($this->exerciseService->insert($data)) {
                $_SESSION['success_message'] = 'Exercício cadastrado com sucesso!';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=exercise&action=list');
        exit;
    }

    public function update(int $id, array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkOwnership($id);
            if ($this->exerciseService->update($id, $data)) {
                $_SESSION['success_message'] = 'Exercício atualizado com sucesso!';
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=exercise&action=list');
        exit;
    }

    public function delete(int $id): void
    {
        $this->checkOwnership($id);
        if ($this->exerciseService->delete($id)) {
            $_SESSION['success_message'] = 'Exercício apagado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao apagar o exercício.';
        }
        header('Location: ' . BASE_URL . 'index.php?controller=exercise&action=list');
        exit;
    }

    private function checkOwnership(int $exerciseId): void
    {
        if ($_SESSION['user_role'] === 'admin')
            return;

        $repo = new ExerciseRepository();
        $exercise = $repo->findById($exerciseId);
        if (!$exercise || $exercise['trainer_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . 'index.php?controller=exercise&action=list');
            exit;
        }
    }
}