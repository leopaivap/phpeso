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

        $errors[] = $this->validateUserData($data);

        if (count($errors) > 0)
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
        $isValidUserData = $this->validateUserData($data);

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
        if (!isset($data['confirmPassword']) || $data['password'] !== $data['confirmPassword']) {
            $errors[] = 'As senhas não coincidem.';
            throw new InvalidUserConfirmPasswordException();
        }

        if (empty($errors))
            return true;

        return false;
    }
}

?>