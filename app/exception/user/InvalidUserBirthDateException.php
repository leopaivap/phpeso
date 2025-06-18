<?php

require_once __DIR__ . "/../../exception/ValidationException.php";
class InvalidUserBirthDateException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Data de aniversário inválida.");
    }
}

?>