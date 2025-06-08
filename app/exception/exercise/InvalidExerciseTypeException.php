<?php

require_once "./app/exception/ValidationException.php";

class InvalidExerciseTypeException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Tipo do exercício inválido.");
    }
}
