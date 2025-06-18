<?php

require_once './app/service/exercise/ExerciseService.php';
require_once __DIR__ . '/../BaseController.php';
require_once __DIR__ . '/../../repository/muscle-group/MuscleGroupRepository.php';

class ExerciseController extends BaseController
{

    private ExerciseService $exerciseService;

    public function __construct()
    {
        parent::__construct();

        $this->exerciseService = new ExerciseService();
    }

    public function list(): void
    {
    
        $exercises = $this->exerciseService->selectAll();

        $muscleGroupRepository = new MuscleGroupRepository();
        $muscleGroups = $muscleGroupRepository->selectAll();

        $editing = false;
        $exercise_form_data = [
            'name' => '',
            'exercise_type' => '',
            'description' => '',
            'muscle_group_id' => '',
            'difficulty' => 'beginner'
        ];

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $editing = true;
        }

        require_once __DIR__ . '/../../view/exercise/exercises.php';
    }

    public function insert(array $data): void
    {
        if ($data === null || empty($data))
            return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->exerciseService->insert($data);
            if ($response) {
                header('Location: /phpeso/index.php?controller=exercise&action=list');
                exit;
            } else {
                echo "Erro ao cadastrar o exercício.";
                require '/phpeso/index.php';
            }
        }
    }
    public function update(int $id, array $data): void
    {
        if ($data === null || empty($data) || $id === null || empty($id))
            return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->exerciseService->update($id, $data);
            if ($response) {
                header('Location: /phpeso/index.php?controller=exercise&action=list');
                exit;
            } else {
                echo "Erro ao alterar o exercício.";
                require 'index.php';
            }
        }
    }
    public function selectAll(string $method): array|null
    {
        if ($method === 'GET') {
            $response = $this->exerciseService->selectAll();

            if ($response) {
                return $response;
            } else {
                echo "Erro ao buscar os exercícios.";
                return null;
            }
        }
        return null;
    }
    public function delete(int $id, array $data, string $method): void
    {
        if ($id === null || empty($id))
            return;

        if ($method === 'delete') { // 'delete' vindo da URL
            $response = $this->exerciseService->delete($id);

            if ($response) {
                header('Location: /phpeso/index.php?controller=exercise&action=list');
                exit;
            } else {
                echo "Erro ao deletar o item.";
                require 'index.php';
            }
        }
    }


}
