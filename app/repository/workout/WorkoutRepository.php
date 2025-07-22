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

    public function insert(object $entity): ?int
    {
        try {
            $sql = "INSERT INTO workouts (name, description, trainer_id, created_at, updated_at) VALUES (:name, :description, :trainer_id, :created_at, :updated_at)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':name' => $entity->getName(), ':description' => $entity->getDescription(), ':trainer_id' => $entity->getTrainerId(), ':created_at' => $entity->getCreatedAt(), ':updated_at' => $entity->getCreatedAt()]);
            return (int) $this->connection->lastInsertId();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function update(int $id, object $entity): bool
    {
        try {
            $sql = "UPDATE workouts SET name = :name, description = :description, trainer_id = :trainer_id, updated_at = :updated_at WHERE id = :id;";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':name' => $entity->getName(), ':description' => $entity->getDescription(), ':trainer_id' => $entity->getTrainerId(), ':updated_at' => $entity->getUpdatedAt(), ':id' => $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function linkExercises(int $workoutId, array $exerciseIds)
    {
        $this->connection->beginTransaction();
        try {
            $stmt = $this->connection->prepare("DELETE FROM workout_exercises WHERE workout_id = :workout_id");
            $stmt->execute([':workout_id' => $workoutId]);

            $stmt = $this->connection->prepare("INSERT INTO workout_exercises (workout_id, exercise_id, day_of_week, sets, reps, rest_time) VALUES (:workout_id, :exercise_id, 'monday', 3, 12, '60s')"); // Valores padrão por simplicidade
            foreach ($exerciseIds as $exerciseId) {
                $stmt->execute([':workout_id' => $workoutId, ':exercise_id' => $exerciseId]);
            }
            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            return false;
        }
    }

    public function findExercisesForWorkout(int $workoutId): array
    {
        try {
            $sql = "SELECT e.*, mg.name as muscle_group_name 
                    FROM exercises e 
                    JOIN workout_exercises we ON e.id = we.exercise_id
                    LEFT JOIN muscle_groups mg ON e.muscle_group_id = mg.id
                    WHERE we.workout_id = :workout_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':workout_id' => $workoutId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function assignToClients(int $workoutId, array $clientIds): bool
    {
        $this->connection->beginTransaction();
        try {
            $stmt = $this->connection->prepare("DELETE FROM user_workouts WHERE workout_id = :workout_id");
            $stmt->execute([':workout_id' => $workoutId]);
            $stmt = $this->connection->prepare("INSERT INTO user_workouts (user_id, workout_id) VALUES (:user_id, :workout_id)");
            foreach ($clientIds as $clientId) {
                $stmt->execute([':user_id' => $clientId, ':workout_id' => $workoutId]);
            }
            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            return false;
        }
    }

    public function selectAll(int $trainer_id = null): array
    {
        try {
            $sql = "SELECT w.*, u.firstName as trainerFirstName, u.lastName as trainerLastName 
                    FROM workouts w
                    LEFT JOIN users u ON w.trainer_id = u.id";
            if ($trainer_id !== null) {
                $sql .= " WHERE w.trainer_id = :trainer_id";
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

    public function findAssignedToClient(int $clientId): array
    {
        try {
            $sql = "SELECT w.*, u.firstName as trainerFirstName, u.lastName as trainerLastName 
                    FROM workouts w 
                    JOIN user_workouts uw ON w.id = uw.workout_id
                    LEFT JOIN users u ON w.trainer_id = u.id
                    WHERE uw.user_id = :user_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':user_id' => $clientId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function findById(int $id): ?array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM workouts WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $workout = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$workout)
                return null;

            $clientStmt = $this->connection->prepare("SELECT user_id FROM user_workouts WHERE workout_id = :id");
            $clientStmt->execute([':id' => $id]);
            $workout['client_ids'] = $clientStmt->fetchAll(PDO::FETCH_COLUMN);

            $exerciseStmt = $this->connection->prepare("SELECT exercise_id FROM workout_exercises WHERE workout_id = :id");
            $exerciseStmt->execute([':id' => $id]);
            $workout['exercise_ids'] = $exerciseStmt->fetchAll(PDO::FETCH_COLUMN);

            return $workout;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM workouts WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}