<?php

require_once __DIR__ . '/../../service/user/UserService.php';

class UserController
{

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function showLogin(): void
    {
        require_once __DIR__ . '/../../view/user/login.php';
    }

    public function showRegister(): void
    {
        require_once __DIR__ . '/../../view/user/register.php';
    }

    public function insert(array $data): void
    {
        if ($data === null || empty($data))
            return;

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
        if ($data === null || empty($data) || $id === null || empty($id))
            return;

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
    public function selectAll(string $method): array|null
    {
        if ($method === 'GET') {
            $users = $this->userService->selectAll();

            // TODO --> PAINEL ADM: Visualizar lista de usuários na Dashboard
            if ($users) {
                return $users;
            } else {
                echo "Erro ao selecionar os usuários.";
                return null;
            }
        }
        return null;
    }

    public function findById(int $id, string $method): ?User
    {
        if ($method === 'GET') {
            $user = $this->userService->findById($id);

            if ($user) {
                return $user;
            } else {
                echo "Erro ao selecionar usuário por ID.";
                return null;
            }
        }
        return null;
    }

    public function selectAllByRole(string $role, string $method): array|null
    {
        if ($method === 'GET') {
            $users = $this->userService->selectAllByRole($role);

            if ($users) {
                return $users;
            } else if (empty($user)) {
                echo "Erro ao selecionar os usuários por função.";
                return [];
            } else {
                return null;
            }
        }
        return null;
    }

    public function delete(int $id, string $method): void
    {
        if ($id === null || empty($id))
            return;

        if ($method === 'DELETE') {
            $response = $this->userService->delete($id);

            // TODO --> PAINEL ADM: Visualizar lista de usuários na Dashboard || Voltar para login se for usuário normal apagando a conta pessoal.
            if ($response) {
                header('Location: /views/success.php');
            } else {
                echo "Erro ao deletar o usuário.";
            }
        }
    }

    public function login(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            return;
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        // Busca o usuário no repositório
        require_once __DIR__ . "/../../repository/user/UserRepository.php";
        $userRepository = new UserRepository();
        $user = $userRepository->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Login bem-sucedido: armazena dados na sessão
            $_SESSION['user_loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_username'] = $user['username'];
            $_SESSION['user_firstname'] = $user['firstName'];

            header("Location: /phpeso/index.php");
            exit;
        } else {
            $_SESSION['login_error'] = "Usuário ou senha inválidos.";
            header("Location: /phpeso/app/view/user/login.php");
            exit;
        }
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();
        session_destroy();

        header("Location: /phpeso/app/view/user/login.php");
        exit;
    }

}
