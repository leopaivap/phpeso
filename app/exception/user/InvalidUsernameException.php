<?php

class InvalidUsernameException extends ValidationException
{
    public function __construct()
    {
        parent::__construct("Nome de usuário inválido.");
    }
}

?>