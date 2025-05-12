<?php
function validateExercise($data)
{
    $errors = [];

    if (empty($data['exercise_name']) || strlen(trim($data['exercise_name'])) < 5 || strlen(trim($data['exercise_name'])) > 30) {
        $errors[] = 'O campo "Nome do Exercício" é obrigatório e deve ter entre 5 e 30 caracteres.';
    }

    if (empty($data['exercise_type']) || strlen(trim($data['exercise_type'])) < 5 || strlen(trim($data['exercise_type'])) > 30) {
        $errors[] = 'O campo "Tipo de Exercício" é obrigatório e deve ter entre 5 e 30 caracteres.';
    }
    if (empty($data['description']) || strlen(trim($data['description'])) < 5 || strlen(trim($data['description'])) > 55) {
        $errors[] = 'O campo "Descrição" é obrigatório e deve ter entre 5 e 55 caracteres.';
    }

    if (empty($data['muscle_group'])) {
        $errors[] = 'O campo "Grupo Muscular" é obrigatório.';
    }

    return $errors;
}
?>