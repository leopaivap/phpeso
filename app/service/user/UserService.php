<?php

require_once __DIR__ . "/../../model/user/User.php";
require_once __DIR__ . "/../../service/ServiceInterface.php";
require_once __DIR__ . "/../../repository/user/UserRepository.php";

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
        $user = $this->createUser($data);
        $response = false;

        if ($user !== null) {
            $response = $this->userRepository->insert($user);
        }

        return (bool) $response;
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->createUser($data);
        $response = false;

        if ($user != null) {
            $response = $this->userRepository->update($id, $user);
        }

        return (bool) $response;
    }

    public function delete(int $id): bool
    {
        $response = false;

        if ($id != null && !empty($id)) {
            $response = $this->userRepository->delete($id);
        }

        return (bool) $response;
    }

    public function selectAll(): array
    {
        return $this->userRepository->selectAll();
    }

    // CORREÇÃO AQUI
    public function findById(int $id): ?User
    {
        $userData = $this->userRepository->findById($id);

        if (!empty($userData) && $userData != null) {
            $user = new User();
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);
            return $user;
        }

        return null;
    }

    public function selectAllByRole(string $role): array
    {
        return $this->userRepository->selectAllByRole($role);
    }

    // CORREÇÃO AQUI
    private function createUser(array $data): ?User
    {
        $isValidUserData = $this->validateUserData($data);

        if ($isValidUserData) {
            $user = new User();
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setPhoneNumber($data['phoneNumber']);
            $user->setGender($data['gender']);
            $user->setBirthDate($data['birth_date']);
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setRole($data['role']);
            $user->setCreatedAt(date('Y-m-d H:i:s'));

            return $user;
        }

        return null;
    }

    private function validateUserData(array $data): bool
    {
        $errors = [];
        if (empty($data['firstName']) || strlen(trim($data['firstName'])) < 3 || strlen(trim($data['firstName'])) > 50) {
            throw new InvalidUserFirstNameException();
        }
        if (empty($data['lastName']) || strlen(trim($data['lastName'])) < 2 || strlen(trim($data['lastName'])) > 50) {
            throw new InvalidUserLastNameException();
        }
        if (empty($data['phoneNumber']) || !preg_match('/^\d{10,15}$/', $data['phoneNumber'])) {
            throw new InvalidUserPhoneNumberException();
        }
        if (empty($data['gender'])) {
            throw new InvalidUserGenderException();
        }
        if (empty($data['birth_date'])) {
            throw new InvalidUserBirthDateException();
        }
        if (empty($data['username']) || strlen(trim($data['username'])) < 5 || strlen(trim($data['username'])) > 30) {
            throw new InvalidUsernameException();
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 255) {
            throw new InvalidUserEmailException();
        }
        if (empty($data['password']) || strlen($data['password']) < 6 || strlen($data['password']) > 50) {
            throw new InvalidUserPasswordException();
        }
        if (empty($data['confirmPassword']) || $data['password'] !== $data['confirmPassword']) {
            throw new InvalidUserConfirmPasswordException();
        }
        return true;
    }

    public function updateRole(int $id, string $role): bool
    {
        $allowedRoles = ['client', 'trainer', 'admin'];
        if (!in_array($role, $allowedRoles)) {
            return false;
        }
        return $this->userRepository->updateRole($id, $role);
    }
}