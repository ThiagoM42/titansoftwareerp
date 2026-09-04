<?php

namespace Model;
// use Model

use BD\Connect;
use PDO;

class User
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function authenticate(string $email, string $password)
    {
        $sql = "
            SELECT id_user, name, email, password
            FROM users
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }
        unset($user['password']);

        return $user;
    }

    public function create(
        string $name,
        string $email,
        string $password
    ): int {
        $sql = "
            INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)
        ";

        $stmt = $this->connection->prepare($sql);

        $result = $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ]);

        if (!$result) {
            throw new \Exception('Erro ao criar usuário.');
        }
        return $this->connection->lastInsertId();
    }

    public function findByEmail(string $email): array|false
    {
        $sql = "
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllEmployees(): array
    {
        $sql = "
            SELECT id_user, name, email
            FROM users
            ORDER BY name ASC
        ";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
