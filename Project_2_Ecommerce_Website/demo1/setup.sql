CREATE DATABASE IF NOT EXISTS ecommerce_demo1 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ecommerce_demo1;

-- Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    verified TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL
);

-- Products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id INT,
    image VARCHAR(255),
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Sample Data
INSERT IGNORE INTO users (username, email, password, role) VALUES 
('admin', 'admin@shop.com', '\\\.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('customer', 'customer@shop.com', '\\\.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

INSERT IGNORE INTO categories (name, slug) VALUES 
('Electronics','electronics'), ('Fashion','fashion'), ('Home & Kitchen','home-kitchen');

INSERT IGNORE INTO products (name, description, price, stock, category_id, featured, image) VALUES 
('Wireless Headphones', 'Premium noise cancelling headphones', 89.99, 50, 1, 1, 'headphones.jpg'),
('Smart Watch Pro', 'Fitness & health tracking', 149.99, 35, 1, 1, 'smartwatch.jpg'),
('Cotton T-Shirt', 'Soft premium cotton', 24.99, 100, 2, 0, 'tshirt.jpg'),
('Coffee Maker', '12-cup automatic coffee machine', 59.99, 20, 3, 1, 'coffeemaker.jpg');
