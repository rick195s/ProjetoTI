-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Jun-2021 às 00:11
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `devices`
--

INSERT INTO `devices` (`id`, `name`, `image`, `value`, `state`, `type`, `date`) VALUES
(1, 'Temperatura', 'public/assets/images/sensor/temperatura.png', '23', 0, 'sensor', '2021-06-13 22:07:18'),
(16, 'Porta', 'public/assets/images/atuador/porta.png', NULL, 2, 'atuador', '2021-06-13 12:05:15'),
(17, 'Humidade', 'public/assets/images/sensor/humidade.png', '0', 0, 'sensor', '2021-06-13 22:07:18'),
(21, 'Sensor_Movimento', 'public/assets/images/sensor/sensor_movimento.png', 'Sem Movimento', 0, 'sensor', '2021-06-13 22:07:18'),
(23, 'Ventoinha', 'public/assets/images/atuador/ventoinha.png', NULL, 0, 'atuador', '2021-06-13 12:05:15'),
(25, 'Armazem', 'public/assets/images/atuador/armazem.png', NULL, 2, 'atuador', '2021-06-13 12:05:15'),
(28, 'Alarme', 'public/assets/images/atuador/alarme.png', NULL, 0, 'atuador', '2021-06-13 11:49:27'),
(29, 'Detetor_de_Fogo', 'public/assets/images/sensor/fogo.png', 'Sem Fogo', 0, 'sensor', '2021-06-13 22:07:18'),
(30, 'Extintor', 'public/assets/images/atuador/extintor.png', NULL, 0, 'atuador', '2021-06-13 12:05:15'),
(31, 'Luminosidade', 'public/assets/images/sensor/luminosidade.png', '100', 0, 'sensor', '2021-06-13 22:07:18'),
(32, 'Luz', 'public/assets/images/atuador/luz.png', NULL, 2, 'atuador', '2021-06-13 12:05:15'),
(34, 'Lcd', 'public/assets/images/sensor/lcd.png', 'Fabrica', 0, 'sensor', '2021-06-13 11:51:17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `state` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privileges` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `privileges`) VALUES
(1, 'Admin', '$2y$10$Fm/OYNSVFVqfA7zP8Nj6weZ0tZh.rIX8ThbrM1VDA6EWvBJc0tlDK', 2),
(2, 'Operador', '$2y$10$OaTsbpfSJz02.vjqcIwy2OxUtDCNUB/tmbFK5COXrHroGGJIcWh3S', 1),
(5, 'Funcionario', '$2y$10$bn6fffAiLrUz8obS5Jg1nuJlje.sqZ.96T5hRpH68shcQzDXyKHEm', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11084;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
