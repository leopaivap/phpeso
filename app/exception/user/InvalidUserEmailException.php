<?php
require_once __DIR__ . "/../../exception/ValidationException.php";
class InvalidUserEmailException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("E-mail inválido.");
    }
}
