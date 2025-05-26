CREATE DATABASE IF NOT EXISTS rokto;
USE rokto;

CREATE TABLE IF NOT EXISTS donors (
    donor_id          INT AUTO_INCREMENT PRIMARY KEY,
    name              VARCHAR(100) NOT NULL,
    age               INT NOT NULL CHECK (age >= 18),
    email             VARCHAR(100) NOT NULL,
    phone             VARCHAR(15) NOT NULL,
    blood_type        VARCHAR(3) NOT NULL,
    area              VARCHAR(50) NOT NULL,
    last_donated_date DATE       NULL,
    status            ENUM('available', 'unavailable') DEFAULT 'available'
);

CREATE TABLE IF NOT EXISTS seekers (
    seeker_id   INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    email       VARCHAR(100) NULL,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS requests (
    request_id   INT AUTO_INCREMENT PRIMARY KEY,
    seeker_id    INT         NULL,
    blood_type   VARCHAR(3)  NOT NULL,
    area         VARCHAR(50) NOT NULL,
    request_time DATETIME    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seeker_id) REFERENCES seekers(seeker_id)
);
