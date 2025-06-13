<?php
require_once __DIR__ . '/../Connection.php';
require_once __DIR__ . '/../RepositoryInterface.php';

class MuscleGroupRepository implements RepositoryInterface
{
    private $connection;
    public function __construct()
    {
        $this->connection = Connection::getInstance()->getConnection();
    }
    public function selectAll(): array
    {
        $muscleGroups = [];
        try {
            $sql = "
            SELECT id, name FROM muscle_groups ORDER BY name ASC;
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();
            $muscleGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $muscleGroups;
        } catch (PDOException $e) {
            echo "Erro ao buscar grupos musculares: " . $e->getMessage();
            return [];
        }
    }

    public function insert(object $entity): bool
    {
        return false;
    }
    public function update(int $id, object $entity): bool
    {
        return false;
    }
    public function delete(int $id): bool
    {
        return false;
    }

}
?>