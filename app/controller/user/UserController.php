<?php

require_once './app/service/user/UserService.php';

class UserController
{

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function insert(array $data): void
    {
        if ($data === null || empty($data)) return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->userService->insert($data);
            if ($response) {
                header('Location: ./app/view/user/login.php');
                exit;
            } else {
                echo "Erro ao cadastrar o usuário.";
                require './app/view/user/register.php';
            }
        }
    }
    public function update(int $id, array $data): void
    {
        if ($data === null || empty($data) || $id === null || empty($id)) return;

        // TODO --> CRIAR TELA DE ALTERAR PERFIL PARA REDIRECT DE SUCESSO E DE FALHA
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $response = $this->userService->update($id, $data);
            if ($response) {
                // REDIRECT AQUI
                header('Location: ./app/view/login.php');
                exit;
            } else {
                echo "Erro ao alterar o usuário.";
                // REDIRECT AQUI
                require './app/view/user/register.php';
            }
        }
    }
    public function selectAll(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $response = $this->userService->selectAll();

            // TODO --> PAINEL ADM: Visualizar lista de usuários na Dashboard
            if ($response) {
                header('Location: /views/success.php');
            } else {
                echo "Erro ao selecionar os usuários.";
            }
        }
    }

    public function delete(int $id, string $method): void
    {
        if ($id === null || empty($id)) return;

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $response = $this->userService->delete($id);

            // TODO --> PAINEL ADM: Visualizar lista de usuários na Dashboard || Voltar para login se for usuário normal apagando a conta pessoal.
            if ($response) {
                header('Location: /views/success.php');
            } else {
                echo "Erro ao deletar o usuário.";
            }
        }
    }
}
