<?php

class InvalidUserEmailException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("E-mail inválido.");
    }
}

?>