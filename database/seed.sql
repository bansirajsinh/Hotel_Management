-- ============================================
-- Hotel Management System
-- Seed Data
-- ============================================
-- 
-- This script inserts dummy data for testing purposes.
-- Note: All user passwords are set to "password" 
-- (bcrypt hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi)

USE `hotel_management`;

-- --------------------------------------------
-- 1. Users
-- --------------------------------------------
INSERT INTO `user_db` (`name`, `email`, `password`, `datetime`, `Last_Login`) VALUES
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Alice Johnson', 'alice@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Bob Brown', 'bob@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Charlie Davis', 'charlie@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Eva White', 'eva@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Frank Green', 'frank@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Grace Hall', 'grace@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Henry Lee', 'henry@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Ivy Scott', 'ivy@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- --------------------------------------------
-- 2. Rooms
-- --------------------------------------------
INSERT INTO `rooms_db` (`Room_name`, `room_a_size`, `room_c_size`, `room_description`, `Category`, `photo`) VALUES
('Standard Room 101', 2, 1, 'Cozy standard room with city view.', 'Standard', 'room1.jpg'),
('Standard Room 102', 2, 1, 'Standard room with twin beds.', 'Standard', 'room2.jpg'),
('Deluxe Room 201', 2, 2, 'Spacious deluxe room with balcony.', 'Deluxe', 'room3.jpg'),
('Deluxe Room 202', 2, 2, 'Deluxe room with ocean view.', 'Deluxe', 'room4.jpg'),
('Executive Suite 301', 3, 2, 'Luxury suite with living area.', 'Suite', 'room5.jpg'),
('Executive Suite 302', 3, 2, 'Executive suite with premium amenities.', 'Suite', 'room6.jpg'),
('Family Room 401', 4, 3, 'Large room perfect for families.', 'Family', 'room7.jpg'),
('Family Room 402', 4, 3, 'Connecting rooms for extended families.', 'Family', 'room8.jpg'),
('Presidential Suite', 4, 2, 'The ultimate luxury experience.', 'Premium', 'room9.jpg'),
('Honeymoon Suite', 2, 0, 'Romantic suite with jacuzzi.', 'Premium', 'room10.jpg');

-- --------------------------------------------
-- 3. Tables
-- --------------------------------------------
INSERT INTO `tables` (`Table_name`, `Table_size`) VALUES
('Table 1 - Window', 2),
('Table 2 - Window', 2),
('Table 3 - Center', 4),
('Table 4 - Center', 4),
('Table 5 - Corner', 6),
('Table 6 - Corner', 6),
('Table 7 - Patio', 4),
('Table 8 - Patio', 4),
('Table 9 - Private', 8),
('Table 10 - Grand', 12);

-- --------------------------------------------
-- 4. Banquets
-- --------------------------------------------
INSERT INTO `banquet` (`name`, `Banquet_size`, `ac-no`, `Banquet_include`, `description`, `price`, `photo`) VALUES
('Crystal Hall', 100, 'AC', 'Catering, Decor', 'Elegant crystal chandeliers.', 15000.00, 'banquet1.jpg'),
('Royal Pavilion', 200, 'AC', 'Catering, DJ, Decor', 'Spacious and royal.', 25000.00, 'banquet2.jpg'),
('Garden Terrace', 150, 'Non-AC', 'Decor, Seating', 'Beautiful outdoor setting.', 12000.00, 'banquet3.jpg'),
('Emerald Room', 50, 'AC', 'Catering', 'Perfect for small gatherings.', 8000.00, 'banquet4.jpg'),
('Sapphire Lounge', 80, 'AC', 'DJ, Decor', 'Modern lounge aesthetic.', 10000.00, 'banquet5.jpg'),
('Grand Ballroom', 300, 'AC', 'All Inclusive', 'Our largest indoor space.', 40000.00, 'banquet6.jpg'),
('Sunset Deck', 120, 'Non-AC', 'Decor', 'Rooftop with sunset view.', 15000.00, 'banquet7.jpg'),
('Orchid Room', 60, 'AC', 'Catering', 'Intimate corporate setting.', 9000.00, 'banquet8.jpg'),
('Lotus Hall', 150, 'AC', 'Decor', 'Traditional ambiance.', 18000.00, 'banquet9.jpg'),
('The Courtyard', 250, 'Non-AC', 'Catering, Decor', 'Open-air courtyard.', 22000.00, 'banquet10.jpg');

-- --------------------------------------------
-- 5. Transport
-- --------------------------------------------
INSERT INTO `transport` (`CompanyName`, `CarName`, `CarSize`, `CarPrice`, `description`, `photo`) VALUES
('City Cabs', 'Toyota Camry', 4, 1500.00, 'Comfortable sedan.', 'car1.jpg'),
('City Cabs', 'Honda City', 4, 1200.00, 'Reliable sedan.', 'car2.jpg'),
('Luxury Travels', 'Mercedes Benz E-Class', 3, 5000.00, 'Premium luxury.', 'car3.jpg'),
('Luxury Travels', 'BMW 5 Series', 3, 5000.00, 'Executive luxury.', 'car4.jpg'),
('Family Wheels', 'Toyota Innova', 7, 2500.00, 'Spacious MPV.', 'car5.jpg'),
('Family Wheels', 'Maruti Ertiga', 6, 2000.00, 'Economical MPV.', 'car6.jpg'),
('Group Tours', 'Tempo Traveller', 12, 4500.00, 'Perfect for groups.', 'car7.jpg'),
('Eco Rides', 'Tata Nexon EV', 4, 1800.00, 'Eco-friendly SUV.', 'car8.jpg'),
('Adventure Rentals', 'Mahindra Thar', 4, 3000.00, 'Off-road capability.', 'car9.jpg'),
('Airport Express', 'Hyundai Aura', 4, 1000.00, 'Quick airport drops.', 'car10.jpg');

-- --------------------------------------------
-- 6. Contact Us Messages
-- --------------------------------------------
INSERT INTO `contact_us` (`name`, `email`, `message`) VALUES
('Tom Hanks', 'tom@example.com', 'Do you offer airport pickup?'),
('Emma Watson', 'emma@example.com', 'What are the check-in timings?'),
('Chris Evans', 'chris@example.com', 'Is the swimming pool operational?'),
('Scarlett Johansson', 'scarlett@example.com', 'Can I modify my existing booking?'),
('Robert Downey Jr', 'robert@example.com', 'Do you have vegan food options?'),
('Chris Hemsworth', 'thor@example.com', 'Are pets allowed in the rooms?'),
('Mark Ruffalo', 'mark@example.com', 'I left my jacket in the lobby.'),
('Jeremy Renner', 'jeremy@example.com', 'Is parking free for guests?'),
('Paul Rudd', 'paul@example.com', 'Can I book the Royal Pavilion for a wedding?'),
('Brie Larson', 'brie@example.com', 'How far is the hotel from the train station?');
