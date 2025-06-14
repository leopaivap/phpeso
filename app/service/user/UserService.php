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

        if ($response) return true;

        return false;
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->createUser($data);
        $response = false;

        if ($user != null) {
            $response = $this->userRepository->update($id, $user);
        }

        if ($response) return true;

        return false;
    }

    public function delete(int $id): bool
    {
        $response = false;

        if ($id != null && !empty($id)) {
            $response = $this->userRepository->delete($id);
        }

        if ($response) return true;

        return false;
    }

    public function selectAll(): array
    {
        $response = $this->userRepository->selectAll();

        if (!empty($response) && $response != null) {
            return $response;
        }

        return [];
    }

    public function findById(int $id): User | null
    {
        $userData = $this->userRepository->findById($id);

        if (!empty($userData) && $userData != null) {

            $user = new User();
            // Settar os campos que for usar
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);
            return $user;
        }

        return null;
    }

    public function selectAllByRole(string $role): array
    {
        $users = $this->userRepository->selectAllByRole($role);

        if (!empty($users) && $users != null) {
            return $users;
        }

        return [];
    }

    private function createUser(array $data): User | null
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
            $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
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
            $errors[] = 'O campo "Nome" é obrigatório e deve ter entre 2 e 50 caracteres.';
            throw new InvalidUserFirstNameException();
        }

        if (empty($data['lastName']) || strlen(trim($data['lastName'])) < 2 || strlen(trim($data['lastName'])) > 50) {
            $errors[] = 'O campo "Sobrenome" é obrigatório e deve ter entre 2 e 50 caracteres.';
            throw new InvalidUserLastNameException();
        }

        if (empty($data['phoneNumber']) || !preg_match('/^\d{10,15}$/', $data['phoneNumber'])) {
            $errors[] = 'O campo "Telefone" é obrigatório e deve conter entre 10 e 15 dígitos numéricos.';
            throw new InvalidUserPhoneNumberException();
        }

        if (empty($data['gender'])) {
            $errors[] = 'O campo "Gênero" é obrigatório.';
            throw new InvalidUserGenderException();
        }

        if (empty($data['birth_date'])) {
            $errors[] = 'O campo "Data de Nascimento" é obrigatório.';
            throw new InvalidUserBirthDateException();
        }

        if (empty($data['username']) || strlen(trim($data['username'])) < 5 || strlen(trim($data['username'])) > 30) {
            $errors[] = 'O campo "Usuário" é obrigatório e deve ter entre 5 e 30 caracteres.';
            throw new InvalidUsernameException();
        }

        // TODO --> VALIDAR USERNAME
        // if (!validateUsernameAvailable($connection, $data['username'])) {
        //     $errors[] = "O nome de usuário {$data['username']} já está em uso.";
        // }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 255) {
            $errors[] = 'Informe um email válido com no máximo 255 caracteres.';
            throw new InvalidUserEmailException();
        }

        if (empty($data['password']) || strlen($data['password']) < 6 || strlen($data['password']) > 50) {
            $errors[] = 'A senha deve ter entre 6 e 50 caracteres.';
            throw new InvalidUserPasswordException();
        }
        if (empty($data['confirmPassword']) || $data['password'] !== $data['confirmPassword']) {
            $errors[] = 'As senhas não coincidem.';
            throw new InvalidUserConfirmPasswordException();
        }

        if (empty($errors))
            return true;

        return false;
    }
}
