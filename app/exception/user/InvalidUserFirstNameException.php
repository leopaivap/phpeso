<?php
require_once "./app/exception/ValidationException.php";

class InvalidUserFirstNameException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Nome inválido.");
    }
}

?>