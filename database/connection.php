<?php
$server = 'localhost';
$user = 'root';
$password = '';

try {
    $dsn = "mysql:host=$server;charset=utf8";

    $connection = new PDO($dsn, $user, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexão com o SGBD estabelecida com sucesso!";
} catch (PDOException $e) {
    echo "Erro na conexão com o servidor: " . $e->getMessage();
}
?>