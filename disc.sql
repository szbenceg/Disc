-- phpMyAdmin SQL Dump 
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
-
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Jan 23. 12:41
-- Kiszolgáló verziója: 10.4.6-MariaDB
-- PHP verzió: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `disc`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `discs`
--

CREATE TABLE `discs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `genre` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `artist` varchar(40) COLLATE utf8_hungarian_ci NOT NULL,
  `album` varchar(40) COLLATE utf8_hungarian_ci NOT NULL,
  `released` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `country` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `disc_condition` varchar(40) COLLATE utf8_hungarian_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) COLLATE utf8_hungarian_ci NOT NULL,
  `email_address` varchar(200) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `user_name`, `email_address`, `password`) VALUES
(9, 'Gergo', 'bence.szajko@gmail.com', 'asd'),
(10, 'Asd', 'asd@asd.com', 'asd');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `discs`
--
ALTER TABLE `discs`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
