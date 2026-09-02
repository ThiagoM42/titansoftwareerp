<?php

namespace Models;
// use Model

use BD\Connect;
use PDO;

class User
{
    private PDO $connection;

    public function __construct()
    {
        $db = new Connect();
        $this->connection = $db->connect();
    }

    public function authenticate(string $email, string $password)
    {
        $sql = "
            SELECT id, name, email, password
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

        return $user;
    }
}
