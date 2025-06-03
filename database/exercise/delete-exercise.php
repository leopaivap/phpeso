<?php
include_once "../../auth-guard.php";

// Definimos quais 'roles' podem executar esta ação.
$allowed_roles = ['admin', 'trainer'];
if (!in_array($_SESSION['user_role'], $allowed_roles)) {
    echo "Acesso negado. Você não tem permissão para realizar esta ação.";
    exit;
}

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