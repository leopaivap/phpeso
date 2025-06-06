<?php

class InvalidUserConfirmPasswordException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Senha inválido.");
    }
}

?>