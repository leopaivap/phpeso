<?php
include_once "../connection.php";

date_default_timezone_set('America/Sao_Paulo');
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $errors = [];

    // Validações
    if (empty($_POST['exercise_name']) || strlen(trim($_POST['exercise_name'])) < 5) {
        $errors[] = 'O campo "Nome do Exercício" é obrigatório e deve ter pelo menos 5 caracteres.';
    }

    if (empty($_POST['exercise_type']) || strlen(trim($_POST['exercise_type'])) < 5) {
        $errors[] = 'O campo "Tipo de Exercício" é obrigatório e e deve ter pelo menos 5 caracteres.';
    }

    if (empty($_POST['description']) || strlen(trim($_POST['description'])) < 5) {
        $errors[] = 'O campo "Descrição" é obrigatório e deve ter pelo menos 5 caracteres.';
    }

    if (empty($_POST['muscle_group'])) {
        $errors[] = 'Você precisa selecionar um grupo muscular.';
    }

    if (empty($_POST['difficulty'])) {
        $errors[] = 'Você precisa selecionar a dificuldade.';
    }

    // Se houver erros, redireciona de volta com os erros
    if (!empty($errors)) {
        session_start();
        $_SESSION['erros'] = implode('<br>', $errors);
        header('Location: .../exercises.php');
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