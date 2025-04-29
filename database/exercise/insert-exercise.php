<?php
include_once "../connection.php";
include_once "exercise-validator.php";

date_default_timezone_set('America/Sao_Paulo');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = validateExercise($_POST);

    if (count($errors) > 0) {
        session_start();
        $_SESSION['errors'] = $errors;
        header("Location: ../../exercises.php");
        exit;
    }

    $exercise_name = $_POST['exercise_name'];
    $muscle_group_id = $_POST['muscle_group'];
    $exercise_type = $_POST['exercise_type'];
    $difficulty = $_POST['difficulty'];
    $description = $_POST['description'];
    $created_at = date("Y-m-d H:i:s");


    if (!$exercise_name || !$exercise_type || !$description) {
        echo "Erro: Nome, Tipo e Descrição do exercício são obrigatórios!";
        exit;
    }

    try {
        $stmt = $connection->prepare("
            INSERT INTO exercises 
                (name, muscle_group_id, exercise_type, difficulty, description, created_at)
            VALUES
                (:exercise_name, :muscle_group_id, :exercise_type, :difficulty, :description, :created_at)
        ");

        $stmt->execute([
            ':exercise_name' => $exercise_name,
            ':muscle_group_id' => $muscle_group_id,
            ':exercise_type' => $exercise_type,
            ':difficulty' => $difficulty,
            ':description' => $description,
            ':created_at' => $created_at
        ]);

        echo "Exercício cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    }
}
?>