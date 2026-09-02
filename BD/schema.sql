CREATE DATABASE IF NOT EXISTS titan_os_db
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE titan_os_db;

DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `services`;

-- Tabela de usuários --
CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de serviços --
CREATE TABLE `services` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `status` ENUM('Pendente', 'Finalizado') NOT NULL DEFAULT 'Pendente',
    `user_id` INT NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `service_started` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `service_finished` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
