CREATE DATABASE IF NOT EXISTS used_car_trade;
USE used_car_trade;

CREATE TABLE IF NOT EXISTS sellers 
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL COMMENT 'Name',
    address VARCHAR(255) NOT NULL COMMENT 'Address',
    phone VARCHAR(20) NOT NULL UNIQUE COMMENT 'Phonenumber',
    email VARCHAR(100) NOT NULL UNIQUE COMMENT 'Email address',
    username VARCHAR(50) NOT NULL UNIQUE COMMENT 'Username',
    password VARCHAR(255) NOT NULL COMMENT 'Password',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Register Time'
);