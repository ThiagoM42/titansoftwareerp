<?php

namespace Model;
// use Model

use PDO;

class Service
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function create(
        int $user_id_user,
        string $description,
        float $price,
        float $commission
    ): bool {
        $sql = "
            INSERT INTO services (user_id_user, description, price, commission_user)
            VALUES (:user_id_user, :description, :price, :commission_user)
        ";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([
            ':user_id_user' => $user_id_user,
            ':description' => $description,
            ':price' => $price,
            ':commission_user' => $commission
        ]);
    }

    public function getAllServices(): array
    {
        $sql = "SELECT * FROM services";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
