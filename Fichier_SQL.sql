-- Création de la base de données (décommentez la ligne suivante si nécessaire)
-- CREATE DATABASE Bibliothèque;

-- Utilisation de la base de données
USE OUDIHMAS;

-- Création de la table des Livres
CREATE TABLE Livres (
    LivreID INT AUTO_INCREMENT PRIMARY KEY,
    Titre VARCHAR(255) NOT NULL,
    Auteur VARCHAR(255) NOT NULL,
    Editeur VARCHAR(255),
    AnneeParution INT,
    Categorie VARCHAR(100),
    Stock INT DEFAULT 0
)ENGINE = InnoDB;

INSERT INTO Livres (Titre, Auteur, Editeur, AnneeParution, Categorie, Stock) VALUES
('Le Grand Meaulnes', 'Alain-Fournier', 'Emile-Paul Freres', 1913, 'Roman', 5),
('Madame Bovary', 'Gustave Flaubert', 'Michel Levy Freres', 1857, 'Roman', 3),
('Les Miserables', 'Victor Hugo', 'A. Lacroix, Verboeckhoven & Cie.', 1862, 'Roman', 2),
('Le Petit Prince', 'Antoine de Saint-Exupery', 'Reynal & Hitchcock', 1943, 'Roman', 10),
('Candide', 'Voltaire', 'Cramer', 1759, 'Philosophie', 4),
('L\'Etranger', 'Albert Camus', 'Gallimard', 1942, 'Roman', 5),
('Le Comte de Monte-Cristo', 'Alexandre Dumas', 'Petion', 1844, 'Roman', 3),
('La Peste', 'Albert Camus', 'Gallimard', 1947, 'Roman', 4),
('L\'Illiade', 'Homere', 'Non spécifie', -750, 'Epopee', 6),
('Crime et Chatiment', 'Fiodor Dostoievski', 'V. M. Sabline', 1866, 'Roman', 5),
('Les Fleurs du Mal', 'Charles Baudelaire', 'Poulet-Malassis et de Broise', 1857, 'Poesie', 8),
('Bel-Ami', 'Guy de Maupassant', 'Victor Havard', 1885, 'Roman', 6),
('Les Trois Mousquetaires', 'Alexandre Dumas', 'Baudry', 1844, 'Roman', 7),
('Jane Eyre', 'Charlotte Bronte', 'Smith, Elder & Co.', 1847, 'Roman', 4),
('Orgueil et Prejuges', 'Jane Austen', 'T. Egerton', 1813, 'Roman', 5),
('Don Quichotte', 'Miguel de Cervantes', 'Juan de la Cuesta', 1605, 'Roman', 4),
('Germinal', 'Emile Zola', 'Gil Blas', 1885, 'Roman', 6),
('Le Rouge et le Noir', 'Stendhal', 'Levasseur', 1830, 'Roman', 5);


-- Création de la table des Utilisateurs
CREATE TABLE Utilisateurs (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    NomUsage VARCHAR(8) NOT NULL,
    Prenom VARCHAR(255) NOT NULL,
    Nom VARCHAR(255) NOT NULL,
    DateNaissance DATE,
    Email VARCHAR(255) NOT NULL UNIQUE,
	MotDePasse VARCHAR(255) NOT NULL
)ENGINE = InnoDB;

-- Création de la table des Emprunts
CREATE TABLE Emprunts (
    EmpruntID INT AUTO_INCREMENT PRIMARY KEY,
    LivreID INT NOT NULL,
    UserID INT NOT NULL,
    DateDebut DATE NOT NULL,
    DateFin DATE NOT NULL,
    FOREIGN KEY (LivreID) REFERENCES Livres(LivreID),
    FOREIGN KEY (UserID) REFERENCES Utilisateurs(UserID)
)ENGINE = InnoDB;
