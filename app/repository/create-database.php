<?php
require_once __DIR__ . "/../../repository/Connection.php";

try {
  $db_config = Connection::getInstance()->getDatabaseConfig();
  $dsn = "mysql:host={$db_config['db_server']};charset=utf8";
  $connection = new PDO($dsn, $db_config['db_user'], $db_config['db_password'], $db_config['db_options']);

  $sql = "CREATE DATABASE IF NOT EXISTS db_phpeso";
  $connection->exec($sql);
} catch (PDOException $e) {
}
?>