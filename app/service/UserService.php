<?php

include_once __DIR__ . "../model/User.php";
include_once __DIR__ . "./ServiceInterface.php";

class UserService implements ServiceInterface
{

    private UserRepository $userRepository;
    public function __construct()
    {
        $pdo = Connection::getInstance()->getConnection();
        $this->userRepository = new UserRepository($pdo);
    }

    public function insert(array $data): bool
    {
        if ($data === null)
            return false;

        $user = $this->createUser($data);

        $response = $this->userRepository->insert($user);
        if ($response) {
            return true;
        }

        return false;
    }

    public function update(array $data): bool
    {
        return false;

    }

    public function delete(int $id): bool
    {
        return false;

    }

    public function selectAll(): array
    {
        return [];

    }

    private function createUser(array $data): User
    {
        $user = $this->validateUserData($data);
        
        return $user;
    }

    private function validateUserData(array $data): User
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

        return $user;
    }
}

?>