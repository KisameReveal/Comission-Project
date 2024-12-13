CREATE DATABASE FindHire;

USE FindHire;

-- Users Table (for both HR and Applicants)
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('HR', 'Applicant') NOT NULL
);

-- Job Posts Table
CREATE TABLE JobPosts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

-- Applications Table (Applicant applies for Jobs)
CREATE TABLE Applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT,
    applicant_id INT,
    resume_url VARCHAR(255),
    status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (job_id) REFERENCES JobPosts(id),
    FOREIGN KEY (applicant_id) REFERENCES Users(id)
);

-- Messages Table (Applicant messaging HR)
CREATE TABLE Messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES Users(id),
    FOREIGN KEY (receiver_id) REFERENCES Users(id)
);
