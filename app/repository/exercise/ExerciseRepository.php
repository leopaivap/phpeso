<?php

require_once "./app/repository/Connection.php";
require_once "./app/repository/RepositoryInterface.php";

date_default_timezone_set('America/Sao_Paulo');
class ExerciseRepository implements RepositoryInterface
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance()->getConnection();
    }

    public function insert(object $entity): bool
    {
        try {
            $sql = "
            INSERT INTO exercises 
            (
                name, 
                muscle_group_id, 
                exercise_type, 
                difficulty, 
                description, 
                created_at
            )
            VALUES
            (
                :name, 
                :muscle_group_id, 
                :exercise_type, 
                :difficulty, 
                :description, 
                :created_at
            )";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ":name" => $entity->getName(),
                ":muscle_group_id" => $entity->getMuscleGroupId(),
                ":exercise_type" => $entity->getExerciseType(),
                ":difficulty" => $entity->getDifficulty(),
                ":description" => $entity->getDescription(),
                ":created_at" => $entity->getCreatedAt(),
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erro ao cadastrar exercício: " . $e->getMessage();
            return false;
        }
    }
    public function update(int $id, object $entity): bool
    {
        try {
            $sql = "
            UPDATE exercises AS e SET
            e.name = :name,
            e.muscle_group_id = :muscle_group_id,
            e.exercise_type = :type,
            e.difficulty = :difficulty,
            e.description = :description
            WHERE e.id = :id
            ";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ":name" => $entity->getName(),
                ":muscle_group_id" => $entity->getMuscleGroupId(),
                ":exercise_type" => $entity->getExerciseType(),
                ":difficulty" => $entity->getDifficulty(),
                ":description" => $entity->getDescription(),
                ":id" => $id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Erro ao alterar dados do exercício: " . $e->getMessage();
            return false;
        }
    }

    public function selectAll(): array
    {
        $exercises = [];
        try {
            $sql = "
            SELECT
            e.name
            e.muscle_group_id
            e.exercise_type
            e.difficulty
            e.description
            FROM exercises AS e;
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            return $exercises;
        } catch (PDOException $e) {
            echo "Erro ao buscar exercícios: " . $e->getMessage();
            return [];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $sql = "
            DELETE FROM exercises AS e WHERE e.id = :id;
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ":id" => $id
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erro ao deletar exercício: " . $e->getMessage();
            return false;
        }
    }
}
