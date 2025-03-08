-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2025 at 11:46 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_kina`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `filmy`
--

CREATE TABLE `filmy` (
  `film_id` int(11) NOT NULL,
  `tytul` varchar(100) NOT NULL,
  `czas_trwania` int(11) NOT NULL,
  `gatunek` varchar(50) DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `data_premiery` date DEFAULT NULL,
  `ograniczenie_wiekowe` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `filmy`
--

INSERT INTO `filmy` (`film_id`, `tytul`, `czas_trwania`, `gatunek`, `opis`, `data_premiery`, `ograniczenie_wiekowe`) VALUES
(1, 'Avatar 2', 192, 'Sci-Fi', 'Kontynuacja przygód na Pandorze...', '2022-12-16', 'PG-13'),
(2, 'Incepcja', 148, 'Sci-Fi/Thriller', 'Dom Cobb jest mistrzem w sztuce ekstrakcji - wykradania wartościowych sekretów z głębin podświadomości podczas fazy snu.', '2010-07-16', 'PG-13'),
(3, 'Władca Pierścieni: Powrót Króla', 201, 'Fantasy', 'Ostateczna bitwa o Śródziemie się rozpoczyna. Frodo i Sam zmierzają do Góry Przeznaczenia.', '2003-12-17', 'PG-13'),
(4, 'Pulp Fiction', 154, 'Kryminał/Dramat', 'Przemoc i odkupienie w Los Angeles. Połączone historie boksera, gangsterów i ich żon.', '1994-10-14', 'R'),
(5, 'Matrix', 136, 'Sci-Fi/Akcja', 'Haker Neo odkrywa, że rzeczywistość jest symulacją, a ludzkość jest uwięziona przez sztuczną inteligencję.', '1999-03-31', 'R'),
(6, 'Interstellar', 169, 'Sci-Fi/Dramat', 'Grupa astronautów podróżuje przez tunel czasoprzestrzenny w poszukiwaniu nowego domu dla ludzkości.', '2014-11-07', 'PG-13'),
(7, 'Joker', 122, 'Dramat/Thriller', 'Historia pochodzenia jednego z najbardziej znanych złoczyńców komiksowych.', '2019-10-04', 'R'),
(8, 'Top Gun: Maverick', 130, 'Akcja/Dramat', 'Po 30 latach służby, Pete Mitchell szkoli nowe pokolenie pilotów marynarki wojennej.', '2022-05-27', 'PG-13'),
(9, 'Diuna', 155, 'Sci-Fi/Przygodowy', 'Adaptacja kultowej powieści sci-fi o młodym księciu, który musi przetrwać na najniebezpieczniejszej planecie we wszechświecie.', '2021-10-22', 'PG-13'),
(10, 'Spider-Man: Poprzez multiwersum', 140, 'Animacja/Akcja', 'Miles Morales powraca w nowej przygodzie przez multiwersum, spotykając innych Spider-Manów.', '2023-06-02', 'PG'),
(11, 'Oppenheimer', 180, 'Dramat/Biograficzny', 'Historia J. Roberta Oppenheimera, twórcy bomby atomowej. Film ukazuje jego rolę w projekcie Manhattan podczas II wojny światowej oraz późniejsze zmagania moralne.', '2023-07-21', 'R'),
(12, 'Barbie', 114, 'Komedia/Przygodowy', 'Barbie mieszkająca w idealnym świecie Barbieland wyrusza w podróż do prawdziwego świata. Odkrywając uroki i wyzwania życia wśród ludzi, Barbie i Ken doświadczają niezwykłej przygody.', '2023-07-21', 'PG-13');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `klient_id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(15) DEFAULT NULL,
  `data_rejestracji` datetime DEFAULT current_timestamp(),
  `haslo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klienci`
--

INSERT INTO `klienci` (`klient_id`, `imie`, `nazwisko`, `email`, `telefon`, `data_rejestracji`, `haslo`) VALUES
(9, 'Jan', 'Brzechwa', 'jdciwpape@wp.pl', '923923929', '2025-03-08 21:10:34', '$2y$10$0bipkm.zc5AZAkJBkNqbjuCpeyoe5sBZy9mfRsOV8U2epJVHTgz0a'),
(10, 'Jan', 'Kowalski', 'johhnygraham497@gmail.com', '923923923', '2025-03-08 22:05:39', '$2y$10$p7vDSxIdWELH8aXZkTWRNO7RKaet0HQ6gSrTs4OS5g1t7OyxqnRIu');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `miejsca`
--

CREATE TABLE `miejsca` (
  `miejsce_id` int(11) NOT NULL,
  `sala_id` int(11) DEFAULT NULL,
  `numer_rzedu` int(11) NOT NULL,
  `numer_miejsca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `miejsca`
--

INSERT INTO `miejsca` (`miejsce_id`, `sala_id`, `numer_rzedu`, `numer_miejsca`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 1, 3),
(4, 1, 1, 4),
(5, 1, 1, 5),
(6, 1, 1, 6),
(7, 1, 1, 7),
(8, 1, 1, 8),
(9, 1, 2, 1),
(10, 1, 2, 2),
(11, 1, 2, 3),
(12, 1, 2, 4),
(13, 1, 2, 5),
(14, 1, 2, 6),
(15, 1, 2, 7),
(16, 1, 2, 8),
(17, 1, 3, 1),
(18, 1, 3, 2),
(19, 1, 3, 3),
(20, 1, 3, 4),
(21, 1, 3, 5),
(22, 1, 3, 6),
(23, 1, 3, 7),
(24, 1, 3, 8),
(25, 1, 4, 1),
(26, 1, 4, 2),
(27, 1, 4, 3),
(28, 1, 4, 4),
(29, 1, 4, 5),
(30, 1, 4, 6),
(31, 1, 4, 7),
(32, 1, 4, 8),
(33, 1, 5, 1),
(34, 1, 5, 2),
(35, 1, 5, 3),
(36, 1, 5, 4),
(37, 1, 5, 5),
(38, 1, 5, 6),
(39, 1, 5, 7),
(40, 1, 5, 8),
(41, 2, 1, 1),
(42, 2, 1, 2),
(43, 2, 1, 3),
(44, 2, 1, 4),
(45, 2, 1, 5),
(46, 2, 1, 6),
(47, 2, 1, 7),
(48, 2, 1, 8),
(49, 2, 1, 9),
(50, 2, 1, 10),
(51, 2, 2, 1),
(52, 2, 2, 2),
(53, 2, 2, 3),
(54, 2, 2, 4),
(55, 2, 2, 5),
(56, 2, 2, 6),
(57, 2, 2, 7),
(58, 2, 2, 8),
(59, 2, 2, 9),
(60, 2, 2, 10),
(61, 2, 3, 1),
(62, 2, 3, 2),
(63, 2, 3, 3),
(64, 2, 3, 4),
(65, 2, 3, 5),
(66, 2, 3, 6),
(67, 2, 3, 7),
(68, 2, 3, 8),
(69, 2, 3, 9),
(70, 2, 3, 10),
(71, 2, 4, 1),
(72, 2, 4, 2),
(73, 2, 4, 3),
(74, 2, 4, 4),
(75, 2, 4, 5),
(76, 2, 4, 6),
(77, 2, 4, 7),
(78, 2, 4, 8),
(79, 2, 4, 9),
(80, 2, 4, 10),
(81, 2, 5, 1),
(82, 2, 5, 2),
(83, 2, 5, 3),
(84, 2, 5, 4),
(85, 2, 5, 5),
(86, 2, 5, 6),
(87, 2, 5, 7),
(88, 2, 5, 8),
(89, 2, 5, 9),
(90, 2, 5, 10),
(91, 3, 1, 1),
(92, 3, 1, 2),
(93, 3, 1, 3),
(94, 3, 1, 4),
(95, 3, 1, 5),
(96, 3, 1, 6),
(97, 3, 1, 7),
(98, 3, 1, 8),
(99, 3, 1, 9),
(100, 3, 1, 10),
(101, 3, 2, 1),
(102, 3, 2, 2),
(103, 3, 2, 3),
(104, 3, 2, 4),
(105, 3, 2, 5),
(106, 3, 2, 6),
(107, 3, 2, 7),
(108, 3, 2, 8),
(109, 3, 2, 9),
(110, 3, 2, 10),
(111, 3, 3, 1),
(112, 3, 3, 2),
(113, 3, 3, 3),
(114, 3, 3, 4),
(115, 3, 3, 5),
(116, 3, 3, 6),
(117, 3, 3, 7),
(118, 3, 3, 8),
(119, 3, 3, 9),
(120, 3, 3, 10),
(121, 3, 4, 1),
(122, 3, 4, 2),
(123, 3, 4, 3),
(124, 3, 4, 4),
(125, 3, 4, 5),
(126, 3, 4, 6),
(127, 3, 4, 7),
(128, 3, 4, 8),
(129, 3, 4, 9),
(130, 3, 4, 10),
(131, 3, 5, 1),
(132, 3, 5, 2),
(133, 3, 5, 3),
(134, 3, 5, 4),
(135, 3, 5, 5),
(136, 3, 5, 6),
(137, 3, 5, 7),
(138, 3, 5, 8),
(139, 3, 5, 9),
(140, 3, 5, 10),
(141, 3, 6, 1),
(142, 3, 6, 2),
(143, 3, 6, 3),
(144, 3, 6, 4),
(145, 3, 6, 5),
(146, 3, 6, 6),
(147, 3, 6, 7),
(148, 3, 6, 8),
(149, 3, 6, 9),
(150, 3, 6, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `platnosci`
--

CREATE TABLE `platnosci` (
  `platnosc_id` int(11) NOT NULL,
  `rezerwacja_id` int(11) DEFAULT NULL,
  `kwota` decimal(10,2) NOT NULL,
  `data_platnosci` datetime DEFAULT current_timestamp(),
  `metoda_platnosci` enum('karta','blik') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `platnosci`
--

INSERT INTO `platnosci` (`platnosc_id`, `rezerwacja_id`, `kwota`, `data_platnosci`, `metoda_platnosci`) VALUES
(1, 21, 34.99, '2025-03-08 21:39:27', 'karta'),
(2, 22, 34.99, '2025-03-08 21:40:31', 'karta'),
(3, 23, 34.99, '2025-03-08 21:43:25', 'karta'),
(4, 24, 34.99, '2025-03-08 21:47:35', 'karta'),
(5, 25, 34.99, '2025-03-08 21:52:35', 'karta'),
(6, 26, 34.99, '2025-03-08 21:52:54', 'blik'),
(7, 27, 25.00, '2025-03-08 22:04:57', 'blik'),
(8, 29, 34.99, '2025-03-08 22:15:15', 'karta'),
(9, 31, 34.99, '2025-03-08 22:28:50', 'karta'),
(10, 32, 28.99, '2025-03-08 22:57:04', 'blik'),
(11, 33, 34.99, '2025-03-08 23:09:06', 'blik'),
(12, 34, 25.00, '2025-03-08 23:17:28', 'karta'),
(13, 35, 34.99, '2025-03-08 23:21:49', 'karta');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje`
--

CREATE TABLE `rezerwacje` (
  `rezerwacja_id` int(11) NOT NULL,
  `klient_id` int(11) DEFAULT NULL,
  `seans_id` int(11) DEFAULT NULL,
  `miejsce_id` int(11) DEFAULT NULL,
  `data_rezerwacji` datetime DEFAULT current_timestamp(),
  `status` enum('aktywna','anulowana','zakonczona') DEFAULT 'aktywna',
  `data_platnosci` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rezerwacje`
--

INSERT INTO `rezerwacje` (`rezerwacja_id`, `klient_id`, `seans_id`, `miejsce_id`, `data_rezerwacji`, `status`, `data_platnosci`) VALUES
(15, 9, 10, 116, '2025-03-08 21:12:13', 'anulowana', NULL),
(16, 9, 1, 30, '2025-03-08 21:23:51', 'anulowana', NULL),
(17, 9, 10, 126, '2025-03-08 21:28:03', 'anulowana', '2025-03-08 21:31:32'),
(18, 9, 1, 40, '2025-03-08 21:31:48', 'anulowana', '2025-03-08 21:32:02'),
(19, 9, 1, 36, '2025-03-08 21:33:42', 'anulowana', '2025-03-08 21:34:05'),
(20, 9, 1, 40, '2025-03-08 21:34:42', 'anulowana', '2025-03-08 21:34:46'),
(21, 9, 10, 150, '2025-03-08 21:39:15', 'anulowana', '2025-03-08 21:39:27'),
(22, 9, 10, 150, '2025-03-08 21:40:24', 'anulowana', '2025-03-08 21:40:31'),
(23, 9, 10, 150, '2025-03-08 21:43:05', 'anulowana', '2025-03-08 21:43:25'),
(24, 9, 10, 150, '2025-03-08 21:47:27', 'anulowana', '2025-03-08 21:47:35'),
(25, 9, 10, 150, '2025-03-08 21:52:28', 'zakonczona', '2025-03-08 21:52:35'),
(26, 9, 10, 149, '2025-03-08 21:52:50', 'zakonczona', '2025-03-08 21:52:54'),
(27, 9, 13, 40, '2025-03-08 22:04:54', 'zakonczona', '2025-03-08 22:04:57'),
(28, 10, 10, 148, '2025-03-08 22:08:29', 'zakonczona', NULL),
(29, 10, 10, 146, '2025-03-08 22:14:50', 'zakonczona', '2025-03-08 22:15:15'),
(30, 10, 13, 40, '2025-03-08 22:23:07', 'zakonczona', NULL),
(31, 10, 10, 150, '2025-03-08 22:28:43', 'aktywna', '2025-03-08 22:28:50'),
(32, 10, 5, 90, '2025-03-08 22:56:59', 'aktywna', '2025-03-08 22:57:04'),
(33, 10, 7, 136, '2025-03-08 23:09:03', 'anulowana', '2025-03-08 23:09:06'),
(34, 10, 13, 40, '2025-03-08 23:17:21', 'aktywna', '2025-03-08 23:17:28'),
(35, 10, 10, 148, '2025-03-08 23:21:42', 'aktywna', '2025-03-08 23:21:49');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sale`
--

CREATE TABLE `sale` (
  `sala_id` int(11) NOT NULL,
  `nazwa_sali` varchar(50) NOT NULL,
  `pojemnosc` int(11) NOT NULL,
  `czy_3d` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`sala_id`, `nazwa_sali`, `pojemnosc`, `czy_3d`) VALUES
(1, 'Sala VIP', 40, 1),
(2, 'Sala Komfortowa', 50, 0),
(3, 'Sala Premium', 60, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `seanse`
--

CREATE TABLE `seanse` (
  `seans_id` int(11) NOT NULL,
  `film_id` int(11) DEFAULT NULL,
  `sala_id` int(11) DEFAULT NULL,
  `data_seansu` datetime NOT NULL,
  `cena` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seanse`
--

INSERT INTO `seanse` (`seans_id`, `film_id`, `sala_id`, `data_seansu`, `cena`) VALUES
(1, 1, 1, '2025-04-01 15:30:00', 32.99),
(2, 2, 2, '2025-04-03 18:00:00', 34.99),
(3, 3, 1, '2025-04-05 20:30:00', 29.99),
(4, 4, 3, '2025-04-07 16:00:00', 31.99),
(5, 5, 2, '2025-04-10 19:00:00', 28.99),
(6, 6, 1, '2025-04-15 21:30:00', 32.99),
(7, 7, 3, '2025-04-20 17:00:00', 34.99),
(8, 8, 2, '2025-04-25 20:00:00', 31.99),
(9, 9, 1, '2025-05-01 16:30:00', 29.99),
(10, 10, 3, '2025-05-05 19:30:00', 34.99),
(11, 11, 2, '2025-05-10 15:00:00', 27.99),
(12, 12, 1, '2025-05-15 18:30:00', 34.99),
(13, 10, 1, '2025-05-20 20:00:00', 25.00);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `filmy`
--
ALTER TABLE `filmy`
  ADD PRIMARY KEY (`film_id`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`klient_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `miejsca`
--
ALTER TABLE `miejsca`
  ADD PRIMARY KEY (`miejsce_id`),
  ADD KEY `sala_id` (`sala_id`);

--
-- Indeksy dla tabeli `platnosci`
--
ALTER TABLE `platnosci`
  ADD PRIMARY KEY (`platnosc_id`),
  ADD KEY `rezerwacja_id` (`rezerwacja_id`);

--
-- Indeksy dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`rezerwacja_id`),
  ADD KEY `klient_id` (`klient_id`),
  ADD KEY `seans_id` (`seans_id`),
  ADD KEY `miejsce_id` (`miejsce_id`);

--
-- Indeksy dla tabeli `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sala_id`);

--
-- Indeksy dla tabeli `seanse`
--
ALTER TABLE `seanse`
  ADD PRIMARY KEY (`seans_id`),
  ADD KEY `film_id` (`film_id`),
  ADD KEY `sala_id` (`sala_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filmy`
--
ALTER TABLE `filmy`
  MODIFY `film_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `klient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `miejsca`
--
ALTER TABLE `miejsca`
  MODIFY `miejsce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `platnosci`
--
ALTER TABLE `platnosci`
  MODIFY `platnosc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `rezerwacja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sala_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seanse`
--
ALTER TABLE `seanse`
  MODIFY `seans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `miejsca`
--
ALTER TABLE `miejsca`
  ADD CONSTRAINT `miejsca_ibfk_1` FOREIGN KEY (`sala_id`) REFERENCES `sale` (`sala_id`);

--
-- Constraints for table `platnosci`
--
ALTER TABLE `platnosci`
  ADD CONSTRAINT `platnosci_ibfk_1` FOREIGN KEY (`rezerwacja_id`) REFERENCES `rezerwacje` (`rezerwacja_id`);

--
-- Constraints for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `rezerwacje_ibfk_1` FOREIGN KEY (`klient_id`) REFERENCES `klienci` (`klient_id`),
  ADD CONSTRAINT `rezerwacje_ibfk_2` FOREIGN KEY (`seans_id`) REFERENCES `seanse` (`seans_id`),
  ADD CONSTRAINT `rezerwacje_ibfk_3` FOREIGN KEY (`miejsce_id`) REFERENCES `miejsca` (`miejsce_id`);

--
-- Constraints for table `seanse`
--
ALTER TABLE `seanse`
  ADD CONSTRAINT `seanse_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `filmy` (`film_id`),
  ADD CONSTRAINT `seanse_ibfk_2` FOREIGN KEY (`sala_id`) REFERENCES `sale` (`sala_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
