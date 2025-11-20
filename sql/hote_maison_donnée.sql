-- Création de la base de données
CREATE DATABASE IF NOT EXISTS hote_maison_donnee CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE hote_maison_donnee;

-- Table des mots de passe
CREATE TABLE IF NOT EXISTS MOT_DE_PASSE (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mot_de_passe_hash TEXT NOT NULL
);
-- Exemple : insérer un mot de passe hashé (bcrypt)
INSERT INTO MOT_DE_PASSE (mot_de_passe_hash)
-- Lh0tema!son2025
VALUES ('$2y$10$fr2MpKO3V3dES5I4.xRiVeyqNa59waMR1b4gXnYJqoM88Fa8aaXzu');

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs_hote_maison (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Infos personnelles
    prenom_hash TEXT NOT NULL,
    nom_hash TEXT NOT NULL,
    date_naissance_hash TEXT NOT NULL,
    prenom_naissance_hash TEXT NOT NULL,
    pronoms VARCHAR(50) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    adresse_hash TEXT NOT NULL,
    ville_hash TEXT NOT NULL,
    code_postal_hash TEXT NOT NULL,
    adresse2_hash TEXT,
    ville2_hash TEXT,
    code_postal2_hash TEXT,

    -- Contact d'urgence 1
    contact1_nom_hash TEXT NOT NULL,
    contact1_lien VARCHAR(100) NOT NULL,
    contact1_tel_hash TEXT NOT NULL,
    contact1_autre_tel_hash TEXT,

    -- Contact d'urgence 2
    contact2_nom_hash TEXT,
    contact2_lien VARCHAR(100),
    contact2_tel_hash TEXT,
    contact2_autre_tel_hash TEXT,

    -- Santé et contact
    sante TEXT,
    numero_rejoindre_hash TEXT NOT NULL,
    moyen_contact VARCHAR(255) NOT NULL,
    pseudos VARCHAR(255),

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
