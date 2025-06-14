<?php
require_once __DIR__ . "/../../exception/ValidationException.php";

class InvalidUserPhoneNumberException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Número de telefone inválido.");
    }
}
