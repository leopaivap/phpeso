<?php
include_once "../connection.php";

if (!isset($_GET['id'])) {
    header("Location: ../../exercises.php");
    exit;
}

$id = $_GET['id'];

try {
    $stmt = $connection->prepare("DELETE FROM exercises WHERE id = :id");
    $stmt->execute([':id' => $id]);
} catch (PDOException $e) {
    // error_log($e->getMessage());
}

header("Location: ../../exercises.php");
exit;
?>
