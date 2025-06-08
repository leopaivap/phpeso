<?php
class ValidationException extends Exception
{
    public function __construct(string $error)
    {
        parent::__construct("Erro de validação: $error", 442);
    }
}
