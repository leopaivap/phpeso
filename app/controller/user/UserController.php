<?php

require_once __DIR__ . '/../../service/user/UserService.php';
require_once __DIR__ . '/../BaseController.php';

class UserController extends BaseController
{
    private UserService $userService;

    public function __construct()
    {
        // O construtor do BaseController já inicia a sessão e verifica o login
        // para as páginas protegidas.
    }

    // Ações públicas (não precisam de login)
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
        $this->userService = new UserService();
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
            $_SESSION['user_role'] = $user['role']; // GUARDA A PERMISSÃO NA SESSÃO

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

    // Ações de Administrador
    private function requireAdmin(): void
    {
        parent::__construct(); // Garante que está logado
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            // Se não for admin, redireciona para a home
            header('Location: ' . BASE_URL . 'index.php');
            exit;
        }
        $this->userService = new UserService();
    }

    public function list(): void
    {
        $this->requireAdmin(); // Protege a página
        $users = $this->userService->selectAll();
        require_once __DIR__ . '/../../view/user/users.php';
    }

    public function updateRole(int $id, array $data): void
    {
        $this->requireAdmin();
        $role = $data['role'] ?? null;
        if ($id && $role) {
            $response = $this->userService->updateRole($id, $role);
            if ($response) {
                $_SESSION['success_message'] = "Permissão do usuário atualizada com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar a permissão.";
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=user&action=list');
        exit;
    }

    public function deleteUser(int $id): void
    {
        $this->requireAdmin();
        if ($id === $_SESSION['user_id']) {
            $_SESSION['error_message'] = "Você não pode apagar a si mesmo.";
            header('Location: ' . BASE_URL . 'index.php?controller=user&action=list');
            exit;
        }

        $response = $this->userService->delete($id);
        if ($response) {
            $_SESSION['success_message'] = "Usuário apagado com sucesso!";
        } else {
            $_SESSION['error_message'] = "Erro ao apagar o usuário.";
        }
        header('Location: ' . BASE_URL . 'index.php?controller=user&action=list');
        exit;
    }
}