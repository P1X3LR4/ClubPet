SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `clubpet` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `clubpet`;

CREATE TABLE IF NOT EXISTS `agendamentos` (
  `agen_id` int(11) NOT NULL AUTO_INCREMENT,
  `agen_data` date NOT NULL,
  `agen_horario` time NOT NULL,
  `agen_nome_pet` varchar(50) NOT NULL,
  `agen_raca` text NOT NULL,
  `agen_sexo` text NOT NULL,
  `agen_servico` text NOT NULL,
  `agen_pagamento` text NOT NULL,
  `agen_cli_id` int(11) NOT NULL,
  `agen_upload_name` varchar(100) NOT NULL,
  `agen_upload_path` varchar(30) NOT NULL,
  `agen_creation` datetime NOT NULL,
  PRIMARY KEY (`agen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `clientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `cpf` text NOT NULL,
  `telefone` text NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(100) NOT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `funcionarios` (
  `func_id` int(11) NOT NULL AUTO_INCREMENT,
  `func_nome` varchar(80) NOT NULL,
  `func_tel` text NOT NULL,
  `func_email` varchar(100) NOT NULL,
  `func_cpf` text NOT NULL,
  `func_cargo` varchar(50) NOT NULL,
  `func_access_master` int(1) NOT NULL,
  `func_senha` varchar(100) NOT NULL,
  `func_created` datetime NOT NULL,
  PRIMARY KEY (`func_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

INSERT INTO `funcionarios` (`func_id`, `func_nome`, `func_tel`, `func_email`, `func_cpf`, `func_cargo`, `func_access_master`, `func_senha`, `func_created`) VALUES
(4, 'Admin', '(99) 99999-9999', 'admin.clubpet3@gmail.com', '084.654.141-60', 'Administrador', 0, '$2y$10$d2X1gSa2WtPxBYVwljqvW.ZBrL1HjcNjybg5zAvVchXbbMKrAB2Ty', '2022-10-28 21:03:42'),
(6, 'Lucas Alves da Silva Neto', '(93) 26225-473', 'lucas@gmail.com', '188.451.991-18', 'Banhista', 0, '$2y$10$KUV668sAUsaR.XgumnOFKe2SNkroLenuyyTYwT2UH3eSWG0F0exYm', '2022-10-29 20:58:19'),
(7, 'Daniel Carlos dos Santos', '(84) 97302-5879', 'daniel.carlos@gmail.com', '549.653.561-10', 'Tosador', 0, '$2y$10$5LJegPFkap.JKC.12wVb5O7zeHiD6lMz7/NoqXEdecYAAHyDp7XFO', '2022-10-29 21:00:16'),
(8, 'Gabriel Silva', '(82) 98346-4618', 'gabriel@gmail.com', '428.127.951-23', 'Administrador', 0, '$2y$10$Ptrrwa2W1uhuMPTepuytnOKOffIjaoF8XyuoM..ytt7JmPQPp0Ob2', '2022-10-29 21:02:12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
