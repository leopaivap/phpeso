<?php

require_once "./app/exception/ValidationException.php";

class InvalidExerciseDescriptionException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Descrição do exercício inválida.");
    }
}
