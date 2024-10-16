CREATE DATABASE parcauto;
use parcauto

CREATE TABLE administrateur(
    compte varchar(25) unique not NULL,
    email varchar(50) unique not NULL,
    motpass varchar(25) not NULL
);

insert into  administrateur(compte,email,motpass) values('omar','omar@gmail.com','omar098');

CREATE TABLE IF NOT EXISTS user (
    idp INT PRIMARY KEY AUTO_INCREMENT,
    compte VARCHAR(20) UNIQUE NOT NULL,
    nom VARCHAR(20) NOT NULL,
    prenom VARCHAR(25) NOT NULL,
    fonction VARCHAR(25) NOT NULL,
    email VARCHAR(25) UNIQUE NOT NULL,
    adresse VARCHAR(30) NOT NULL,
    motpasse VARCHAR(25) NOT NULL,

);

CREATE TABLE IF NOT EXISTS vehicules(
    ID_vehicule INT PRIMARY KEY AUTO_INCREMENT,
    matricule VARCHAR(10) NOT NULL,
    marque VARCHAR(25) NOT NULL,
    categorie VARCHAR(25) NOT NULL,
    modele VARCHAR(25) NOT NULL,
    mise_circulation DATE NOT NULL,
    carburant VARCHAR(25) NOT NULL,
    departement VARCHAR(30) NOT NULL,
    etat VARCHAR(20) NOT NULL,
    ID_chauffeur int NOT NULL
   /* constraint fk_chauf foreign key(ID_chauffeur) references conducteur(ID_chauffeur)
*/
);
CREATE TABLE IF NOT EXISTS chauffeur(
    ID_chauffeur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(20) NOT NULL,
    prenom VARCHAR(15) NOT NULL,
    date_debut DATE NOT NULL,
    permis VARCHAR(15) UNIQUE NOT NULL,
    telephone int(10) UNIQUE NOT NULL,
    email VARCHAR(25) UNIQUE NOT NULL,
    departement VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS fournisseur(
    ID_fournisseur INT PRIMARY KEY AUTO_INCREMENT,
    nom_fournisseur VARCHAR(20) NOT NULL,
    contact INT(15) UNIQUE NOT NULL,
    email VARCHAR(30) UNIQUE NOT NULL,
    type_fourniture VARCHAR(35) NOT NULL,
    adresse varchar(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS piece(
    ID_piece INT PRIMARY KEY AUTO_INCREMENT,
    type_piece VARCHAR(30) NOT NULL,
    nom_fournisseur VARCHAR(20) NOT NULL,
    prix_unitaire INT(10) NOT NULL,
    quantite int(5) NOT NULL,
    date_livraison DATE NOT NULL,
    prix_total int(15) NOT NULL
);

CREATE TABLE IF NOT EXISTS ENTRETIEN(
    ID_entretien INT PRIMARY KEY AUTO_INCREMENT,
    matricule VARCHAR(10) NOT NULL,
    type_entretien VARCHAR(20) NOT NULL,
    detaille VARCHAR(50) NOT NULL,
    date_rappel DATE NOT NULL,
    cout int(10) NOT NULL,
    etat VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS ASSURANCE(
    ID_assurance INT PRIMARY KEY AUTO_INCREMENT,
    matricule VARCHAR(10) NOT NULL,
    fournisseur VARCHAR(20) NOT NULL,
    date_debut VARCHAR(50) NOT NULL,
    date_expiration DATE NOT NULL,
    prime int(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS MISSION(
    ID_mission INT PRIMARY KEY AUTO_INCREMENT,
    nom_chauffeur VARCHAR(20) NOT NULL,
    matricule   VARCHAR(8) NOT NULL,
    date_debut  DATE NOT NULL,
    date_fin    DATE NOT NULL,
    cout_carburant int(7) NOT NULL,
    lieu_mission VARCHAR(20) NOT NULL,
    CHECK(date_fin > date_debut)
);
