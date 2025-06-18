<?php
include_once "../connection.php";

function validateUsernameAvailable($connection, $username)
{
    date_default_timezone_set('America/Sao_Paulo');
    try {
        $stmt = $connection->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->execute([':username' => $username,]);
        $count = $stmt->fetchColumn();

        return $count == 0;
    } catch (PDOException $e) {
        return false;
    }
}
