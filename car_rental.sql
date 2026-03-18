-- Car Rental Database Schema

CREATE DATABASE IF NOT EXISTS car_rental;
USE car_rental;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'agency') NOT NULL
);

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agency_id INT NOT NULL,
    model VARCHAR(255) NOT NULL,
    vehicle_number VARCHAR(255) UNIQUE NOT NULL,
    seating_capacity INT NOT NULL,
    rent_per_day DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (agency_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    customer_id INT NOT NULL,
    start_date DATE NOT NULL,
    days INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample users for testing.
-- Password for both sample users: password123
INSERT INTO users (id, name, email, password, role) VALUES
    (1, 'City Ride Rentals', 'agency@example.com', '$2y$10$pW6y37b4nBK.wFeTS2GrtOIAk2Q6MXStpuTtO85mbkZGxOZs/gCNi', 'agency'),
    (2, 'Sample Customer', 'customer@example.com', '$2y$10$pW6y37b4nBK.wFeTS2GrtOIAk2Q6MXStpuTtO85mbkZGxOZs/gCNi', 'customer');

-- Sample car data for the sample agency account above.
INSERT INTO cars (agency_id, model, vehicle_number, seating_capacity, rent_per_day) VALUES
    (1, 'Hyundai Creta', 'TS 09 AB 1234', 5, 45.00),
    (1, 'Toyota Innova Crysta', 'TS 09 CD 5678', 7, 70.00),
    (1, 'Mahindra XUV700', 'TS 09 EF 2468', 7, 68.00),
    (1, 'Tata Nexon', 'TS 09 GH 1357', 5, 40.00),
    (1, 'Honda City', 'TS 09 IJ 9087', 5, 50.00);
