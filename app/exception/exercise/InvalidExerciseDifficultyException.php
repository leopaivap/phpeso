<?php

require_once "./app/exception/ValidationException.php";

class InvalidExerciseDifficultyException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Dificuldade do exercício inválida.");
    }
}
