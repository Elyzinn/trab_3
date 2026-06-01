-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/06/2026 às 00:08
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `filmes_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `filmes`
--

CREATE TABLE `filmes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `diretor` varchar(255) NOT NULL,
  `data_lancamento` date NOT NULL,
  `nota` decimal(3,1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filmes`
--

INSERT INTO `filmes` (`id`, `nome`, `diretor`, `data_lancamento`, `nota`, `created_at`, `updated_at`) VALUES
(1, 'O Poderoso Chefão (1972)', 'Francis Ford Coppola', '1972-03-24', 9.2, '2026-05-26 00:01:45', '2026-05-26 00:01:47'),
(2, 'Interestelar', 'Christopher Nolan', '2014-11-06', 8.6, '2026-05-26 00:01:45', '2026-05-26 00:01:45'),
(3, 'Parasita', 'Bong Joon-ho', '2019-05-30', 8.5, '2026-05-26 00:01:45', '2026-05-26 00:14:07'),
(6, 'Planeta dos Macacos: A Origem', 'Rupert Wyatt', '2011-01-01', 10.0, '2026-05-26 00:16:22', '2026-05-26 00:16:22'),
(7, 'A Lista de Schindler', 'Steven Spielberg', '1993-12-15', 9.1, '2026-06-01 22:07:41', '2026-06-01 22:07:41');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `filmes`
--
ALTER TABLE `filmes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filmes`
--
ALTER TABLE `filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
