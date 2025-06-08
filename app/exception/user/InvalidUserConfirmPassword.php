<?php
require_once "./app/exception/ValidationException.php";

class InvalidUserConfirmPasswordException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Senha inválida.");
    }
}
