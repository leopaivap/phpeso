<?php

require_once "./app/exception/ValidationException.php";

class InvalidExerciseNameException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Nome do exercício inválido.");
    }
}
