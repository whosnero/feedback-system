-- phpMyAdmin SQL Dump (5.1.1)
-- Server-Version: 10.4.20-MariaDB; PHP-Version: 8.0.8

--
-- Datenbank: `feedo`
--
CREATE DATABASE IF NOT EXISTS `feedo` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `feedo`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `valuation` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sample_questions`
--

CREATE TABLE `sample_questions` (
  `id` int(11) NOT NULL,
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `sample_questions`
--

INSERT INTO `sample_questions` (`id`, `question`, `created_at`) VALUES
(1, 'My teacher imparts the subject matter well.', '2021-10-14 16:59:03'),
(2, 'My teacher is always ready to support the students.', '2021-10-14 17:02:04'),
(3, 'My teacher supports every student evenly.', '2021-10-14 17:05:56');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL,
  `code` int(5) NOT NULL,
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `questionid` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indizes für die Tabelle `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `sample_questions`
--
ALTER TABLE `sample_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für Tabelle `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- AUTO_INCREMENT für Tabelle `sample_questions`
--
ALTER TABLE `sample_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;
COMMIT;