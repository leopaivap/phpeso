<?php
require_once __DIR__ . "/../../repository/Connection.php";
require_once __DIR__ . "/../../repository/RepositoryInterface.php";

class ExerciseRepository implements RepositoryInterface
{
    private $connection;
    public function __construct()
    {
        $this->connection = Connection::getInstance()->getConnection();
    }

    public function insert(object $entity): ?int
    {
        try {
            $sql = "INSERT INTO exercises (name, muscle_group_id, exercise_type, difficulty, description, trainer_id, created_at) VALUES (:name, :muscle_group_id, :exercise_type, :difficulty, :description, :trainer_id, :created_at)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':name' => $entity->getName(), ':muscle_group_id' => $entity->getMuscleGroupId(), ':exercise_type' => $entity->getExerciseType(), ':difficulty' => $entity->getDifficulty(), ':description' => $entity->getDescription(), ':trainer_id' => $entity->getTrainerId(), ':created_at' => $entity->getCreatedAt()]);
            return (int) $this->connection->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function update(int $id, object $entity): bool
    {
        try {
            $sql = "UPDATE exercises SET name = :name, muscle_group_id = :muscle_group_id, exercise_type = :exercise_type, difficulty = :difficulty, description = :description WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':name' => $entity->getName(), ':muscle_group_id' => $entity->getMuscleGroupId(), ':exercise_type' => $entity->getExerciseType(), ':difficulty' => $entity->getDifficulty(), ':description' => $entity->getDescription(), ':id' => $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function selectAll(int $trainer_id = null): array
    {
        try {
            $sql = "SELECT e.*, u.firstName as trainerFirstName, u.lastName as trainerLastName 
                    FROM exercises AS e 
                    LEFT JOIN users u ON e.trainer_id = u.id";
            if ($trainer_id !== null) {
                $sql .= " WHERE e.trainer_id = :trainer_id";
            }

            $stmt = $this->connection->prepare($sql);
            if ($trainer_id !== null) {
                $stmt->bindParam(':trainer_id', $trainer_id, PDO::PARAM_INT);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM exercises WHERE id = :id;");
            $stmt->execute([":id" => $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function findById(int $id): ?array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM exercises WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }
}