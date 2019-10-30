-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30-Out-2019 às 20:42
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billy`
--
CREATE DATABASE IF NOT EXISTS `billy` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `billy`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id_perg` int(11) NOT NULL,
  `texto_perg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `perguntas`
--

INSERT INTO `perguntas` (`id_perg`, `texto_perg`) VALUES
(1, 'seu nome');

-- --------------------------------------------------------

--
-- Stand-in structure for view `perguntas_respostas`
-- (See below for the actual view)
--
CREATE TABLE `perguntas_respostas` (
`id_rela` int(11)
,`texto_perg` varchar(100)
,`texto_resp` text
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perg_resp`
--

CREATE TABLE `perg_resp` (
  `id_rela` int(11) NOT NULL,
  `fk_perg` int(11) NOT NULL,
  `fk_resp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `perg_resp`
--

INSERT INTO `perg_resp` (`id_rela`, `fk_perg`, `fk_resp`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id_resp` int(11) NOT NULL,
  `texto_resp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`id_resp`, `texto_resp`) VALUES
(1, 'Billy'),
(2, 'Me chamo Billy'),
(3, 'Pergunta a sua mãe');

-- --------------------------------------------------------

--
-- Structure for view `perguntas_respostas`
--
DROP TABLE IF EXISTS `perguntas_respostas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `perguntas_respostas`  AS  select `perg_resp`.`id_rela` AS `id_rela`,`perguntas`.`texto_perg` AS `texto_perg`,`respostas`.`texto_resp` AS `texto_resp` from ((`perg_resp` join `respostas`) join `perguntas`) where ((`perguntas`.`id_perg` = `perg_resp`.`fk_perg`) and (`respostas`.`id_resp` = `perg_resp`.`fk_resp`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`id_perg`);

--
-- Indexes for table `perg_resp`
--
ALTER TABLE `perg_resp`
  ADD PRIMARY KEY (`id_rela`),
  ADD KEY `fk_pergunta_id` (`fk_perg`),
  ADD KEY `fk_resposta_id` (`fk_resp`);

--
-- Indexes for table `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id_resp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id_perg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `perg_resp`
--
ALTER TABLE `perg_resp`
  MODIFY `id_rela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id_resp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `perg_resp`
--
ALTER TABLE `perg_resp`
  ADD CONSTRAINT `fk_pergunta_id` FOREIGN KEY (`fk_perg`) REFERENCES `perguntas` (`id_perg`),
  ADD CONSTRAINT `fk_resposta_id` FOREIGN KEY (`fk_resp`) REFERENCES `respostas` (`id_resp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
