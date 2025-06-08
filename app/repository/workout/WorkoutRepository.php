<?php

require_once "./app/repository/Connection.php";
require_once "./app/repository/RepositoryInterface.php";

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
                INSERT INTO table_name 
                (
                    created_at
                ) 
                VALUES (

                    :created_at
                );
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ':created_at' => $entity->getCreatedAt()
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
            $sql = "";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                "id" => $id
            ]);
        } catch (PDOException $e) {
            echo "Erro ao alterar dados do treino: " . $e->getMessage();
            return false;
        }
        return false;
    }
    public function selectAll(): array
    {
        $users = [];
        try {
            $sql = "";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        } catch (PDOException $e) {
            echo "Erro ao buscar treinos: " . $e->getMessage();
            return [];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $sql = "";

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
