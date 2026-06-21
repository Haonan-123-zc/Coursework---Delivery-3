CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `role` ENUM('buyer','seller') NOT NULL COMMENT 'User role: buyer/seller',
  `fullName` VARCHAR(100) NOT NULL COMMENT 'User full name',
  `address` VARCHAR(255) NOT NULL COMMENT 'User address',
  `phone` VARCHAR(11) NOT NULL UNIQUE COMMENT 'User phone number',
  `email` VARCHAR(100) NOT NULL UNIQUE COMMENT 'User email',
  `username` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Login username',
  `password` VARCHAR(255) NOT NULL COMMENT 'Encrypted login password',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Account creation time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;