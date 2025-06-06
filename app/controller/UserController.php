<?php

require_once __DIR__ . '/../repository/Connection.php';

class UserController
{

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }


    public function insert(array $data): void
    {
        $response = false;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $response = $this->userService->insert($data);
        }

        if ($response) {
            header('Location: /views/success.php');
        } else {
            echo "Erro ao cadastrar o usuário.";
        }
    }
}

?>