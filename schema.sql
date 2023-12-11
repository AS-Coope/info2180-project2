DROP DATABASE IF EXISTS dolphin_crm;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Contacts;
DROP TABLE IF EXISTS Notes;
CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;

-- Users Table
CREATE TABLE IF NOT EXISTS Users (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    password VARCHAR(255),
    email VARCHAR(255),
    role VARCHAR(255),
    created_at DATETIME
);

-- Contacts Table
CREATE TABLE IF NOT EXISTS Contacts (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255),
    telephone VARCHAR(255),
    company VARCHAR(255),
    type VARCHAR(255),
    assigned_to INTEGER,
    created_by INTEGER,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

-- Notes Table
CREATE TABLE IF NOT EXISTS Notes (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    contact_id INTEGER,
    comment TEXT,
    created_by INTEGER,
    created_at DATETIME,
    FOREIGN KEY (contact_id) REFERENCES Contacts(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

INSERT INTO Users (firstname, lastname, password, email, role, created_at)
VALUES ('Admin', 'User', '$2y$10$SfRQpUd4TUjN.E6zvcFWcew0km8Xg/XJC.hElK3IZ9CAX6NOj1avu', 'admin@project2.com', 'Admin', NOW());