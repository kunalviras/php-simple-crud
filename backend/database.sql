-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

-- Optional: Insert some sample data
INSERT INTO users (name, email) VALUES
('Mitesh Viras', 'mitesh@example.com'),
('Kunal Viras', 'kunal@example.com'),