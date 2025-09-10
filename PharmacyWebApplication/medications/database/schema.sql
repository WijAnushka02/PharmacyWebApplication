CREATE DATABASE pharmacy_db;
USE pharmacy_db;

-- Categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Medications
CREATE TABLE medications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    generic_name VARCHAR(100),
    category_id INT,
    description TEXT,
    image_url VARCHAR(255),
    dosage_form VARCHAR(50),
    package_size VARCHAR(50),
    price DECIMAL(10,2),
    stock_quantity INT,
    manufacturer VARCHAR(100),
    prescription_required BOOLEAN,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Cart (simple demo)
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medication_id INT,
    quantity INT,
    FOREIGN KEY (medication_id) REFERENCES medications(id)
);

-- Insert sample categories
INSERT INTO categories (name) VALUES
('Cough, Cold, Fever'),
('Allergies'),
('Nutrition'),
('Other');

-- Insert sample medications
INSERT INTO medications (name, generic_name, category_id, description, image_url, dosage_form, package_size, price, stock_quantity, manufacturer, prescription_required)
VALUES
('Panadol', 'Paracetamol', 1, 'Used to relieve fever and mild pain, including headaches, muscle aches, and fever.', 'images/panadol.jpg', 'Tablet', '10 tablets', 5.50, 100, 'GSK', FALSE),
('Benadryl', 'Diphenhydramine', 2, 'Antihistamine used to treat allergies, insomnia, and motion sickness.', 'images/benadryl.jpg', 'Syrup', '120 ml', 25.00, 50, 'Johnson & Johnson', FALSE),
('Centrum', 'Multivitamin', 3, 'Complete multivitamin and mineral supplement.', 'images/centrum.jpg', 'Tablet', '30 tablets', 35.75, 75, 'Pfizer', FALSE),
('Amoxicillin', 'Amoxicillin', 4, 'Antibiotic used to treat a wide range of bacterial infections.', 'images/amoxicillin.jpg', 'Capsule', '15 capsules', 60.00, 30, 'Various', TRUE),
('Cetirizine', 'Cetirizine', 2, 'Used for relief of allergy symptoms such as runny nose and sneezing.', 'images/cetirizine.jpg', 'Tablet', '10 tablets', 15.00, 80, 'Various', FALSE),
('Ibuprofen', 'Ibuprofen', 1, 'A nonsteroidal anti-inflammatory drug (NSAID) used for pain and inflammation.', 'images/ibuprofen.jpg', 'Tablet', '20 tablets', 10.25, 90, 'Various', FALSE);