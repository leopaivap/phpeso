 <?php

    require_once './app/service/exercise/ExerciseService.php';

    class ExerciseController
    {

        private ExerciseService $exerciseService;

        public function __construct()
        {
            $this->exerciseService = new ExerciseService();
        }

        public function insert(array $data): void
        {
            if ($data === null || empty($data)) return;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $response = $this->exerciseService->insert($data);
                if ($response) {
                    header('Location: ./app/view/exercise/exercises.php');
                    exit;
                } else {
                    echo "Erro ao cadastrar o exercício.";
                    require '/phpeso/index.php';
                }
            }
        }
        public function update(int $id, array $data): void
        {
            if ($data === null || empty($data) || $id === null || empty($id)) return;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $response = $this->exerciseService->update($id, $data);
                if ($response) {
                    header('Location: ./app/view/exercise/exercises.php');
                    exit;
                } else {
                    echo "Erro ao alterar o exercício.";
                    require 'index.php';
                }
            }
        }
        public function selectAll(): void
        {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $response = $this->exerciseService->selectAll();

                if ($response) {
                    header('Location: ./app/view/exercise/exercises.php');
                } else {
                    echo "Erro ao buscar os exercícios.";
                    require 'index.php';
                }
            }
        }
        public function delete(int $id): void
        {
            if ($id === null || empty($id)) return;

            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $response = $this->exerciseService->delete($id);

                if ($response) {
                    header('Location: ./app/view/exercise/exercises.php');
                } else {
                    echo "Erro ao deletar o exercício.";
                    require '/phpeso/index.php';
                }
            }
        }
    }
