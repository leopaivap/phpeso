<?php
include_once "../connection.php";

function validateUser($connection, $data)
{
    $errors = [];

    if (empty($data['firstName']) || strlen(trim($data['firstName'])) < 2 || strlen(trim($data['firstName'])) > 50) {
        $errors[] = 'O campo "Nome" é obrigatório e deve ter entre 2 e 50 caracteres.';
    }

    if (empty($data['lastName']) || strlen(trim($data['lastName'])) < 2 || strlen(trim($data['lastName'])) > 50) {
        $errors[] = 'O campo "Sobrenome" é obrigatório e deve ter entre 2 e 50 caracteres.';
    }

    if (empty($data['phoneNumber']) || !preg_match('/^\d{10,15}$/', $data['phoneNumber'])) {
        $errors[] = 'O campo "Telefone" é obrigatório e deve conter entre 10 e 15 dígitos numéricos.';
    }

    if (empty($data['gender'])) {
        $errors[] = 'O campo "Gênero" é obrigatório.';
    }

    if (empty($data['birth_date'])) {
        $errors[] = 'O campo "Data de Nascimento" é obrigatório.';
    }

    if (empty($data['username']) || strlen(trim($data['username'])) < 5 || strlen(trim($data['username'])) > 30) {
        $errors[] = 'O campo "Usuário" é obrigatório e deve ter entre 5 e 30 caracteres.';
    }

    if (!validateUsernameAvailable($connection, $data['username'])) {
        $errors[] = "O nome de usuário {$data['username']} já está em uso.";
    }

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 255) {
        $errors[] = 'Informe um email válido com no máximo 255 caracteres.';
    }

    if (empty($data['password']) || strlen($data['password']) < 6 || strlen($data['password']) > 50) {
        $errors[] = 'A senha deve ter entre 6 e 50 caracteres.';
    }

    if (!isset($data['confirmPassword']) || $data['password'] !== $data['confirmPassword']) {
        $errors[] = 'As senhas não coincidem.';
    }

    return $errors;
}

function validateUsernameAvailable($connection, $username)
{
    date_default_timezone_set('America/Sao_Paulo');
    try {
        $stmt = $connection->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->execute([':username' => $username,]);
        $count = $stmt->fetchColumn();

        return $count == 0;
    } catch (PDOException $e) {
        return false;
    }
}
?>