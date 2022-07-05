-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Jul-2022 às 13:27
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projectmusic`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `album`
--

CREATE TABLE `album` (
  `id_al` int(11) NOT NULL,
  `nome_al` varchar(200) NOT NULL,
  `ano_al` int(11) NOT NULL,
  `artista_id_a` int(11) NOT NULL,
  `image_al` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `album`
--

INSERT INTO `album` (`id_al`, `nome_al`, `ano_al`, `artista_id_a`, `image_al`) VALUES
(1, 'Rumination', 2022, 1, ''),
(2, 'Fallen', 2003, 2, ''),
(3, 'Phobia', 2006, 3, ''),
(4, 'POST HUMAN: SURVIVAL HORROR', 2020, 4, ''),
(5, 'Stand Up And Scream', 2009, 5, ''),
(6, 'Death Inside - Single', 2021, 6, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `album_has_generos`
--

CREATE TABLE `album_has_generos` (
  `album_id_al` int(11) NOT NULL,
  `generos_id_g` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `artista`
--

CREATE TABLE `artista` (
  `id_a` int(11) NOT NULL,
  `nome_a` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `artista`
--

INSERT INTO `artista` (`id_a`, `nome_a`) VALUES
(1, 'The Dead Rabbitts'),
(2, 'Evanescence'),
(3, 'Breaking Benjamin'),
(4, 'Bring Me The Horizon'),
(5, 'Asking Alexandria'),
(6, 'Memphis May Fire'),
(7, 'Mizo Mabbitt'),
(8, 'Chloe Ozwell'),
(9, 'Ronnie Winter'),
(10, 'YUNGBLUD'),
(11, 'BABYMETAL'),
(12, 'Nova Twins'),
(13, 'Amy Lee');

-- --------------------------------------------------------

--
-- Estrutura da tabela `generos`
--

CREATE TABLE `generos` (
  `id_g` int(11) NOT NULL,
  `nome_g` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `generos`
--

INSERT INTO `generos` (`id_g`, `nome_g`) VALUES
(1, 'Rock'),
(2, 'Metal'),
(3, 'Post-Hardcore'),
(4, 'Melodic Metal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `musica`
--

CREATE TABLE `musica` (
  `id_m` int(11) NOT NULL,
  `titulo_m` varchar(200) NOT NULL,
  `album_id_al` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `musica`
--

INSERT INTO `musica` (`id_m`, `titulo_m`, `album_id_al`) VALUES
(1, 'Raisehell.exe', 1),
(2, 'Dead By Daylight', 1),
(3, 'Escaping The Fate', 1),
(4, 'Product To Blame', 1),
(5, 'Echo', 1),
(6, 'Options', 1),
(7, 'In Your Dreams', 1),
(8, 'Rumination', 1),
(9, 'Acceptance', 1),
(10, 'Nail In The Casket', 1),
(11, 'Halo', 1),
(12, 'Prize Pig', 1),
(13, 'The Edge', 1),
(14, 'Going Under', 2),
(15, 'Bring Me to Life', 2),
(16, 'Everybody\'s Fool', 2),
(17, 'My Immortal', 2),
(18, 'Haunted', 2),
(19, 'Tourniquet', 2),
(20, 'Imaginary', 2),
(21, 'Taking Over Me', 2),
(22, 'Hello', 2),
(23, 'My Last Breath', 2),
(24, 'Whisper', 2),
(25, 'Intro', 3),
(26, 'The Diary Of Jane', 3),
(27, 'Breath', 3),
(28, 'You', 3),
(29, 'Evil Angel', 3),
(30, 'Until The End', 3),
(31, 'Dance With The Devil', 3),
(32, 'Topless', 3),
(33, 'Here We Are', 3),
(34, 'Unknown Soldier', 3),
(35, 'Had Enough', 3),
(36, 'You Fight Me', 3),
(37, 'Outro', 3),
(38, 'Dear Diary,', 4),
(39, 'Parasite Eve', 4),
(40, 'Teardrops', 4),
(41, 'Obey', 4),
(42, 'Itch For The Cure', 4),
(43, 'Kingslayer', 4),
(44, '1x1', 4),
(45, 'Ludens', 4),
(46, 'One Day The Only Butterflies Left Will Be In Your Chest As You March Towards Your Death', 4),
(47, 'Alerion', 5),
(48, 'Final Episode', 5),
(49, 'A Candlelit Dinner With Inamorta', 5),
(50, 'Nobody Don\'t Dance No More', 5),
(51, 'Hey There Mr. Brooks', 5),
(52, 'Hiatus', 5),
(53, 'If You Can\'t Ride Two Horses at Once.. You Should Get Out Of The Circus', 5),
(54, 'A Single Moment Of Sincerity', 5),
(55, 'Not The American Average', 5),
(56, 'I Used To Have a Best Friend', 5),
(57, 'A Prophecy', 5),
(58, 'I Was Once, Possibily, Maybe, Perhaps a Cowboy King', 5),
(59, 'When Everyday\'s The Weekend', 5),
(60, 'Death Inside', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `musica_has_artista`
--

CREATE TABLE `musica_has_artista` (
  `musica_id_m` int(11) NOT NULL,
  `artista_id_a` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `musica_has_artista`
--

INSERT INTO `musica_has_artista` (`musica_id_m`, `artista_id_a`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(6, 8),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(13, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `musica_has_generos`
--

CREATE TABLE `musica_has_generos` (
  `musica_id_m` int(11) NOT NULL,
  `generos_id_g` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id_u` int(11) NOT NULL,
  `nome_u` varchar(45) NOT NULL,
  `pass_u` varchar(999) NOT NULL,
  `nivel_u` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id_al`,`artista_id_a`),
  ADD KEY `fk_album_artista1_idx` (`artista_id_a`);

--
-- Índices para tabela `album_has_generos`
--
ALTER TABLE `album_has_generos`
  ADD PRIMARY KEY (`album_id_al`,`generos_id_g`),
  ADD KEY `fk_album_has_generos_generos1_idx` (`generos_id_g`),
  ADD KEY `fk_album_has_generos_album1_idx` (`album_id_al`);

--
-- Índices para tabela `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`id_a`);

--
-- Índices para tabela `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id_g`);

--
-- Índices para tabela `musica`
--
ALTER TABLE `musica`
  ADD PRIMARY KEY (`id_m`),
  ADD KEY `fk_musica_album1_idx` (`album_id_al`);

--
-- Índices para tabela `musica_has_artista`
--
ALTER TABLE `musica_has_artista`
  ADD PRIMARY KEY (`musica_id_m`,`artista_id_a`),
  ADD KEY `fk_musica_has_artista_artista1_idx` (`artista_id_a`),
  ADD KEY `fk_musica_has_artista_musica1_idx` (`musica_id_m`);

--
-- Índices para tabela `musica_has_generos`
--
ALTER TABLE `musica_has_generos`
  ADD PRIMARY KEY (`musica_id_m`,`generos_id_g`),
  ADD KEY `fk_musica_has_generos_generos1_idx` (`generos_id_g`),
  ADD KEY `fk_musica_has_generos_musica1_idx` (`musica_id_m`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_u`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `album`
--
ALTER TABLE `album`
  MODIFY `id_al` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `artista`
--
ALTER TABLE `artista`
  MODIFY `id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `generos`
--
ALTER TABLE `generos`
  MODIFY `id_g` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `musica`
--
ALTER TABLE `musica`
  MODIFY `id_m` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `fk_album_artista1` FOREIGN KEY (`artista_id_a`) REFERENCES `artista` (`id_a`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `album_has_generos`
--
ALTER TABLE `album_has_generos`
  ADD CONSTRAINT `fk_album_has_generos_album1` FOREIGN KEY (`album_id_al`) REFERENCES `album` (`id_al`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_album_has_generos_generos1` FOREIGN KEY (`generos_id_g`) REFERENCES `generos` (`id_g`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `musica`
--
ALTER TABLE `musica`
  ADD CONSTRAINT `fk_musica_album1` FOREIGN KEY (`album_id_al`) REFERENCES `album` (`id_al`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `musica_has_artista`
--
ALTER TABLE `musica_has_artista`
  ADD CONSTRAINT `fk_musica_has_artista_artista1` FOREIGN KEY (`artista_id_a`) REFERENCES `artista` (`id_a`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_musica_has_artista_musica1` FOREIGN KEY (`musica_id_m`) REFERENCES `musica` (`id_m`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `musica_has_generos`
--
ALTER TABLE `musica_has_generos`
  ADD CONSTRAINT `fk_musica_has_generos_generos1` FOREIGN KEY (`generos_id_g`) REFERENCES `generos` (`id_g`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_musica_has_generos_musica1` FOREIGN KEY (`musica_id_m`) REFERENCES `musica` (`id_m`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
