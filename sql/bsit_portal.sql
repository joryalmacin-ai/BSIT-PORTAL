CREATE DATABASE bsit_portal;
USE bsit_portal;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date_posted DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Sample Admin
INSERT INTO admin (username, password) VALUES ('admin', 'admin123');
