<?php
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'db_phpeso';

try {
    $dsn = "mysql:host=$server;dbname=$database;charset=utf8";
    $connection = new PDO($dsn, $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        CREATE TABLE IF NOT EXISTS trainings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            user_id INT NOT NULL,
            day_of_week ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL,
            goal VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
    ";
    $connection->exec($sql);
 //   echo "Tabela 'trainings' criada com sucesso (ou já existia).<br>";

    $sql = "
        CREATE TABLE IF NOT EXISTS training_exercises (
            id INT AUTO_INCREMENT PRIMARY KEY,
            training_id INT NOT NULL,
            exercise_id INT NOT NULL,
            sets INT NOT NULL,
            reps INT NOT NULL,
            weight DECIMAL(10,2),
            rest_time INT,
            FOREIGN KEY (training_id) REFERENCES trainings(id) ON DELETE CASCADE,
            FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE
            );
    ";
    $connection->exec($sql);
   // echo "Tabela 'training_exercises' criada com sucesso (ou já existia).<br>";

} catch (PDOException $e) {
   // echo "Erro ao criar a tabela: " . $e->getMessage();
}
?>