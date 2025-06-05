<?php

require_once __DIR__ . '/../app/controllers/UserController.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // TODO CRIAR A SERVICE E APLICAR ESSA REGRA... A SERVICE ACESSA REPOSITORY....
    /* 
    $errors UserValidator::validate($data);
    if (!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        header('Location: /views/register.php');
        exit;
    }
    */
    $userController = new UserController();
    $userController->insert($POST);
}

?>