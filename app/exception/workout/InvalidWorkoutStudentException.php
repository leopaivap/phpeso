<?php

require_once __DIR__ . "/../../exception/ValidationException.php";

class InvalidWorkoutStudentException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Aluno inválido.");
    }
}
