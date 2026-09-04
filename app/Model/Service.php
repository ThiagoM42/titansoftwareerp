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
    {   // Join necessário para obter o nome do funcionário associado a cada serviço, usando o user_id_user como chave estrangeira.
        $sql = "SELECT services.*, users.name AS employee FROM services JOIN users ON services.user_id_user = users.id_user ORDER BY id_service DESC";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function resolveService(int $serviceId): bool
    {
        $sql = "UPDATE services SET status = 'Finalizado', finished_at = NOW() WHERE id_service = :id_service";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':id_service' => $serviceId]);
    }
}
