<?php

require_once __DIR__ . "/../../exception/ValidationException.php";

class InvalidWorkoutTrainerException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Treinador inválido.");
    }
}
