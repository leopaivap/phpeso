<?php
require_once __DIR__ . '/Connection.php';

try {
    $db_config = Connection::getInstance()->getDatabaseConfig();
    $dsn = "mysql:host={$db_config['db_server']};dbname={$db_config['db_name']};charset=utf8";
    $connection = new PDO($dsn, $db_config['db_user'], $db_config['db_password'], $db_config['db_options']);

    // TABELA USUÁRIOS
    $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstName VARCHAR(255) NOT NULL,
            lastName VARCHAR(255) NOT NULL,
            phoneNumber VARCHAR(255) NOT NULL,
            gender ENUM('male', 'female', 'other', 'prefer_not_to_say') DEFAULT NULL,
            birth_date DATE NOT NULL,
            
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'trainer', 'client') DEFAULT 'client',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";
    $connection->exec($sql);
    // echo "Tabela 'users' criada com sucesso (ou já existia).<br>";

    // TABELA DE GRUPOS MUSCULARES
    $sql = "
        CREATE TABLE muscle_groups (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );    
    ";
    $connection->exec($sql);
    // echo "Tabela 'muscle_groups' criada com sucesso (ou já existia).<br>";

    // TABELA DE EXERCÍCIOS
    $sql = "
        CREATE TABLE IF NOT EXISTS exercises (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            muscle_group_id INT NOT NULL,
            exercise_type VARCHAR(255) NOT NULL,
            difficulty ENUM('beginner', 'intermediate', 'advanced') DEFAULT NULL, 
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (muscle_group_id) REFERENCES muscle_groups(id)
        );
    ";
    $connection->exec($sql);
    // echo "Tabela 'exercises' criada com sucesso (ou já existia).<br>";

    $sql = "
        CREATE TABLE workouts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            student_id INT NOT NULL,
            trainer_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (trainer_id) REFERENCES users(id)
        );
    ";
    $connection->exec($sql);
    //   echo "Tabela 'workouts' criada com sucesso (ou já existia).<br>";

    $sql = "
            CREATE TABLE workout_exercises (
                id INT AUTO_INCREMENT PRIMARY KEY,
                workout_id INT NOT NULL,
                exercise_id INT NOT NULL,
                day_of_week ENUM( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' ) NOT NULL,
                sets INT NOT NULL,
                reps INT NOT NULL,
                rest_time VARCHAR(20),
                FOREIGN KEY (workout_id) REFERENCES workouts(id) ON DELETE CASCADE,
                FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE       
            );
    ";
    $connection->exec($sql);
    // echo "Tabela 'workout_exercises' criada com sucesso (ou já existia).<br>";

} catch (PDOException $e) {
    // echo "Erro ao criar a tabela: " . $e->getMessage();
}
