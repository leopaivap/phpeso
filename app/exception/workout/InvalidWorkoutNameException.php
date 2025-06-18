<?php

require_once __DIR__ . "/../../exception/ValidationException.php";

class InvalidWorkoutNameException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Nome do treino inválido.");
    }
}
