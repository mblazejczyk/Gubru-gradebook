-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Maj 30, 2024 at 10:20 PM
-- Wersja serwera: 10.6.17-MariaDB-cll-lve
-- Wersja PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srv38973_dziennik`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `frekwencja`
--

CREATE TABLE `frekwencja` (
  `id` int(11) NOT NULL,
  `idNauczyciela` int(11) NOT NULL,
  `idUcznia` int(11) NOT NULL,
  `Kiedy` datetime NOT NULL DEFAULT current_timestamp(),
  `Typ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `frekwencja`
--

INSERT INTO `frekwencja` (`id`, `idNauczyciela`, `idUcznia`, `Kiedy`, `Typ`) VALUES
(1, 26, 25, '2022-01-08 11:00:00', 0),
(2, 26, 25, '2022-01-08 12:20:00', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `idKlasy` int(11) NOT NULL,
  `idSzkoly` int(11) NOT NULL,
  `NazwaKlasy` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `PrzedmiotyUczone` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `klasy`
--

INSERT INTO `klasy` (`idKlasy`, `idSzkoly`, `NazwaKlasy`, `PrzedmiotyUczone`) VALUES
(117, 2, '1A', '16'),
(118, 2, 'principal', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `idOceny` int(11) NOT NULL,
  `idUcznia` int(11) NOT NULL,
  `idPrzedmiotu` int(11) NOT NULL,
  `Ocena` int(11) NOT NULL,
  `Waga` int(11) NOT NULL,
  `Komentarz` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `DataDodania` date NOT NULL,
  `miejsceOceny` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `oceny`
--

INSERT INTO `oceny` (`idOceny`, `idUcznia`, `idPrzedmiotu`, `Ocena`, `Waga`, `Komentarz`, `DataDodania`, `miejsceOceny`) VALUES
(1, 25, 16, 5, 1, 'Homework', '2022-01-08', 1),
(2, 25, 16, 3, 5, 'Test', '2022-01-08', 1),
(3, 25, 16, 4, 0, 'Proposed', '2022-01-08', 2),
(4, 25, 16, 4, 0, '', '2022-01-08', 3),
(5, 25, 16, 1, 3, 'Short%20test', '2022-01-08', 4),
(6, 25, 16, 3, 5, 'test', '2022-01-08', 4),
(7, 25, 16, 2, 0, '', '2022-01-08', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `id` int(11) NOT NULL,
  `Temat` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `Ogloszenie` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `Data` date NOT NULL,
  `idSzkoly` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ogloszenia`
--

INSERT INTO `ogloszenia` (`id`, `Temat`, `Ogloszenie`, `Data`, `idSzkoly`) VALUES
(1, 'School closed', 'On 7th of January 2022 school will be closed. Have a great free day.', '2022-01-08', 2),
(2, 'No backpack day', 'On 15th of January there is no backpack day. Everyone participating will get additional points.', '2022-01-08', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plan`
--

CREATE TABLE `plan` (
  `id` int(11) NOT NULL,
  `Lekcja` text NOT NULL,
  `Sala` text NOT NULL,
  `GodzinaRozpoczecia` datetime NOT NULL,
  `GodzinaZakonczenia` datetime NOT NULL,
  `Nauczyciel` text NOT NULL,
  `idSzkoly` int(11) NOT NULL,
  `idKlasy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pliki`
--

CREATE TABLE `pliki` (
  `id` int(11) NOT NULL,
  `idSzkoly` int(11) NOT NULL,
  `sciezka` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `nazwa` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pliki`
--

INSERT INTO `pliki` (`id`, `idSzkoly`, `sciezka`, `nazwa`) VALUES
(1, 2, '/assets/pliki/Screenshot 2022-01-08 22.52.50.png', 'Lessonplan');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `idPrzedmiotu` int(11) NOT NULL,
  `Nazwa` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `Nauczyciel` int(11) NOT NULL,
  `idSzkoly` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `przedmioty`
--

INSERT INTO `przedmioty` (`idPrzedmiotu`, `Nazwa`, `Nauczyciel`, `idSzkoly`) VALUES
(16, 'Math', 26, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szkoly`
--

CREATE TABLE `szkoly` (
  `idSzkoly` int(11) NOT NULL,
  `NazwaSzkoly` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `szkoly`
--

INSERT INTO `szkoly` (`idSzkoly`, `NazwaSzkoly`) VALUES
(2, 'test');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `terminarz`
--

CREATE TABLE `terminarz` (
  `id` int(11) NOT NULL,
  `idKlasy` int(11) NOT NULL,
  `termin` date NOT NULL,
  `nazwa` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `komentarz` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `idNauczyciela` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `terminarz`
--

INSERT INTO `terminarz` (`id`, `idKlasy`, `termin`, `nazwa`, `komentarz`, `idNauczyciela`) VALUES
(1, 117, '2022-01-15', 'Nobackpackday', '', 26);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `login` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `haslo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `czyAdmin` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL,
  `idKlasy` int(11) NOT NULL,
  `uczoneKlasy` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `Imie` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `Nazwisko` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`login`, `haslo`, `czyAdmin`, `id`, `idKlasy`, `uczoneKlasy`, `Imie`, `Nazwisko`) VALUES
('principal', '$2y$10$xnx9ytg07CPUayDzjhv3Qu69xcZ4Tq7PfCNRETao6KKp7Y1NdA/Ti', 3, 1, 118, '', 'Principal', 'Blazejczyk'),
('student', '$2y$10$IK7HwnTa1GWpEMaBLlo.auzY1ueU5OMCzlr9MVwAmAkUrEXi6I1w.', 1, 25, 117, '', 'Mateusz', 'Blazejczyk'),
('teacher', '$2y$10$rdVwxoHNYkO9RM9DPpv7.eTFtcxLUEspOqYvAwgKgVQf87GXFtly2', 2, 26, 118, '117', 'Teacher', 'Blazejczyk');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wiadomosci`
--

CREATE TABLE `wiadomosci` (
  `id` int(11) NOT NULL,
  `idNadawcy` int(11) NOT NULL,
  `idAdresata` int(11) NOT NULL,
  `Temat` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `Wiadomosc` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `DataWyslania` date NOT NULL,
  `CzyOdczytane` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wiadomosci`
--

INSERT INTO `wiadomosci` (`id`, `idNadawcy`, `idAdresata`, `Temat`, `Wiadomosc`, `DataWyslania`, `CzyOdczytane`) VALUES
(1, 26, 25, 'Remember to connect on Teams', 'School is still closed due to COVID, so remember to connect via Teams', '2022-01-08', 1),
(3, 25, 26, 'I could not be on the test', 'When I could write it', '2022-01-08', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadania`
--

CREATE TABLE `zadania` (
  `id` int(11) NOT NULL,
  `idKlasy` int(11) NOT NULL,
  `idNauczyciela` int(11) NOT NULL,
  `Termin` date NOT NULL,
  `Temat` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `Tresc` text CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `zadania`
--

INSERT INTO `zadania` (`id`, `idKlasy`, `idNauczyciela`, `Termin`, `Temat`, `Tresc`) VALUES
(13, 117, 26, '2022-01-15', 'Math homework', 'For your homework, please do exercise 1 and 2 from page 55');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `frekwencja`
--
ALTER TABLE `frekwencja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idNauczyciela` (`idNauczyciela`) USING BTREE,
  ADD KEY `idUcznia` (`idUcznia`) USING BTREE;

--
-- Indeksy dla tabeli `klasy`
--
ALTER TABLE `klasy`
  ADD PRIMARY KEY (`idKlasy`),
  ADD KEY `idSzkoly` (`idSzkoly`) USING BTREE;

--
-- Indeksy dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`idOceny`),
  ADD KEY `idUcznia` (`idUcznia`) USING BTREE,
  ADD KEY `idPrzedmiotu` (`idPrzedmiotu`) USING BTREE;

--
-- Indeksy dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSzkoly` (`idSzkoly`);

--
-- Indeksy dla tabeli `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `pliki`
--
ALTER TABLE `pliki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSzkoly` (`idSzkoly`) USING BTREE;

--
-- Indeksy dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`idPrzedmiotu`),
  ADD KEY `Nauczyciel` (`Nauczyciel`) USING BTREE,
  ADD KEY `idSzkoly` (`idSzkoly`);

--
-- Indeksy dla tabeli `szkoly`
--
ALTER TABLE `szkoly`
  ADD PRIMARY KEY (`idSzkoly`);

--
-- Indeksy dla tabeli `terminarz`
--
ALTER TABLE `terminarz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKlasy` (`idKlasy`) USING BTREE,
  ADD KEY `idNauczyciela` (`idNauczyciela`) USING BTREE;

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKlasy` (`idKlasy`);

--
-- Indeksy dla tabeli `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idNadawcy` (`idNadawcy`) USING BTREE,
  ADD KEY `idAdresata` (`idAdresata`) USING BTREE;

--
-- Indeksy dla tabeli `zadania`
--
ALTER TABLE `zadania`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKlasy` (`idKlasy`) USING BTREE,
  ADD KEY `idNauczyciela` (`idNauczyciela`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `frekwencja`
--
ALTER TABLE `frekwencja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `klasy`
--
ALTER TABLE `klasy`
  MODIFY `idKlasy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `oceny`
--
ALTER TABLE `oceny`
  MODIFY `idOceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pliki`
--
ALTER TABLE `pliki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `idPrzedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `szkoly`
--
ALTER TABLE `szkoly`
  MODIFY `idSzkoly` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `terminarz`
--
ALTER TABLE `terminarz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `wiadomosci`
--
ALTER TABLE `wiadomosci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zadania`
--
ALTER TABLE `zadania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `frekwencja`
--
ALTER TABLE `frekwencja`
  ADD CONSTRAINT `frekwencja_ibfk_1` FOREIGN KEY (`idNauczyciela`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `frekwencja_ibfk_2` FOREIGN KEY (`idUcznia`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `klasy`
--
ALTER TABLE `klasy`
  ADD CONSTRAINT `klasy_ibfk_1` FOREIGN KEY (`idSzkoly`) REFERENCES `szkoly` (`idSzkoly`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `oceny`
--
ALTER TABLE `oceny`
  ADD CONSTRAINT `oceny_ibfk_2` FOREIGN KEY (`idPrzedmiotu`) REFERENCES `przedmioty` (`idPrzedmiotu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `oceny_ibfk_3` FOREIGN KEY (`idUcznia`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD CONSTRAINT `ogloszenia_ibfk_1` FOREIGN KEY (`idSzkoly`) REFERENCES `szkoly` (`idSzkoly`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pliki`
--
ALTER TABLE `pliki`
  ADD CONSTRAINT `pliki_ibfk_1` FOREIGN KEY (`idSzkoly`) REFERENCES `szkoly` (`idSzkoly`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD CONSTRAINT `przedmioty_ibfk_1` FOREIGN KEY (`Nauczyciel`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `przedmioty_ibfk_2` FOREIGN KEY (`idSzkoly`) REFERENCES `szkoly` (`idSzkoly`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `terminarz`
--
ALTER TABLE `terminarz`
  ADD CONSTRAINT `terminarz_ibfk_1` FOREIGN KEY (`idNauczyciela`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `terminarz_ibfk_2` FOREIGN KEY (`idKlasy`) REFERENCES `klasy` (`idKlasy`);

--
-- Constraints for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`idKlasy`) REFERENCES `klasy` (`idKlasy`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `wiadomosci`
--
ALTER TABLE `wiadomosci`
  ADD CONSTRAINT `wiadomosci_ibfk_1` FOREIGN KEY (`idNadawcy`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `wiadomosci_ibfk_2` FOREIGN KEY (`idAdresata`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `zadania`
--
ALTER TABLE `zadania`
  ADD CONSTRAINT `zadania_ibfk_2` FOREIGN KEY (`idNauczyciela`) REFERENCES `uzytkownicy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `zadania_ibfk_3` FOREIGN KEY (`idKlasy`) REFERENCES `klasy` (`idKlasy`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
