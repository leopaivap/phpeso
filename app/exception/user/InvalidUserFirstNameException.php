<?php
require_once __DIR__ . "/../../exception/ValidationException.php";
class InvalidUserFirstNameException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Nome inválido.");
    }
}
