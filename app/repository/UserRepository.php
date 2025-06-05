<?php

include_once "./Connection.php";
include_once "user-validator.php";

date_default_timezone_set('America/Sao_Paulo');
class UserRepository implements RepositoryInterface
{
    public function __construct(PDO $pdo)
    {

    }

    public function insert(object $entity): bool
    {
        $connection = Connection::getInstance()->getConnection();

        try {
            $stmt = $connection->prepare("
                INSERT INTO users 
                    (firstName, lastName, phoneNumber, gender, birth_date, username, email, password, role, created_at)
                VALUES
                    (:firstName, :lastName, :phoneNumber, :gender, :birth_date, :username, :email, :password, :role, :created_at);
            ");

            $stmt->execute([
                ':firstName' => $entity::getFirstName(),
                ':lastName' => $entity::getLastName(),
                ':phoneNumber' => $entity::getPhoneNumber(),
                ':gender' => $entity::getGender(),
                ':birth_date' => $entity::getBirthDate(),
                ':username' => $entity::getUsername(),
                ':email' => $entity::getEmail(),
                ':password' => $entity::getPassword(),
                ':role' => $entity::getRole(),
                ':created_at' => $entity::getCreatedAt()
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
            return false;
        }
    }
    public function delete(int $id): bool
    {
        return false;
    }
    public function update(object $entity): bool
    {
        return false;
    }
    public function selectAll(): array
    {
        return [];
    }
}

?>