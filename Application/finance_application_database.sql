-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Gru 2022, 09:46
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `finance_application_database`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_list`
--

CREATE TABLE `expenses_list` (
  `expense_id` int(11) NOT NULL,
  `category` text COLLATE utf8_polish_ci NOT NULL,
  `amount` float NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` text COLLATE utf8_polish_ci NOT NULL,
  `users_id` int(11) NOT NULL,
  `additional_comment` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_list`
--

INSERT INTO `expenses_list` (`expense_id`, `category`, `amount`, `payment_date`, `payment_method`, `users_id`, `additional_comment`) VALUES
(1, 'żywność', 603.66, '2022-05-10', 'karta krerdytowa', 3, 'Komentarz1'),
(2, 'mieszaknie', 808.54, '2022-11-15', 'karta debetowa', 1, 'Komentarz2'),
(3, 'żywność', 786.44, '2022-10-30', 'gotowka', 1, 'Komentarz3'),
(4, 'paliwo', 559.34, '2022-02-16', 'gotówka', 2, 'Komentarz4'),
(5, 'wakacje', 7665.23, '2021-12-22', 'karta kredytowa', 2, 'Komentarz5'),
(6, 'energia', 337.54, '2021-12-14', 'gotówka', 3, 'Komentarz6'),
(7, 'ubezpieczenie', 445.88, '2022-11-08', 'karta kredytowa', 3, 'Komentarz7'),
(8, 'żywność', 205.28, '2022-07-22', 'karta debetowa', 3, 'Komentarz8'),
(9, 'mieszkanie', 896.76, '2022-10-03', 'karta kredytowa', 2, 'Komentarz9'),
(10, 'mieszkanie', 1800, '2022-10-31', 'karta kredytowa', 1, 'Komentarz10'),
(11, 'paliwo', 765.93, '2022-10-28', 'gotówka', 2, 'Komentarz11'),
(12, 'energia', 436.78, '2022-10-26', 'karta debetowa', 1, 'Komentarz12'),
(16, 'wakacje', 455.24, '2022-03-15', 'karta', 3, 'Komentarz16'),
(17, 'książki', 345.21, '2022-12-13', 'blik', 3, 'Komentarz17');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expense_categories`
--

CREATE TABLE `expense_categories` (
  `category_id` int(11) NOT NULL,
  `expense_category` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expense_categories`
--

INSERT INTO `expense_categories` (`category_id`, `expense_category`) VALUES
(1, 'żywność'),
(2, 'mieszkanie'),
(3, 'paliwo'),
(4, 'energia'),
(5, 'ubezpieczenie'),
(6, 'książki'),
(7, 'wakacje');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `income_categories`
--

CREATE TABLE `income_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `income_categories`
--

INSERT INTO `income_categories` (`category_id`, `category_name`) VALUES
(1, 'odsetki bankowe'),
(2, 'wynagrodzenie'),
(3, 'sprzedaż na allegro'),
(4, 'korepetycje'),
(6, 'sklep internetowy'),
(7, 'dywidendy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `income_list`
--

CREATE TABLE `income_list` (
  `income_id` int(11) NOT NULL,
  `category` text COLLATE utf8_polish_ci NOT NULL,
  `amount` float NOT NULL,
  `payment_date` date NOT NULL,
  `users_id` int(11) NOT NULL,
  `additional_comment` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `income_list`
--

INSERT INTO `income_list` (`income_id`, `category`, `amount`, `payment_date`, `users_id`, `additional_comment`) VALUES
(1, 'wynagrodzenie', 1500.54, '2022-07-12', 2, 'Komentarz1'),
(2, 'odsetki bankowe', 500.68, '2021-06-15', 1, 'Komentarz2'),
(3, 'sprzedaż na allegro', 2300.76, '2022-10-31', 3, 'Komentarz3'),
(4, 'wynagrodzenie', 3400.87, '2022-11-08', 3, 'Komentarz4'),
(5, 'wynagrodznie', 76052.9, '2022-02-02', 1, 'Komentarz5'),
(6, 'odsetki bankowe', 568.33, '2022-11-03', 3, 'Komentarz6'),
(9, 'odsetki bankowe', 5508.78, '2022-11-07', 1, 'Komentarz7'),
(10, 'korepetycje', 345.67, '2022-12-07', 2, 'Komentarz10'),
(11, 'sklep internetowy', 775.32, '2022-12-02', 1, 'Komentarz11'),
(12, 'korepetycje', 235.54, '2022-12-01', 2, 'Komentarz12'),
(13, 'sprzedaż na allegro', 355.67, '2022-12-06', 3, 'Komentarz13'),
(14, 'odsetki bankowe', 556.03, '2022-08-16', 1, 'Komentarz14'),
(15, 'dywidendy', 890.45, '2022-10-04', 2, 'Komentarz15'),
(16, 'sprzedaż na allegro', 472.23, '2022-09-13', 3, 'Komentarz16'),
(17, 'dywidendy', 155.78, '2021-12-03', 3, 'Komentarz17');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods`
--

CREATE TABLE `payment_methods` (
  `payment_id` int(11) NOT NULL,
  `payment_name` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods`
--

INSERT INTO `payment_methods` (`payment_id`, `payment_name`) VALUES
(1, 'gotówka'),
(2, 'karta debetowa'),
(3, 'karta kredytowa'),
(4, 'czek'),
(5, 'blik'),
(6, 'karta benefitowa'),
(7, 'przekaz pocztowy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_list`
--

CREATE TABLE `users_list` (
  `user_id` int(11) NOT NULL,
  `user_first_name` text COLLATE utf8_polish_ci NOT NULL,
  `user_surname` text COLLATE utf8_polish_ci NOT NULL,
  `user_login` text COLLATE utf8_polish_ci NOT NULL,
  `user_password` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users_list`
--

INSERT INTO `users_list` (`user_id`, `user_first_name`, `user_surname`, `user_login`, `user_password`) VALUES
(1, 'Imie1', 'Nazwisko1', 'login1', 'haslo1'),
(2, 'Imie2', 'Nazwisko2', 'login2', 'haslo2'),
(3, 'Imie3', 'Nazwisko3', 'login3', 'haslo3'),
(4, 'Imie4', 'Nazwisko4', 'login4', 'haslo4');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `expenses_list`
--
ALTER TABLE `expenses_list`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indeksy dla tabeli `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeksy dla tabeli `income_categories`
--
ALTER TABLE `income_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeksy dla tabeli `income_list`
--
ALTER TABLE `income_list`
  ADD PRIMARY KEY (`income_id`);

--
-- Indeksy dla tabeli `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indeksy dla tabeli `users_list`
--
ALTER TABLE `users_list`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `expenses_list`
--
ALTER TABLE `expenses_list`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `income_categories`
--
ALTER TABLE `income_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `income_list`
--
ALTER TABLE `income_list`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `users_list`
--
ALTER TABLE `users_list`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
