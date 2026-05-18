CREATE DATABASE student_feedback_system1;
USE student_feedback_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL
);

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'New',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'admin'),
('Sarah Ali', 'sarah@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student'),
('Amjad Mohammed', 'amjad@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student'),
('Wafa Ahmed', 'wafa@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student'),
('Jana Omar', 'jana@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student'),
('Shahad Saleh', 'shahad@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student'),
('Mona Khaled', 'mona@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student'),
('Lama Saad', 'lama@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student'),
('Nora Fahad', 'nora@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student'),
('Huda Sami', 'huda@yic.edu.sa', '$2y$10$lMreBrqZWC3aQD57v.qe0uLptLf6mPFYQEFrkATK4fgKvlHLQZQLe', 'student');

INSERT INTO feedback (user_id, subject, message, status) VALUES
(2, 'Lab Issue', 'Computer not working', 'New'),
(3, 'Classroom', 'Too cold', 'Reviewed'),
(4, 'Schedule', 'Class time confusing', 'Resolved'),
(5, 'WiFi', 'Internet is slow', 'New'),
(6, 'Projector', 'Projector has problem', 'Reviewed'),
(7, 'Parking', 'Parking is full', 'New'),
(8, 'Library', 'Need more seats', 'Resolved'),
(9, 'Cafeteria', 'Food is expensive', 'New'),
(10, 'Course', 'Need more examples', 'Reviewed'),
(2, 'Exam', 'Exam time is short', 'New');