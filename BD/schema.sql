CREATE DATABASE IF NOT EXISTS titan_os_db
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE titan_os_db;

DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `users`;

-- Tabela de usuários --
CREATE TABLE `users` (
    `id_user` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `ativo` TINYINT(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`id_user`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de serviços --
CREATE TABLE `services` (
    `id_service` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `description` TEXT,
    `price` DECIMAL(11, 3) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `finished_at` datetime NULL DEFAULT NULL,
    `commission_user` DECIMAL(11, 3) NOT NULL,
    `user_id_user` BIGINT(20) NOT NULL,
    -- Por padrão já define o status como pendente, pois quando o serviço é criado, ele ainda não foi iniciado.
    `status` ENUM('Pendente', 'Finalizado') NOT NULL DEFAULT 'Pendente',
    PRIMARY KEY (`id_service`),
    FOREIGN KEY (`user_id_user`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
