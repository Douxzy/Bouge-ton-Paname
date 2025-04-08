





CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    record_id VARCHAR(255) NOT NULL, -- ID de l'événement depuis l'API
    pseudo VARCHAR(100) NOT NULL,
    commentaire TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE commentaires ADD COLUMN user_id INT NOT NULL AFTER id;
ALTER TABLE evenements ADD record_id VARCHAR(255) UNIQUE;
ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') DEFAULT 'user';


CREATE TABLE IF NOT EXISTS evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    record_id VARCHAR(255) UNIQUE,
    titre VARCHAR(255),
    description TEXT,
    date_debut DATETIME,
    date_fin DATETIME,
    adresse VARCHAR(255)
);
CREATE TABLE messages_contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE evenements
  ADD quartier VARCHAR(100),
  ADD prix VARCHAR(100),
  ADD accessibilite VARCHAR(10),
  ADD cover_url VARCHAR(255),
  ADD url VARCHAR(100);
