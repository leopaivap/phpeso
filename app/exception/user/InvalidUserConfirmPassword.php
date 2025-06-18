<?php

require_once __DIR__ . "/../../exception/ValidationException.php";
class InvalidUserConfirmPasswordException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Senha inválida.");
    }
}
