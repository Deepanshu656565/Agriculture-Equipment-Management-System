-- database.sql
DROP DATABASE IF EXISTS agri_rental;
CREATE DATABASE agri_rental CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agri_rental;

-- Users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Equipment
CREATE TABLE equipment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  type VARCHAR(100) NOT NULL,
  description TEXT,
  price_per_day DECIMAL(10,2) NOT NULL,
  status ENUM('available','unavailable') NOT NULL DEFAULT 'available',
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bookings
CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  equipment_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE
);

-- Admin user (password: admin123)
INSERT INTO users(username,email,password,role) VALUES
('Administrator','admin@example.com', '$2y$10$3o5oGibiCRdCGJg/TVFQ4uG4R9e6aU1q9A0q31Q9TnH4M3f2d0D0G', 'admin');

-- Sample equipment
INSERT INTO equipment(name,type,description,price_per_day,status,image) VALUES
('Tractor 45HP','Tractor','Reliable tractor suitable for ploughing and hauling.', 2500.00, 'available', ''),
('Seed Drill','Seeder','Precision seed drill for sowing various crops.', 900.00, 'available', ''),
('Rotavator 6ft','Tiller','Ideal for land preparation and weed control.', 1200.00, 'available', '');
