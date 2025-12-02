-- Drip & Co E‑Commerce SQL Schema
CREATE DATABASE IF NOT EXISTS dripandco;
USE dripandco;

CREATE TABLE users (
    id VARCHAR(50) PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100),
    avatar_url VARCHAR(255),
    role VARCHAR(50),
    email_validated BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE credentials (
    id VARCHAR(50) PRIMARY KEY,
    password_hash VARCHAR(255) NOT NULL,
    last_login TIMESTAMP NULL,
    user_id VARCHAR(50) UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE user_addresses (
    id VARCHAR(50) PRIMARY KEY,
    full_name VARCHAR(100),
    address_line1 VARCHAR(255),
    address_line2 VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    is_default BOOLEAN DEFAULT FALSE,
    user_id VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE categories (
    id VARCHAR(50) PRIMARY KEY,
    category_name VARCHAR(100),
    description VARCHAR(255),
    category_parent_id VARCHAR(50),
    FOREIGN KEY (category_parent_id) REFERENCES categories(id)
);

CREATE TABLE products (
    id VARCHAR(50) PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    price FLOAT,
    availability INT,
    category_id VARCHAR(50),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE carts (
    id VARCHAR(50) PRIMARY KEY,
    user_id VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE cart_items (
    id VARCHAR(50) PRIMARY KEY,
    quantity INT,
    price FLOAT,
    cart_id VARCHAR(50),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    product_id VARCHAR(50),
    FOREIGN KEY (cart_id) REFERENCES carts(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE discounts (
    id VARCHAR(50) PRIMARY KEY,
    code VARCHAR(50),
    description TEXT,
    discount_type VARCHAR(50),
    value FLOAT,
    start_date TIMESTAMP,
    end_date TIMESTAMP,
    usage_limit INT
);

CREATE TABLE orders (
    id VARCHAR(50) PRIMARY KEY,
    address_id VARCHAR(50),
    user_id VARCHAR(50),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    order_status VARCHAR(50),
    total_amount FLOAT,
    discount_id VARCHAR(50),
    FOREIGN KEY (address_id) REFERENCES user_addresses(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (discount_id) REFERENCES discounts(id)
);

CREATE TABLE order_lines (
    id VARCHAR(50) PRIMARY KEY,
    order_id VARCHAR(50),
    quantity INT,
    price FLOAT,
    product_id VARCHAR(50),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE payments (
    id VARCHAR(50) PRIMARY KEY,
    order_id VARCHAR(50),
    payment_method VARCHAR(50),
    payment_time TIMESTAMP,
    payment_price DECIMAL(10,2),
    payment_status VARCHAR(50),
    transaction_id VARCHAR(100),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

CREATE TABLE reviews (
    id VARCHAR(50) PRIMARY KEY,
    user_id VARCHAR(50),
    product_id VARCHAR(50),
    rating INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
