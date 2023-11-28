import os
import bcrypt

schema_sql = """
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
"""
password = b"password123"

# Generate a salt
salt = bcrypt.gensalt()

# Generate a hashed password
hashed_password = bcrypt.hashpw(password, salt)

hashed_password_utf8 = hashed_password.decode('utf-8')


# Write the INSERT statement
insert_sql = f"""
INSERT INTO Users (firstname, lastname, password, email, role, created_at)
VALUES ('Admin', 'User', '{hashed_password_utf8}', 'admin@project2.com', 'admin', NOW());
"""

# Combine the schema and insert statements
complete_sql = schema_sql + "\n" + insert_sql

# Get the directory of the current script
script_dir = os.path.dirname(os.path.abspath(__file__))

# Define the file path
schema_file_path = os.path.join(script_dir, 'schema.sql')

# Save the SQL to a file
with open(schema_file_path, 'w') as file:
    file.write(complete_sql)
