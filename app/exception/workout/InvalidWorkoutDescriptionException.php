<?php

require_once __DIR__ . "/../../exception/ValidationException.php";

class InvalidWorkoutDescriptionException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Descrição do treino inválida.");
    }
}
