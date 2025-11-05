DROP DATABASE IF EXISTS archivage_bulletins;
CREATE DATABASE archivage_bulletins;
USE archivage_bulletins;

CREATE TABLE section (
    idsection INT PRIMARY KEY AUTO_INCREMENT,
    nomsection VARCHAR(100) NOT NULL
);

CREATE TABLE classe (
    idclasse INT PRIMARY KEY AUTO_INCREMENT,
    nomclasse VARCHAR(100) NOT NULL,
    idsection INT,
    FOREIGN KEY (idsection) REFERENCES section(idsection)
);

CREATE TABLE eleves (
    ideleve INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    postnom VARCHAR(100),
    sexe ENUM('M', 'F'),
    datenaissance DATE,
    idsection INT,
    idclasse INT,
    login VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    photo VARCHAR(255),
    FOREIGN KEY (idsection) REFERENCES section(idsection),
    FOREIGN KEY (idclasse) REFERENCES classe(idclasse)
);

CREATE TABLE archives (
    numpiece INT PRIMARY KEY AUTO_INCREMENT,
    classe VARCHAR(50),
    nompiece VARCHAR(255),
    ideleve INT,
    categorie VARCHAR(50),
    FOREIGN KEY (ideleve) REFERENCES eleves(ideleve)
);

CREATE TABLE users (
    iduser INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    typeuser ENUM('Préfet', 'Élève')
);

SELECT a.numpiece, a.nompiece, a.categorie, a.classe, a.numpiece, e.nom FROM archives a JOIN eleves e ON a.ideleve = e.ideleve WHERE a.ideleve = 348055