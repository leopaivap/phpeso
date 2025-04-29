<?php
include_once "../connection.php";

if (!isset($_GET['id'])) {
    echo "ID não informado!";
    exit;
}

$id = $_GET['id'];

try {
    $stmt = $connection->prepare("DELETE FROM exercises WHERE id = :id");
    $stmt->execute([':id' => $id]);

    //header("Location: .../exercises.php?success=1");
} catch (PDOException $e) {
    // header("Location: .../exercises.php?error=1");
}
?>