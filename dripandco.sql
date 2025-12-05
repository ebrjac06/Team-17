-- Drip & Co Merged SQL Schema
-- Combines registration functionality with full e-commerce features

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create database
CREATE DATABASE IF NOT EXISTS dripandco;
USE dripandco;

-- ============================================
-- USERS TABLE (from first SQL, enhanced)
-- ============================================
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  full_name VARCHAR(128) NOT NULL,
  dob DATE DEFAULT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(20) DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) DEFAULT 'customer',
  avatar_url VARCHAR(255) DEFAULT NULL,
  email_validated BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert test users from first SQL
INSERT INTO users (id, first_name, last_name, full_name, email, password) VALUES
(2, '', '', 'user1', 'user1@gmail.com', '$2y$10$.QcMIgxGIdJhSrRVZFzCjO7wZ8Vslgm7Fb3RHm8G29K39QlGMW3ze'),
(3, '', '', 'usertwo usertwo', 'user2@gmail.com', '$2y$10$US4/WS1FLgXT9MMxp8T9AeNS8m9Xz7/ApYrzyhmoPPL2K9OU892yK'),
(4, 'userthree', 'userthree', 'userthree userthree', 'user3@gmail.com', '$2y$10$sYsg2gO8MwI8/a7EpO22MuraSWXRt.74b6AUfR8uUzurqk52zEfgS'),
(5, 'userfour', 'userfour', 'userfour userfour', 'user4@gmail.com', '$2y$10$mxAcn8qV4/uYzUSosqWczeTy9UVWisu.rgUrNYbbvTO3vwFjFUide'),
(6, 'userfive', 'userfive', 'userfive userfive', 'user5@gmail.com', '$2y$10$dsfLZ4XU3BiTJda/tCRDKuDjgzAifo5afTwfy74779NMZGVjkltom');

-- ============================================
-- USER ADDRESSES
-- ============================================
CREATE TABLE user_addresses (
    id INT(11) NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(100),
    address_line1 VARCHAR(255),
    address_line2 VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    is_default BOOLEAN DEFAULT FALSE,
    user_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- CATEGORIES
-- ============================================
CREATE TABLE categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(100),
    description VARCHAR(255),
    category_parent_id INT(11) DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (category_parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- PRODUCTS
-- ============================================
CREATE TABLE products (
    id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255),
    description TEXT,
    price FLOAT,
    availability INT,
    category_id INT(11),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- CARTS
-- ============================================
CREATE TABLE carts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- CART ITEMS
-- ============================================
CREATE TABLE cart_items (
    id INT(11) NOT NULL AUTO_INCREMENT,
    quantity INT,
    price FLOAT,
    cart_id INT(11),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    product_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- DISCOUNTS
-- ============================================
CREATE TABLE discounts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    code VARCHAR(50),
    description TEXT,
    discount_type VARCHAR(50),
    value FLOAT,
    start_date TIMESTAMP,
    end_date TIMESTAMP,
    usage_limit INT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- ORDERS
-- ============================================
CREATE TABLE orders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    address_id INT(11),
    user_id INT(11),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    order_status VARCHAR(50),
    total_amount FLOAT,
    discount_id INT(11) DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (address_id) REFERENCES user_addresses(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (discount_id) REFERENCES discounts(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- ORDER LINES
-- ============================================
CREATE TABLE order_lines (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11),
    quantity INT,
    price FLOAT,
    product_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- PAYMENTS
-- ============================================
CREATE TABLE payments (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11),
    payment_method VARCHAR(50),
    payment_time TIMESTAMP,
    payment_price DECIMAL(10,2),
    payment_status VARCHAR(50),
    transaction_id VARCHAR(100),
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- REVIEWS
-- ============================================
CREATE TABLE reviews (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11),
    product_id INT(11),
    rating INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- CONTACT FORM
-- ============================================
CREATE TABLE contact_form (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100),
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Set AUTO_INCREMENT for users table to continue from test data
ALTER TABLE users MODIFY id INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
