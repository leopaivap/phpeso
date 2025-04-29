<?php
include_once 'create-database.php';
include_once 'create-table.php';

$server = 'localhost';
$user = 'root';
$password = '';
$database = 'db_phpeso';

try {
    $dsn = "mysql:host=$server;dbname=$database;charset=utf8";

    $connection = new PDO($dsn, $user, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // echo "Conexão com o SGBD estabelecida com sucesso!";
} catch (PDOException $e) {
   // echo "Erro na conexão com o servidor: " . $e->getMessage();
}
?>