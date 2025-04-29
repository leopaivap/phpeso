<?php
include_once "../connection.php";
include_once "user-validator.php";


date_default_timezone_set('America/Sao_Paulo');
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $errors = validateUser($_POST);

    if (count($errors) > 0) {
        session_start();
        $_SESSION['errors'] = $errors;
        header("Location: ../../register.php");
        exit;
    }

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $gender = $_POST['gender'];

    $birth_date = $_POST['birth_date'];

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $created_at = date("Y-m-d H:i:s");

    try {
        $stmt = $connection->prepare("
            INSERT INTO users 
                (firstName, lastName, phoneNumber, gender, birth_date, username, email, password, role, created_at)
            VALUES
                (:firstName, :lastName, :phoneNumber, :gender, :birth_date, :username, :email, :password, :role, :created_at)
        ");

        $stmt->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':phoneNumber' => $phoneNumber,
            ':gender' => $gender,
            ':birth_date' => $birth_date,
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role,
            ':created_at' => $created_at
        ]);

        echo "Usuário cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    }
}
?>