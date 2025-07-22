<?php

require_once __DIR__ . '/../../service/user/UserService.php';
require_once __DIR__ . '/../BaseController.php';
require_once __DIR__ . '/../../repository/user/UserRepository.php';

class UserController
{
    private ?UserService $userService = null;

    private function getUserService(): UserService
    {
        if ($this->userService === null) {
            $this->userService = new UserService();
        }
        return $this->userService;
    }

    // Ações Públicas
    public function showLogin(array $data = []): void
    {
        require_once __DIR__ . '/../../view/user/login.php';
    }
    public function showRegister(array $data = []): void
    {
        require_once __DIR__ . '/../../view/user/register.php';
    }

    public function insert(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->getUserService()->insert($data)) {
                $_SESSION['success_message'] = "Usuário cadastrado com sucesso! Faça o login.";
                header('Location: ' . BASE_URL . 'index.php?controller=user&action=showLogin');
                exit;
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=user&action=showRegister');
        exit;
    }

    public function login(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            return;
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $user = (new UserRepository())->findByUsername($data['username'] ?? '');
        if ($user && password_verify($data['password'] ?? '', $user['password'])) {
            $_SESSION['user_loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_username'] = $user['username'];
            $_SESSION['user_firstname'] = $user['firstName'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: ' . BASE_URL . 'index.php');
            exit;
        } else {
            $_SESSION['login_error'] = "Usuário ou senha inválidos.";
            header('Location: ' . BASE_URL . 'index.php?controller=user&action=showLogin');
            exit;
        }
    }

    public function logout(array $data = []): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        session_destroy();
        header('Location: ' . BASE_URL . 'index.php?controller=user&action=showLogin');
        exit;
    }

    // --- Ações de Administrador ---
    private function requireAdmin(): void
    {
        new BaseController(); // Garante que está logado
        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'index.php');
            exit;
        }
    }

    public function list(array $data = []): void
    {
        $this->requireAdmin();
        $users = $this->getUserService()->selectAll();
        require_once __DIR__ . '/../../view/user/users.php';
    }

    public function updateRole(int $id, array $data): void
    {
        $this->requireAdmin();
        $role = $data['role'] ?? null;
        if ($id && $role) {
            if ($this->getUserService()->updateRole($id, $role)) {
                $_SESSION['success_message'] = "Permissão atualizada!";
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar permissão.";
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=user&action=list');
        exit;
    }

    public function deleteUser(int $id, array $data = []): void
    {
        $this->requireAdmin();
        if ($id === $_SESSION['user_id']) {
            $_SESSION['error_message'] = "Você não pode apagar a si mesmo.";
        } else {
            if ($this->getUserService()->delete($id)) {
                $_SESSION['success_message'] = "Usuário apagado!";
            } else {
                $_SESSION['error_message'] = "Erro ao apagar usuário.";
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=user&action=list');
        exit;
    }
}