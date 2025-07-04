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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->userService->insert($data);
            if ($response) {
                header('Location: ' . BASE_URL . 'index.php?controller=user&action=showLogin');
                exit;
            } else {
                $_SESSION['register_error'] = "Erro ao cadastrar o usuário. Tente novamente.";
                header('Location: ' . BASE_URL . 'index.php?controller=user&action=showRegister');
                exit;
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

        require_once __DIR__ . "/../../repository/user/UserRepository.php";
        $userRepository = new UserRepository();
        $user = $userRepository->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_username'] = $user['username'];
            $_SESSION['user_firstname'] = $user['firstName'];

            header('Location: ' . BASE_URL . 'index.php');
            exit;
        } else {
            $_SESSION['login_error'] = "Usuário ou senha inválidos.";
            header('Location: ' . BASE_URL . 'index.php?controller=user&action=showLogin');
            exit;
        }
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION = array();
        session_destroy();
        header('Location: ' . BASE_URL . 'index.php?controller=user&action=showLogin');
        exit;
    }

    public function update(int $id, array $data): void
    {
        if ($data === null || empty($data) || $id === null || empty($id))
            return;

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $response = $this->userService->update($id, $data);
            if ($response) {
                header('Location: ./app/view/login.php');
                exit;
            } else {
                echo "Erro ao alterar o usuário.";
                require './app/view/user/register.php';
            }
        }
    }
    
    public function selectAll(string $method): ?array
    {
        if ($method === 'GET') {
            $users = $this->userService->selectAll();
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

    public function selectAllByRole(string $role, string $method): ?array
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
            if ($response) {
                header('Location: /views/success.php');
            } else {
                echo "Erro ao deletar o usuário.";
            }
        }
    }
}