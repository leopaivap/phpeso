<?php

require_once __DIR__ . '/../repository/Connection';

class UserController
{

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }



    public function insert(array $data): void
    {

        $response = $this->userService->insert($data);

        if ($response) {
            header('Location: /views/success.php');
        } else {
            echo "Erro ao cadastrar o usuário.";
        }
    }
}

?>