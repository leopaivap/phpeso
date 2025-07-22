<?php

require_once __DIR__ . "/../../repository/Connection.php";
require_once __DIR__ . "/../../repository/RepositoryInterface.php";

date_default_timezone_set('America/Sao_Paulo');
class UserRepository implements RepositoryInterface
{

    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance()->getConnection();
    }

    public function insert(object $entity): ?int
    {
        try {
            $sql = "
                INSERT INTO users 
                (firstName, lastName, phoneNumber, gender, birth_date, username, email, password, role, created_at) 
                VALUES (:firstName, :lastName, :phoneNumber, :gender, :birth_date, :username, :email, :password, :role, :created_at);
            ";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':firstName' => $entity->getFirstName(),
                ':lastName' => $entity->getLastName(),
                ':phoneNumber' => $entity->getPhoneNumber(),
                ':gender' => $entity->getGender(),
                ':birth_date' => $entity->getBirthDate(),
                ':username' => $entity->getUsername(),
                ':email' => $entity->getEmail(),
                ':password' => $entity->getPassword(),
                ':role' => $entity->getRole(),
                ':created_at' => $entity->getCreatedAt()
            ]);
            return (int) $this->connection->lastInsertId();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
            return null;
        }
    }

    public function update(int $id, object $entity): bool
    {
        // Este método não está sendo usado, mas mantemos para conformidade
        return false;
    }

    public function selectAll(): array
    {
        try {
            $sql = "SELECT u.id, u.username, u.firstName, u.lastName, u.email, u.phoneNumber, u.gender, u.birth_date, u.role FROM users AS u;";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar usuários: " . $e->getMessage();
            return [];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            echo "Erro ao deletar usuário: " . $e->getMessage();
            return false;
        }
    }

    // Métodos específicos do UserRepository que não estão na interface
    public function findByUsername(string $username): ?array
    {
        try {
            $sql = "SELECT id, username, password, role, firstName FROM users WHERE username = :username";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([":username" => $username]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userData ?: null;
        } catch (PDOException $e) {
            echo "Erro ao buscar usuário por username: " . $e->getMessage();
            return null;
        }
    }

    public function selectAllByRole(string $role): array
    {
        try {
            $sql = "SELECT u.id, u.username, u.firstName, u.lastName FROM users AS u WHERE u.role = :role;";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([":role" => $role]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar usuários por função: " . $e->getMessage();
            return [];
        }
    }

    public function updateRole(int $id, string $role): bool
    {
        try {
            $sql = "UPDATE users SET role = :role WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':role' => $role, ':id' => $id]);
            return true;
        } catch (PDOException $e) {
            echo "Erro ao alterar a permissão do usuário: " . $e->getMessage();
            return false;
        }
    }
}