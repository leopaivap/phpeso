<?php
class ValidationException extends Exception
{
    public function __construct(string $message = "Erro de validação: ", string $error, int $code = 422)
    {
        parent::__construct("$message . $error", $code);
    }
}
?>