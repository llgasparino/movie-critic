-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/07/2024 às 02:25
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `movie_critic`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `filmes`
--

CREATE TABLE `filmes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` float NOT NULL,
  `movie_cover` varchar(255) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `actors` text DEFAULT NULL,
  `plot` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filmes`
--

INSERT INTO `filmes` (`id`, `user_id`, `title`, `content`, `rating`, `movie_cover`, `year`, `director`, `actors`, `plot`, `created_at`) VALUES
(8, 1, 'The Shawshank Redemption', 'gfhgh', 10, 'https://m.media-amazon.com/images/M/MV5BNDE3ODcxYzMtY2YzZC00NmNlLWJiNDMtZDViZWM2MzIxZDYwXkEyXkFqcGdeQXVyNjAwNDUxODI@._V1_SX300.jpg', '1994', 'Frank Darabont', 'Tim Robbins, Morgan Freeman, Bob Gunton', 'Over the course of several years, two convicts form a friendship, seeking consolation and, eventually, redemption through basic compassion.', '2024-07-03 19:21:28'),
(9, 1, 'Bacurau', 'Filme incrível brasileiro, sem palavras para descrever a atuação de Silvero Pereira como Lunga.', 10, 'https://m.media-amazon.com/images/M/MV5BNDIyMDcxNTItMTE3ZC00ZWNjLThjYjUtZDZkNzUxYzljMDQ0XkEyXkFqcGdeQXVyMTkzODUwNzk@._V1_SX300.jpg', '2019', 'Juliano Dornelles, Kleber Mendonça Filho', 'Bárbara Colen, Thomas Aquino, Silvero Pereira', 'After the death of her grandmother, Teresa comes home to her matriarchal village in a near-future Brazil to find a succession of sinister events that mobilizes all of its residents.', '2024-07-03 19:29:28'),
(10, 1, 'The Sixth Sense', 'Filme de suspense, muito bem feito atuado por bruce willis. \r\nDirigido por M. Night Shyamalan', 10, 'https://m.media-amazon.com/images/M/MV5BMWM4NTFhYjctNzUyNi00NGMwLTk3NTYtMDIyNTZmMzRlYmQyXkEyXkFqcGdeQXVyMTAwMzUyOTc@._V1_SX300.jpg', '1999', 'M. Night Shyamalan', 'Bruce Willis, Haley Joel Osment, Toni Collette', 'Malcolm Crowe, a child psychologist, starts treating a young boy, Cole, who encounters dead people and convinces him to help them. In turn, Cole helps Malcolm reconcile with his estranged wife.', '2024-07-03 19:31:19'),
(11, 4, 'Aquarius', 'Filme incrível dirigido por Kleber Mendonça Filho. \r\nAtuação impecável da Sonia Braga, conta a história de Clara, que mora em um apartamento antigo no qual uma companhia quer derruba-lo para criar outro edifício encima.', 10, 'https://m.media-amazon.com/images/M/MV5BNDI3NzYyMDQtY2VjOC00ZThhLWE4ZDktYjljZDI5NGViMzA4XkEyXkFqcGdeQXVyMTI3ODAyMzE2._V1_SX300.jpg', '2016', 'Kleber Mendonça Filho', 'Sonia Braga, Maeve Jinkings, Irandhir Santos', 'Clara, 65, lives her life to the fullest with her family and friends. A construction company wants her Recife oceanfront condo, as they\'ve already bought all the other in the 3 story building. Clara\'s staying.', '2024-07-03 19:34:25'),
(12, 4, 'Late Night with the Devil', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 9, 'https://m.media-amazon.com/images/M/MV5BZDkyNjE0NzMtNTgxYS00MDE4LWI0OWYtZGNmNDcxNjRhMTY3XkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_SX300.jpg', '2023', 'Cameron Cairnes, Colin Cairnes', 'David Dastmalchian, Laura Gordon, Ian Bliss', 'A live television broadcast in 1977 goes horribly wrong, unleashing evil into the nation\'s living rooms.', '2024-07-04 01:15:01'),
(14, 1, 'Kill Bill: Vol. 1', 'Filme incrível com a Umma Thurman, história muito intrigante e muito legal de se acompanhar.', 10, 'https://m.media-amazon.com/images/M/MV5BNzM3NDFhYTAtYmU5Mi00NGRmLTljYjgtMDkyODQ4MjNkMGY2XkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SX300.jpg', '2003', 'Quentin Tarantino', 'Uma Thurman, David Carradine, Daryl Hannah', 'After awakening from a four-year coma, a former assassin wreaks vengeance on the team of assassins who betrayed her.', '2024-07-08 19:53:48'),
(15, 1, 'Kill Bill: Vol. 2', 'Continuação do filme impecável que foi o Kill Bill 1.', 10, 'https://m.media-amazon.com/images/M/MV5BNmFiYmJmN2QtNWQwMi00MzliLThiOWMtZjQxNGRhZTQ1MjgyXkEyXkFqcGdeQXVyNzQ1ODk3MTQ@._V1_SX300.jpg', '2004', 'Quentin Tarantino', 'Uma Thurman, David Carradine, Michael Madsen', 'The Bride continues her quest of vengeance against her former boss and lover Bill, the reclusive bouncer Budd, and the treacherous, one-eyed Elle.', '2024-07-08 19:55:40'),
(16, 1, 'Pulp Fiction', 'Mais um filme incrível, contando uma história envolvente de crimes', 10, 'https://m.media-amazon.com/images/M/MV5BNGNhMDIzZTUtNTBlZi00MTRlLWFjM2ItYzViMjE3YzI5MjljXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SX300.jpg', '1994', 'Quentin Tarantino', 'John Travolta, Uma Thurman, Samuel L. Jackson', 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.', '2024-07-08 20:48:37'),
(17, 1, 'The Fly', 'A mosca de David Cronenberg, filme bizaramente bom.', 10, 'https://m.media-amazon.com/images/M/MV5BODcxMGMwOGEtMDUxMi00MzE5LTg4YTYtYjk1YjA4MzQxNTNlXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_SX300.jpg', '1986', 'David Cronenberg', 'Jeff Goldblum, Geena Davis, John Getz', 'A brilliant but eccentric scientist begins to transform into a giant man/fly hybrid after one of his experiments goes horribly wrong.', '2024-07-08 21:15:37'),
(18, 1, 'Videodrome', 'Filme maluco, muito interessante... e bizarro.', 9, 'https://m.media-amazon.com/images/M/MV5BNjYzNGQzMjQtZmFkZi00MDBiLWExODItNjExYjI3MTIzYzI0XkEyXkFqcGdeQXVyMTA0MTM5NjI2._V1_SX300.jpg', '1983', 'David Cronenberg', 'James Woods, Debbie Harry, Sonja Smits', 'A programmer at a Toronto TV station that specializes in adult entertainment searches for the producers of a dangerous and bizarre broadcast.', '2024-07-08 21:16:22'),
(19, 5, 'Grown Ups', 'Muito hilario klkkkk, gostei demais, si diverti muito.', 10, 'https://m.media-amazon.com/images/M/MV5BMjA0ODYwNzU5Nl5BMl5BanBnXkFtZTcwNTI1MTgxMw@@._V1_SX300.jpg', '2010', 'Dennis Dugan', 'Adam Sandler, Salma Hayek, Kevin James', 'After their high school basketball coach passes away, five good friends and former teammates reunite for a Fourth of July holiday weekend.', '2024-07-08 21:18:47'),
(24, 1, 'Ford v Ferrari', 'filmão.', 10, 'https://m.media-amazon.com/images/M/MV5BM2UwMDVmMDItM2I2Yi00NGZmLTk4ZTUtY2JjNTQ3OGQ5ZjM2XkEyXkFqcGdeQXVyMTA1OTYzOTUx._V1_SX300.jpg', '2019', 'James Mangold', 'Matt Damon, Christian Bale, Jon Bernthal', 'American car designer Carroll Shelby and driver Ken Miles battle corporate interference and the laws of physics to build a revolutionary race car for Ford in order to defeat Ferrari at the 24 Hours of Le Mans in 1966.', '2024-07-08 23:33:29');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default.jpg',
  `bio` text DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `photo`, `bio`, `is_admin`) VALUES
(1, 'luiz.gasparino', '$2y$10$GmFaKqQ5iXxLQ/jpSxaOVeg4OGXUpqDelu9HzlTZk98Q/pPhWpx9a', 'Luiz Gasparino', 'default.jpg', NULL, 1),
(2, 'futeba2@outlook.com', '$2y$10$N81R5m.4gLI3g4.LurU0ee6/7pndA1ufomO4tY5os9mA1PNwY269C', 'futeba ', 'default.jpg', NULL, 0),
(3, 'gabriel.gasparino', 'a6551ab5fd96b537e500a4a7da13ad6b', NULL, 'default.jpg', NULL, 0),
(4, 'admin', '$2y$10$NskkU3PT3ufvL7mDCKLtrech2zrf4YgE3uqc/pnqSqzI81g.N4IDy', 'admin', 'default.jpg', NULL, 1),
(5, 'usuario', '$2y$10$coEO0Ggv/BFFnOM/uceOfekETcOhHWWChT1u6ReC59ut1KR1.fyw.', 'Usuário', 'default.jpg', NULL, 0),
(6, 'usuario1', '$2y$10$wQyl/wuTPlKqDnNIBjfZCOiA0cmSaAlPsRQTISUbgmZg2SmyXABye', 'Usuário 1', 'default.jpg', NULL, 0),
(7, 'usuario43', '$2y$10$/r2Pg0m.BFHC7Mh70Jan0e4COJ9w9ISgohPIdczvfbQT3x040KNYe', 'usuario 43', 'default.jpg', NULL, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `filmes`
--
ALTER TABLE `filmes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filmes`
--
ALTER TABLE `filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `filmes`
--
ALTER TABLE `filmes`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
