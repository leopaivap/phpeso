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

    public function insert(object $entity): bool
    {

        try {
            $sql = "
                INSERT INTO users 
                (
                    firstName, 
                    lastName, 
                    phoneNumber, 
                    gender, 
                    birth_date, 
                    username, 
                    email, 
                    password, 
                    role, 
                    created_at
                ) 
                VALUES (
                    :firstName, 
                    :lastName, 
                    :phoneNumber, 
                    :gender, 
                    :birth_date, 
                    :username, 
                    :email, 
                    :password, 
                    :role, 
                    :created_at
                );
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

            return true;
        } catch (PDOException $e) {
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
            return false;
        }
    }

    public function update(int $id, object $entity): bool
    {
        try {
            $sql = "
                UPDATE INTO users AS u SET
                u.firstName   = :firstName,
                u.lastName    = :lastName,
                u.phoneNumber = :phoneNumber,
                u.gender      = :gender,
                u.birth_date  = :birth_date,
                u.username    = :username,
                u.email       = :email
                WHERE u.id = :id;
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                "firstname" => $entity->getFirstName(),
                "lastName" => $entity->getLastName(),
                "phoneNumber" => $entity->getPhoneNumber(),
                "gender" => $entity->getGender(),
                "birth_date" => $entity->getBirthDate(),
                "username" => $entity->getUsername(),
                "email" => $entity->getEmail(),
                "id" => $id
            ]);
        } catch (PDOException $e) {
            echo "Erro ao alterar dados do usuário: " . $e->getMessage();
            return false;
        }
        return false;
    }
    public function selectAll(): array
    {
        $users = [];
        try {
            $sql = "
            SELECT 
            u.id, 
            u.username, 
            u.firstName, 
            u.lastName, 
            u.email, 
            u.phoneNumber, 
            u.gender,
            u.birth_date 
            FROM users AS u;";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        } catch (PDOException $e) {
            echo "Erro ao buscar usuários: " . $e->getMessage();
            return [];
        }
    }

    public function findById(int $id): array|null
    {
        try {
            $sql = "
                SELECT id, firstName, lastName, username, email, phoneNumber, gender FROM users WHERE id = :id;
            ";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ":id" => $id
            ]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $userData;
        } catch (PDOException $e) {
            echo "Erro ao buscar usuário por ID: " . $e->getMessage();
            return null;
        }
    }

    public function selectAllByRole(string $role): array
    {
        $users = [];
        try {
            $sql = "
            SELECT 
            u.id, 
            u.username, 
            u.firstName, 
            u.lastName
            FROM users AS u 
            WHERE u.role = :role;";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ":role" => $role
            ]);

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        } catch (PDOException $e) {
            echo "Erro ao buscar usuários por função: " . $e->getMessage();
            return [];
        }
    }

    public function delete(int $id): bool
    {
        try {
            $sql = "DELETE FROM users AS u WHERE u.id = :id";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute([
                ':id' => $id
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erro ao deletar usuário: " . $e->getMessage();
            return false;
        }
    }

    public function findByUsername(string $username): array|null
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
}
