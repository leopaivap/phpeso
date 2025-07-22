<?php

require_once __DIR__ . "/../../model/user/User.php";
require_once __DIR__ . "/../../service/ServiceInterface.php";
require_once __DIR__ . "/../../repository/user/UserRepository.php";
require_once __DIR__ . "/../../exception/ValidationException.php";
require_once __DIR__ . "/../../exception/user/InvalidUserFirstNameException.php";
require_once __DIR__ . "/../../exception/user/InvalidUserLastNameException.php";
require_once __DIR__ . "/../../exception/user/InvalidUserEmailException.php";
require_once __DIR__ . "/../../exception/user/InvalidUserPasswordException.php";
require_once __DIR__ . "/../../exception/user/InvalidUserConfirmPassword.php";
require_once __DIR__ . "/../../exception/user/InvalidUserPhoneNumberException.php";
require_once __DIR__ . "/../../exception/user/InvalidUserBirthDateException.php";
require_once __DIR__ . "/../../exception/user/InvalidUserGenderException.php";
require_once __DIR__ . "/../../exception/user/InvalidUsernameException.php";


class UserService implements ServiceInterface
{
    private UserRepository $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function insert(array $data): bool
    {
        try {
            $user = $this->createUser($data);
            $result = $this->userRepository->insert($user);
            return $result !== null;
        } catch (ValidationException $e) {
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }

    public function update(int $id, array $data): bool
    {
        return false;
    }
    public function delete(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
    public function selectAll(): array
    {
        return $this->userRepository->selectAll();
    }
    public function findById(int $id): ?array
    {
        return $this->userRepository->findById($id);
    }
    public function selectAllByRole(string $role): array
    {
        return $this->userRepository->selectAllByRole($role);
    }
    public function updateRole(int $id, string $role): bool
    {
        return $this->userRepository->updateRole($id, $role);
    }

    private function createUser(array $data): User
    {
        $this->validateUserData($data);
        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPhoneNumber($data['phoneNumber']);
        $user->setGender($data['gender']);
        $user->setBirthDate($data['birth_date']);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setRole($data['role'] ?? 'client');
        return $user;
    }

    private function validateUserData(array $data): void
    {
        if (empty($data['firstName']) || strlen(trim($data['firstName'])) < 2)
            throw new InvalidUserFirstNameException();
        if (empty($data['lastName']))
            throw new InvalidUserLastNameException();
        if (empty($data['username']) || strlen(trim($data['username'])) < 4)
            throw new InvalidUsernameException();
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            throw new InvalidUserEmailException();
        if (empty($data['password']) || strlen($data['password']) < 6)
            throw new InvalidUserPasswordException();
        if ($data['password'] !== $data['confirmPassword'])
            throw new InvalidUserConfirmPassword();
    }
}