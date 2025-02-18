-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2025 at 08:48 PM
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
  `data_rejestracji` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `platnosci`
--

CREATE TABLE `platnosci` (
  `platnosc_id` int(11) NOT NULL,
  `rezerwacja_id` int(11) DEFAULT NULL,
  `kwota` decimal(10,2) NOT NULL,
  `data_platnosci` datetime DEFAULT current_timestamp(),
  `metoda_platnosci` enum('gotowka','karta','online') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `status` enum('aktywna','anulowana','zakonczona') DEFAULT 'aktywna'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `klient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `miejsca`
--
ALTER TABLE `miejsca`
  MODIFY `miejsce_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platnosci`
--
ALTER TABLE `platnosci`
  MODIFY `platnosc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `rezerwacja_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sala_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seanse`
--
ALTER TABLE `seanse`
  MODIFY `seans_id` int(11) NOT NULL AUTO_INCREMENT;

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
