<?php

require_once __DIR__ . '/../repository/Connection';

class UserController
{

    private UserRepository $userRepository;

    public function __construct()
    {
        $pdo = Connection::getInstance()->getConnection();
        $this->userRepository = new UserRepository($pdo);
    }



    public function insert(array $data): void
    {
        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPhoneNumber($data['phoneNumber']);
        $user->setGender($data['gender']);
        $user->setBirthDate($data['birth_date']);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        $user->setRole($data['role']);
        $user->setCreatedAt(date('Y-m-d H:i:s'));

        $success = $this->userRepository->insert($user);

        if ($success) {
            header('Location: /views/success.php');
        } else {
            echo "Erro ao cadastrar o usuário.";
        }
    }
}

?>