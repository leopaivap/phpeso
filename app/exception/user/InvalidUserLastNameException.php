<?php
require_once __DIR__ . "/../../exception/ValidationException.php";

class InvalidUserLastNameException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Sobrenome inválido.");
    }
}

?>