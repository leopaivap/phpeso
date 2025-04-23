<?php
$server = 'localhost';
$user = 'root';
$password = '';

try {
    $dsn = "mysql:host=$server;charset=utf8";
    $connection = new PDO($dsn, $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS db_phpeso";
    $connection->exec($sql);

    echo "Banco de dados 'db_phpeso' criado com sucesso (ou já existia).";
} catch (PDOException $e) {
    echo "Erro ao criar o banco de dados: " . $e->getMessage();
}
?>