<?php

class InvalidUserGenderException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Gênero inválido.");
    }
}

?>