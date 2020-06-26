-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 26. Jun 2020 um 03:25
-- Server-Version: 10.3.21-MariaDB
-- PHP-Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ff-agt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `device_types`
--

DROP TABLE IF EXISTS `device_types`;
CREATE TABLE `device_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `device_types`
--

INSERT INTO `device_types` (`id`, `name`, `color`) VALUES
(1, 'Atemschutzgerät', '#00009e'),
(2, 'Maske', '#6d6d6d'),
(3, 'Rettungstasche', '#c70000');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organisation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `location`
--

INSERT INTO `location` (`id`, `name`, `organisation_id`) VALUES
(1, 'HLF', 1),
(2, 'StLF', 1),
(3, 'TSF/W', 3),
(5, 'LF', 5),
(6, 'TSF/W', 4),
(7, 'pers. Masken', 3),
(8, 'pers. Masken', 1),
(9, 'pers. Masken', 4),
(10, 'pers. Masken', 5),
(11, 'Tauschmasken', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `organisation`
--

DROP TABLE IF EXISTS `organisation`;
CREATE TABLE `organisation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `organisation`
--

INSERT INTO `organisation` (`id`, `name`, `color`) VALUES
(1, 'FF Bad Zwesten', '#00d400'),
(3, 'FF Oberurff/Schiffelborn', '#ffce6c'),
(4, 'FF Niederurff', '#ff8f8f'),
(5, 'FF Wenzigerode', '#7ec3ff');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `device_type_id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `positions`
--

INSERT INTO `positions` (`id`, `location_id`, `device_type_id`, `name`) VALUES
(1, 1, 2, 'Maske 1'),
(2, 1, 2, 'Maske 2'),
(3, 3, 1, 'Gerät 1'),
(4, 3, 1, 'Gerät 2'),
(5, 2, 1, 'Gerät 1'),
(6, 2, 1, 'Gerät 2'),
(7, 1, 1, 'Gerät 3'),
(8, 1, 1, 'Gerät 4'),
(9, 2, 1, 'Gerät 3'),
(10, 1, 2, 'Maske 3'),
(11, 1, 2, 'Maske 4'),
(12, 2, 2, 'Maske 1'),
(13, 1, 1, 'Gerät 1'),
(14, 1, 1, 'Gerät 2'),
(15, 2, 1, 'Gerät 4'),
(16, 2, 1, 'Gerät 5'),
(17, 2, 1, 'Gerät 6'),
(18, 2, 2, 'Maske 4'),
(19, 1, 3, 'Rettungstasche'),
(20, 2, 3, 'Rettungstasche'),
(21, 3, 3, 'Rettungstasche'),
(22, 7, 2, 'M. Seibel'),
(23, 3, 1, 'Gerät 3'),
(24, 3, 1, 'Gerät 4'),
(25, 3, 2, 'Maske 1'),
(26, 3, 2, 'Maske 2'),
(27, 3, 2, 'Maske 3'),
(28, 3, 2, 'Maske 4'),
(29, 2, 2, 'Maske 2'),
(30, 2, 2, 'Maske 3'),
(31, 2, 2, 'Maske 5'),
(32, 2, 2, 'Maske 6'),
(33, 5, 1, 'Gerät 1'),
(34, 5, 1, 'Gerät 2'),
(35, 5, 1, 'Gerät 3'),
(36, 5, 1, 'Gerät 4'),
(37, 5, 2, 'Maske 1'),
(38, 5, 2, 'Maske 2'),
(39, 5, 2, 'Maske 3'),
(40, 5, 2, 'Maske 4'),
(41, 6, 1, 'Gerät 1'),
(42, 6, 1, 'Gerät 2'),
(43, 6, 1, 'Gerät 3'),
(44, 6, 1, 'Gerät 4'),
(45, 6, 2, 'Maske 1'),
(46, 6, 2, 'Maske 3'),
(47, 6, 2, 'Maske 2'),
(48, 6, 2, 'Maske 4'),
(49, 8, 2, 'P. Amthauer'),
(50, 8, 2, 'C. Bathe'),
(51, 8, 2, 'M. Barthel'),
(52, 8, 2, 'S. König'),
(53, 8, 2, 'M. Nickel'),
(54, 8, 2, 'D. Reiber'),
(55, 8, 2, 'S. Becker'),
(56, 8, 2, 'S. Aubel'),
(57, 11, 2, 'Maske 1'),
(58, 11, 2, 'Maske 2'),
(59, 11, 2, 'Maske 3'),
(60, 11, 2, 'Maske 4'),
(61, 9, 2, 'C. Bachmann'),
(62, 9, 2, 'C. Gellert'),
(63, 10, 2, 'R. Koch'),
(64, 10, 2, 'F. Rose'),
(65, 10, 2, 'L. Rose');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stockings`
--

DROP TABLE IF EXISTS `stockings`;
CREATE TABLE `stockings` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `device_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_id` int(11) NOT NULL,
  `removed` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `stockings`
--

INSERT INTO `stockings` (`id`, `date`, `device_id`, `position_id`, `removed`, `user_id`, `created`, `updated`) VALUES
(27, '2020-06-13', '1995', 64, 0, 1, '2020-06-26 00:57:31', '2020-06-26 00:57:31'),
(28, '2020-06-13', '1961', 65, 0, 1, '2020-06-26 00:57:50', '2020-06-26 00:57:50'),
(29, '2020-06-13', '1970', 37, 0, 1, '2020-06-26 00:58:16', '2020-06-26 00:58:16'),
(30, '2020-06-13', '1967', 38, 0, 1, '2020-06-26 00:58:56', '2020-06-26 00:58:56'),
(31, '2020-06-13', '1964', 39, 0, 1, '2020-06-26 00:59:08', '2020-06-26 00:59:08'),
(32, '2020-06-13', '1971', 40, 0, 1, '2020-06-26 00:59:22', '2020-06-26 00:59:22'),
(33, '2020-06-13', '1577', 33, 0, 1, '2020-06-26 00:59:50', '2020-06-26 00:59:50'),
(34, '2020-06-13', '1588', 34, 0, 1, '2020-06-26 01:04:10', '2020-06-26 01:04:10'),
(35, '2020-06-13', '1594', 35, 0, 1, '2020-06-26 01:04:27', '2020-06-26 01:04:27'),
(36, '2020-06-13', '1591', 36, 0, 1, '2020-06-26 01:04:38', '2020-06-26 01:04:38'),
(37, '2020-06-13', '1595', 41, 0, 1, '2020-06-26 01:06:03', '2020-06-26 01:06:03'),
(38, '2020-06-13', '1580', 42, 0, 1, '2020-06-26 01:06:57', '2020-06-26 01:06:57'),
(39, '2020-06-13', '1579', 43, 0, 1, '2020-06-26 01:07:10', '2020-06-26 01:07:10'),
(40, '2020-06-13', '1587', 44, 0, 1, '2020-06-26 01:07:22', '2020-06-26 01:07:22'),
(41, '2020-06-13', '1956', 61, 0, 1, '2020-06-26 01:07:45', '2020-06-26 01:07:45'),
(42, '2020-06-13', '1952', 62, 0, 1, '2020-06-26 01:07:59', '2020-06-26 01:07:59'),
(43, '2020-06-13', '1354', 45, 0, 1, '2020-06-26 01:08:13', '2020-06-26 01:08:13'),
(44, '2020-06-13', '1977', 47, 0, 1, '2020-06-26 01:08:24', '2020-06-26 01:08:24'),
(45, '2020-06-13', '1978', 46, 0, 1, '2020-06-26 01:08:35', '2020-06-26 01:08:35'),
(46, '2020-06-13', '1981', 48, 0, 1, '2020-06-26 01:08:45', '2020-06-26 01:08:45'),
(47, '2020-06-13', '1969', 25, 0, 1, '2020-06-26 01:09:04', '2020-06-26 01:09:04'),
(48, '2020-06-13', '1966', 26, 0, 1, '2020-06-26 01:09:20', '2020-06-26 01:09:20'),
(49, '2020-06-13', '1951', 27, 0, 1, '2020-06-26 01:09:31', '2020-06-26 01:09:31'),
(50, '2020-06-13', '1957', 28, 0, 1, '2020-06-26 01:09:47', '2020-06-26 01:09:47'),
(51, '2020-06-13', '1989', 22, 0, 1, '2020-06-26 01:10:01', '2020-06-26 01:10:01'),
(52, '2020-06-13', '11 BRCA 0909', 21, 0, 1, '2020-06-26 01:10:40', '2020-06-26 01:10:40'),
(53, '2020-06-13', '19BRMK4597', 20, 0, 1, '2020-06-26 01:11:01', '2020-06-26 01:11:01'),
(54, '2020-06-13', '19BRMK4600', 19, 0, 1, '2020-06-26 01:11:19', '2020-06-26 01:11:19'),
(55, '2020-06-13', '1584', 3, 0, 1, '2020-06-26 01:11:49', '2020-06-26 01:11:49'),
(56, '2020-06-13', '1583', 4, 0, 1, '2020-06-26 01:12:08', '2020-06-26 01:12:08'),
(57, '2020-06-13', '1582', 23, 0, 1, '2020-06-26 01:12:31', '2020-06-26 01:12:31'),
(58, '2020-06-13', '1599', 24, 0, 1, '2020-06-26 01:12:45', '2020-06-26 01:12:45'),
(59, '2020-06-13', '1592', 13, 0, 1, '2020-06-26 01:13:15', '2020-06-26 01:13:15'),
(60, '2020-06-13', '1335', 14, 0, 1, '2020-06-26 01:15:33', '2020-06-26 01:15:33'),
(61, '2020-06-13', '1593', 7, 0, 1, '2020-06-26 01:15:46', '2020-06-26 01:15:46'),
(62, '2020-06-13', '1596', 8, 0, 1, '2020-06-26 01:15:59', '2020-06-26 01:15:59'),
(63, '2020-06-13', '1586', 5, 0, 1, '2020-06-26 01:16:14', '2020-06-26 01:16:14'),
(64, '2020-06-13', '1578', 6, 0, 1, '2020-06-26 01:16:32', '2020-06-26 01:16:32'),
(65, '2020-06-13', '1600', 9, 0, 1, '2020-06-26 01:16:42', '2020-06-26 01:16:42'),
(66, '2020-06-13', '1590', 15, 0, 1, '2020-06-26 01:16:54', '2020-06-26 01:16:54'),
(67, '2020-06-13', '1585', 16, 0, 1, '2020-06-26 01:17:05', '2020-06-26 01:17:05'),
(68, '2020-06-13', '1589', 17, 0, 1, '2020-06-26 01:17:14', '2020-06-26 01:17:14'),
(69, '2020-06-13', '1972', 12, 0, 1, '2020-06-26 01:17:45', '2020-06-26 01:17:45'),
(70, '2020-06-13', '1973', 29, 0, 1, '2020-06-26 01:17:57', '2020-06-26 01:17:57'),
(71, '2020-06-13', '1974', 30, 0, 1, '2020-06-26 01:18:08', '2020-06-26 01:18:08'),
(72, '2020-06-13', '1975', 18, 0, 1, '2020-06-26 01:18:18', '2020-06-26 01:18:18'),
(73, '2020-06-13', '1965', 31, 0, 1, '2020-06-26 01:18:30', '2020-06-26 01:18:30'),
(74, '2020-06-13', '1968', 32, 0, 1, '2020-06-26 01:18:42', '2020-06-26 01:18:42'),
(75, '2020-06-13', '1352', 1, 0, 1, '2020-06-26 01:18:58', '2020-06-26 01:18:58'),
(76, '2020-06-13', '1954', 2, 0, 1, '2020-06-26 01:19:11', '2020-06-26 01:19:11'),
(77, '2020-06-13', '1959', 10, 0, 1, '2020-06-26 01:19:26', '2020-06-26 01:19:26'),
(78, '2020-06-13', '1979', 11, 0, 1, '2020-06-26 01:19:36', '2020-06-26 01:19:36'),
(79, '2020-06-13', '1993', 50, 0, 1, '2020-06-26 01:19:55', '2020-06-26 01:19:55'),
(80, '2020-06-13', '1991', 54, 0, 1, '2020-06-26 01:20:18', '2020-06-26 01:20:18'),
(81, '2020-06-13', '1990', 55, 0, 1, '2020-06-26 01:20:30', '2020-06-26 01:20:30'),
(82, '2020-06-13', '1955', 56, 0, 1, '2020-06-26 01:20:45', '2020-06-26 01:20:45'),
(83, '2020-06-13', '1998', 57, 0, 1, '2020-06-26 01:22:07', '2020-06-26 01:22:07'),
(84, '2020-06-13', '1992', 58, 0, 1, '2020-06-26 01:22:17', '2020-06-26 01:22:17'),
(85, '2020-06-13', '1997', 59, 0, 1, '2020-06-26 01:22:28', '2020-06-26 01:22:28'),
(86, '2020-06-13', '1963', 60, 0, 1, '2020-06-26 01:22:42', '2020-06-26 01:22:42');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`) VALUES
(1, 'jens.herden@web.de', '{\"role\":\"ROLE_ADMIN\"}', '$argon2id$v=19$m=65536,t=4,p=1$VD0rDWxN5mxZQgTsKraHoA$/4ZUp3U987927NfLz/jq7DeMeziaoURc9jVN9v7mYhM', 'Jens Herden'),
(3, 'm.brokmann@ffwbz.de', '[]', '$argon2id$v=19$m=65536,t=4,p=1$wBWM2BaPHoO5ZeWREov3qw$GDtcrp+yhKk+z7MH9akbLnhmMrlD4bWGgMBE6SKBMCs', 'Michael Brokmann');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `device_types`
--
ALTER TABLE `device_types`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5E9E89CB9E6B1585` (`organisation_id`);

--
-- Indizes für die Tabelle `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D69FE57C64D218E` (`location_id`),
  ADD KEY `IDX_D69FE57C4FFA550E` (`device_type_id`);

--
-- Indizes für die Tabelle `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indizes für die Tabelle `stockings`
--
ALTER TABLE `stockings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FD96F035DD842E46` (`position_id`),
  ADD KEY `IDX_FD96F035A76ED395` (`user_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `device_types`
--
ALTER TABLE `device_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `organisation`
--
ALTER TABLE `organisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT für Tabelle `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `stockings`
--
ALTER TABLE `stockings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `FK_5E9E89CB9E6B1585` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`id`);

--
-- Constraints der Tabelle `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `FK_D69FE57C4FFA550E` FOREIGN KEY (`device_type_id`) REFERENCES `device_types` (`id`),
  ADD CONSTRAINT `FK_D69FE57C64D218E` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`);

--
-- Constraints der Tabelle `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `stockings`
--
ALTER TABLE `stockings`
  ADD CONSTRAINT `FK_FD96F035A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_FD96F035DD842E46` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
