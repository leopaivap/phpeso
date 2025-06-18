<?php
require_once __DIR__ . "/../../exception/ValidationException.php";

class InvalidUserGenderException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Gênero inválido.");
    }
}

?>