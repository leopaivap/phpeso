<?php
require_once __DIR__ . "/../../exception/ValidationException.php";

class InvalidUserPasswordException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("As senhas não coincidem.");
    }
}

?>