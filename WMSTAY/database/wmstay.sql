-- WMSTAY SQL (dashboard-ready)
CREATE DATABASE IF NOT EXISTS wmstay;
USE wmstay;

-- staff (admin)
CREATE TABLE IF NOT EXISTS staff (
  staff_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  position VARCHAR(100),
  email VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- students
CREATE TABLE IF NOT EXISTS students (
  student_id INT AUTO_INCREMENT PRIMARY KEY,
  student_number VARCHAR(50) UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  email VARCHAR(255) UNIQUE,
  contact_no VARCHAR(50),
  course VARCHAR(100),
  year_level TINYINT,
  address TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- buildings & rooms
CREATE TABLE IF NOT EXISTS buildings (
  building_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  address TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS rooms (
  room_id INT AUTO_INCREMENT PRIMARY KEY,
  building_id INT,
  room_number VARCHAR(50),
  capacity TINYINT DEFAULT 1,
  room_type VARCHAR(50),
  status VARCHAR(50) DEFAULT 'available',
  description TEXT,
  FOREIGN KEY (building_id) REFERENCES buildings(building_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS room_assignments (
  assignment_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  room_id INT,
  date_assigned DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_released DATETIME NULL,
  active TINYINT(1) DEFAULT 1,
  notes TEXT,
  FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
  FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS payments (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  amount DECIMAL(12,2),
  payment_type VARCHAR(50),
  payment_status VARCHAR(50) DEFAULT 'pending',
  payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  billing_period VARCHAR(50),
  receipt_no VARCHAR(100),
  notes TEXT,
  FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS maintenance_requests (
  request_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  room_id INT,
  staff_id INT,
  request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  description TEXT,
  status VARCHAR(50) DEFAULT 'pending',
  resolved_date DATETIME NULL,
  priority TINYINT DEFAULT 3,
  FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE SET NULL,
  FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE SET NULL,
  FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- sample data
INSERT INTO buildings (name, address) VALUES ('Main Dorm', 'WMSU Campus');

INSERT INTO rooms (building_id, room_number, capacity, room_type, status) VALUES
(1, '101', 2, 'double', 'available'),
(1, '102', 1, 'single', 'available'),
(1, '103', 3, 'triple', 'available');

-- default admin (password = admin123)
INSERT INTO staff (username, password_hash, first_name, last_name, position, email) VALUES
('admin', '$2y$10$Vb8LKvQd4yClWjA5yPzM/ObK05i7ka1TfwAkLu2A1Gm79uzXU8UjW', 'System', 'Admin', 'Administrator', 'admin@wmsu.local');

-- sample student (password = admin123)
INSERT INTO students (student_number, password_hash, first_name, last_name, email, contact_no, course, year_level, address) VALUES
('WMSU2025001', '$2y$10$Vb8LKvQd4yClWjA5yPzM/ObK05i7ka1TfwAkLu2A1Gm79uzXU8UjW', 'Juan', 'Dela Cruz', 'juan@example.com', '09171234567', 'BSCS', 2, 'Zamboanga City');
