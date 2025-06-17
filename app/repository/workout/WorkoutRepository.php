<?php

require_once __DIR__ . "/../../repository/Connection.php";
require_once __DIR__ . "/../../repository/RepositoryInterface.php";

date_default_timezone_set('America/Sao_Paulo');
class WorkoutRepository implements RepositoryInterface
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
                INSERT INTO workouts (
                    name, 
                    description, 
                    student_id, 
                    trainer_id,
                    created_at,
                    updated_at
                ) VALUES (
                    :name,
                    :description,
                    :student_id,
                    :trainer_id,
                    :created_at,
                    :updated_at
                )
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ':name' => $entity->getName(),
                ':description' => $entity->getDescription(),
                ':student_id' => $entity->getStudentId(),
                ':trainer_id' => $entity->getTrainerId(),
                ':created_at' => $entity->getCreatedAt(),
                ':updated_at' => $entity->getCreatedAt()
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erro ao cadastrar treino: " . $e->getMessage();
            return false;
        }
    }

    public function update(int $id, object $entity): bool
    {
        try {
            $sql = "
                UPDATE workouts SET
                    name = :name,
                    description = :description,
                    student_id = :student_id,
                    trainer_id = :trainer_id,
                    updated_at = :updated_at
                WHERE id = :id;
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ":name" => $entity->getName(),
                ":description" => $entity->getDescription(),
                ":student_id" => $entity->getStudentId(),
                ":trainer_id" => $entity->getTrainerId(),
                ":updated_at" => $entity->getUpdatedAt(),
                ":id" => $id
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erro ao alterar dados do treino: " . $e->getMessage();
            return false;
        }
    }
    public function selectAll(): array
    {
        $workouts = [];
        try {
            $sql = "
                SELECT * FROM workouts;
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $workouts;
        } catch (PDOException $e) {
            echo "Erro ao buscar treinos: " . $e->getMessage();
            return [];
        }
    }

    public function findById(int $id): array|null
    {
        try {
            $sql = "
                SELECT id, name, description, student_id, trainer_id FROM workouts WHERE id = :id;
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute(
                [
                    ":id" => $id
                ]
            );

            $workout = $stmt->fetch(PDO::FETCH_ASSOC);

            return $workout;
        } catch (PDOException $e) {
            echo "Erro ao buscar treino por ID: " . $e->getMessage();
            return null;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $sql = "
                DELETE FROM workouts WHERE id = :id
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ':id' => $id
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erro ao deletar treino: " . $e->getMessage();
            return false;
        }
    }
}
