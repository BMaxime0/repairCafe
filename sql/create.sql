CREATE TABLE IF NOT EXISTS avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commentaire VARCHAR(255),
    note int
);

CREATE TABLE IF NOT EXISTS reparateur (
    id int AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    mail VARCHAR(100),
    password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Compte (
    id_compte INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    sexe VARCHAR(25),
    filiere VARCHAR(50),
    mail VARCHAR(50),
    password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS reparation (
    id_repa INT AUTO_INCREMENT PRIMARY KEY,
    compte_id INT,
    appareil VARCHAR(50),
    description VARCHAR(50),
    FOREIGN KEY (compte_id) REFERENCEs compte(id_compte)
);

CREATE TABLE IF NOT EXISTS location (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compte_id INT,
    objet VARCHAR(50),
    temps VARCHAR(50),
    raison VARCHAR(255),
    FOREIGN KEY (compte_id) REFERENCEs compte(id_compte)
);