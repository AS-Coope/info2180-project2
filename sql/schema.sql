CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;

CREATE TABLE IF NOT EXISTS Users (
   id INTEGER AUTO_INCREMENT,
   firstname VARCHAR(64),
   lastname VARCHAR(64),
   password VARCHAR(162),
   email VARCHAR(64) UNIQUE,
   role VARCHAR(64),
   created_at DATETIME,
   PRIMARY KEY(id));
   
   CREATE TABLE IF NOT EXISTS Contacts (
   id INTEGER AUTO_INCREMENT,
   title VARCHAR(64),
   firstname VARCHAR(64),
   lastname VARCHAR(64),
   email VARCHAR(64) UNIQUE,
   telephone VARCHAR(64),
   company VARCHAR(64),
   `type` VARCHAR(64),
   assigned_to INTEGER,
   created_by INTEGER,
   created_at DATETIME,
   updated_at DATETIME,
   PRIMARY KEY(id));

CREATE TABLE IF NOT EXISTS Notes (
   id INTEGER AUTO_INCREMENT,
   contact_id INTEGER,
   `comment` TEXT,
   created_by INTEGER,
   created_at DATETIME,
   PRIMARY KEY(id));
   
/* CREATE TABLE IF NOT EXISTS Na (
   na_value BLOB(512),
   email VARCHAR(64) UNIQUE,
   PRIMARY KEY(email)); */
   
   
-- Generate a random salt (you can use a proper method to generate a salt)
-- SET @salt = UNHEX(SHA2(RAND(), 512));
SET @salt = REPLACE(UUID(), '-', '') ;
SELECT @salt;

-- Hash the password using SHA-512 and the salt
--SET @hashed_password = SHA2(CONCAT('password123', HEX(@salt)), 512);
SET @hashed_password = CONCAT(@salt,';',SHA2(CONCAT(@salt,'password123'), 512));
SELECT @hashed_password;

-- Insert the salt and hashed password into your users table
INSERT INTO `Users` (`password`, `email`)
SELECT @hashed_password, 'admin@project2.com'
WHERE NOT EXISTS (SELECT * FROM `Users` WHERE `email` = 'admin@project2.com');

