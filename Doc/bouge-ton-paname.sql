-- Base de Donner de Bouge ton Paname

--------------------------------------------------
-- Table des User
--------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role ENUM('user', 'admin') DEFAULT 'user'
);
--------------------------------------------------
-- Table des Commentaires
--------------------------------------------------
CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    record_id VARCHAR(255) NOT NULL,
    pseudo VARCHAR(100) NOT NULL,
    commentaire TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    image_path VARCHAR(100) UNIQUE
);
--------------------------------------------------
-- Table des Évenements
--------------------------------------------------
CREATE TABLE evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    record_id VARCHAR(255) UNIQUE,
    titre VARCHAR(255),
    description TEXT,
    date_debut DATETIME,
    date_fin DATETIME,
    adresse VARCHAR(255)
    quartier VARCHAR(100),
    prix VARCHAR(100),
    accessibilite VARCHAR(10),
    cover_url VARCHAR(255),
    url VARCHAR(100)
);
--------------------------------------------------
-- Table des Messages de la page Contact
--------------------------------------------------
CREATE TABLE messages_contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);