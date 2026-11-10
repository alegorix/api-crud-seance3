-- Base de données pour le TP API REST
CREATE DATABASE IF NOT EXISTS shop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shop_db;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, price) VALUES 
('Clavier mécanique RGB', 89.99),
('Souris gamer sans fil', 49.90),
('Écran 27 pouces 144Hz', 229.00),
('Casque audio circum-aural', 75.50);
