<?php

require_once "./app/exception/ValidationException.php";

class InvalidExerciseMuscleGroupException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Grupo muscular do exercício inválido.");
    }
}
