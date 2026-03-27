CREATE DATABASE IF NOT EXISTS simple_blog_demo5 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE simple_blog_demo5;

DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS post_categories;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    verified TINYINT(1) DEFAULT 1,
    verification_token VARCHAR(255) NULL,
    reset_token VARCHAR(255) NULL,
    reset_expires DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    featured_image VARCHAR(255) NULL,
    user_id INT NOT NULL,
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE post_categories (
    post_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    parent_id INT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'approved',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Example data for testing (password = "password" for all accounts)
INSERT INTO users (username, email, password, role, verified) VALUES 
('admin', 'admin@example.com', '\\\.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1),
('user1', 'user1@example.com', '\\\.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 1);

INSERT INTO categories (name, slug) VALUES 
('Technology', 'technology'),
('Lifestyle', 'lifestyle'),
('Travel', 'travel');

INSERT INTO posts (title, content, featured_image, user_id, status) VALUES 
('Welcome to Simple Blog System', '<p>This is a fully functional demo post with rich text support via TinyMCE.</p><p>You can edit, delete, comment, and manage everything in the admin panel.</p>', 'uploads/sample-post1.jpg', 1, 'published'),
('PHP MVC Best Practices', '<h3>Model-View-Controller in action</h3><p>This project uses OOP, prepared statements, CSRF protection, and more.</p>', 'uploads/sample-post2.jpg', 1, 'published');

INSERT INTO post_categories (post_id, category_id) VALUES (1,1), (1,2), (2,1);

INSERT INTO comments (post_id, user_id, content, status) VALUES 
(1, 2, 'This is a great demo! Love the rich text editor.', 'approved'),
(1, 1, 'Thank you! Feel free to reply or create your own posts.', 'approved');

-- Sample image placeholders will be handled by upload logic
