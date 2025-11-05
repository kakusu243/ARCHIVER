-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 05 oct. 2025 à 18:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `archivage_bulletins`
--

-- --------------------------------------------------------

--
-- Structure de la table `archives`
--

CREATE TABLE `archives` (
  `numpiece` int(11) NOT NULL,
  `classe` varchar(50) DEFAULT NULL,
  `nompiece` varchar(255) DEFAULT NULL,
  `ideleve` int(11) DEFAULT NULL,
  `categorie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `archives`
--

INSERT INTO `archives` (`numpiece`, `classe`, `nompiece`, `ideleve`, `categorie`) VALUES
(4, '1ère', 'bulletins/Bulletin2.pdf', 5, 'Bulletins'),
(5, '1ère', 'bulletins/attestation.pdf', 4, 'Attestation'),
(6, '1ère', 'bulletins/Bulletin (1).pdf', 6, 'Bulletins');

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `idclasse` int(11) NOT NULL,
  `nomclasse` varchar(100) NOT NULL,
  `idsection` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`idclasse`, `nomclasse`, `idsection`) VALUES
(1, '5ème', 1),
(2, '1ère', 1),
(3, '2ème', 1),
(4, '2ème', 2);

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE `eleves` (
  `ideleve` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `postnom` varchar(100) DEFAULT NULL,
  `sexe` enum('M','F') DEFAULT NULL,
  `datenaissance` date DEFAULT NULL,
  `idsection` int(11) DEFAULT NULL,
  `idclasse` int(11) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eleves`
--

INSERT INTO `eleves` (`ideleve`, `nom`, `postnom`, `sexe`, `datenaissance`, `idsection`, `idclasse`, `login`, `password`, `photo`) VALUES
(3, 'Kitenge', 'Serge', 'M', '2010-01-24', 1, 2, 'kitenge54', '$2y$10$JbwAMfVeV4iqe2TNdxGCzeW/rTM5h4LC3Ku.a9yAq5KiTkcYf2gM6', 'uploads/Un homme portant une.png'),
(4, 'sifa', 'Mukunda', 'F', '2000-06-05', 5, 2, 'sifa', '$2y$10$SoOkI1dJ303K8Bg0Vv1CZesVt2YNma.hcvQmpy/Mhi98vZtWrI6me', 'uploads/eleve3.jpg'),
(5, 'Fiston', 'Mayele', 'M', '2007-04-07', 2, 3, 'fiston', '$2y$10$D.BNkGNMKP9771d.hHWJieJg1MZrj/mxkyhZ.q71PmRSKYe78YSp.', 'uploads/eleve2.jpg'),
(6, 'Danny', 'kalunga', 'M', '2009-06-10', 6, 2, 'danny', '$2y$10$MhVu/8dmortYKiI36vHSV.YWsMn5LNZky30ED5Cg06YjsfmHpdxd.', 'uploads/eleve4.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE `section` (
  `idsection` int(11) NOT NULL,
  `nomsection` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `section`
--

INSERT INTO `section` (`idsection`, `nomsection`) VALUES
(1, 'Math-physique'),
(2, 'Bio-chimie'),
(5, 'PEDA'),
(6, 'Construction');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `typeuser` enum('Préfet','Élève') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`iduser`, `login`, `password`, `typeuser`) VALUES
(2, 'kitenge54', '$2y$10$JbwAMfVeV4iqe2TNdxGCzeW/rTM5h4LC3Ku.a9yAq5KiTkcYf2gM6', 'Élève'),
(3, 'prefet@gmail.com', '$2y$10$mfaSCqESa25AovVjkFs0kenxs4cvetm6fN8y8gWisuSFupuFX/IYa', 'Préfet'),
(4, 'sifa', '$2y$10$SoOkI1dJ303K8Bg0Vv1CZesVt2YNma.hcvQmpy/Mhi98vZtWrI6me', 'Élève'),
(5, 'fiston', '$2y$10$D.BNkGNMKP9771d.hHWJieJg1MZrj/mxkyhZ.q71PmRSKYe78YSp.', 'Élève'),
(6, 'danny', '$2y$10$MhVu/8dmortYKiI36vHSV.YWsMn5LNZky30ED5Cg06YjsfmHpdxd.', 'Élève');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`numpiece`),
  ADD KEY `ideleve` (`ideleve`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`idclasse`),
  ADD KEY `idsection` (`idsection`);

--
-- Index pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`ideleve`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `idsection` (`idsection`),
  ADD KEY `idclasse` (`idclasse`);

--
-- Index pour la table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`idsection`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `archives`
--
ALTER TABLE `archives`
  MODIFY `numpiece` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `idclasse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `ideleve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `section`
--
ALTER TABLE `section`
  MODIFY `idsection` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `archives`
--
ALTER TABLE `archives`
  ADD CONSTRAINT `archives_ibfk_1` FOREIGN KEY (`ideleve`) REFERENCES `eleves` (`ideleve`);

--
-- Contraintes pour la table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`idsection`) REFERENCES `section` (`idsection`);

--
-- Contraintes pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD CONSTRAINT `eleves_ibfk_1` FOREIGN KEY (`idsection`) REFERENCES `section` (`idsection`),
  ADD CONSTRAINT `eleves_ibfk_2` FOREIGN KEY (`idclasse`) REFERENCES `classe` (`idclasse`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
