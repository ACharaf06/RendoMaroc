-- Création de la base de données
CREATE DATABASE IF NOT EXISTS rendo_db;
USE rendo_db;

-- Création de la table `users`
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE
);

-- Création de la table `rendos`
CREATE TABLE IF NOT EXISTS rendos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    start_address VARCHAR(255),
    image_url VARCHAR(255)
);

--Création de la table 'rendo_ratings'
CREATE TABLE rendo_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rendo_id INT,
    user_id INT,
    rating INT,
    FOREIGN KEY (rendo_id) REFERENCES rendos(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);



-- Insérer quelques utilisateurs
INSERT INTO users (username) VALUES
('user1'),
('user2'),
('user3');

-- Insérer quelques randonnées
INSERT INTO rendos (name, description, popularity_score, start_address, image_url) VALUES
('Randonnée des montagnes de l\'Atlas', 'Une randonnée époustouflante à travers les montagnes de l\'Atlas, où vous pourrez découvrir des paysages incroyables et une nature préservée.', 'Imlil, Marrakech-Safi, Maroc', './photo/rendoatals.jpg'),
('Randonnée dans la vallée du paradis', 'Explorez la magnifique vallée du paradis et ses cascades pittoresques lors de cette randonnée inoubliable.', 'Aourir, Souss-Massa, Maroc', './photo/valee.jpg'),
('Randonnée dans le désert du Sahara', 'Vivez une aventure unique en traversant les dunes du Sahara et en passant la nuit sous un ciel étoilé.', 'Merzouga, Drâa-Tafilalet, Maroc', './photo/sahara.jpg');
