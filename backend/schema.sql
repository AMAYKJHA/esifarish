-- Sample SQL schema for your project
-- Table for users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  mobile VARCHAR(20),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255)
);

-- Table for admin users
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) ,
  name VARCHAR(100),
  email VARCHAR(100),
  phone VARCHAR(20) NOT NULL
);


CREATE TABLE complaints (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  citizen_id VARCHAR(50),
  application_id VARCHAR(50),
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE documents (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  file_name VARCHAR(255),
  file_path VARCHAR(255),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table for application submissions
CREATE TABLE applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  sifarish_type VARCHAR(50),
  full_name_np VARCHAR(100),
  full_name_en VARCHAR(100),
  dob_bs VARCHAR(20),
  dob_ad DATE,
  citizen_no VARCHAR(50),
  cit_bs VARCHAR(20),
  cit_ad DATE,
  age_group VARCHAR(20),
  district_id VARCHAR(10),
  mobile_no VARCHAR(20),
  citizenship_front VARCHAR(255),
  citizenship_back VARCHAR(255),
  status VARCHAR(20) DEFAULT 'Pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  certificate_file VARCHAR(255),
  FOREIGN KEY (user_id) REFERENCES users(id)
);


