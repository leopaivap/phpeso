<?php
include_once "../connection.php";
include_once "exercise-validator.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['id'])) {
    session_start();
    $errors = validateExercise($_POST);

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: ../../exercises.php?id=" . $_GET['id']);
        exit;
    }

    $exercise_name = $_POST['exercise_name'];
    $muscle_group_id = $_POST['muscle_group'];
    $exercise_type = $_POST['exercise_type'];
    $difficulty = $_POST['difficulty'];
    $description = $_POST['description'];

    try {
        $stmt = $connection->prepare("
            UPDATE exercises SET
                name = :name,
                muscle_group_id = :muscle_group_id,
                exercise_type = :type,
                difficulty = :difficulty,
                description = :description
            WHERE id = :id
        ");
        $stmt->execute([
            ':name' => $exercise_name,
            ':muscle_group_id' => $muscle_group_id,
            ':type' => $exercise_type,
            ':difficulty' => $difficulty,
            ':description' => $description,
            ':id' => $_GET['id']
        ]);
        header("Location: ../../exercises.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar exercício: " . $e->getMessage();
    }
}
