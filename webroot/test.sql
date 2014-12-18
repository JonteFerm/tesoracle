-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 18 dec 2014 kl 16:27
-- Serverversion: 5.1.31-community-log
-- PHP-version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `test`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `posted` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text CHARACTER SET utf8 NOT NULL,
  `posted` datetime NOT NULL,
  `answerId` int(11) DEFAULT NULL,
  `questionId` int(11) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `text` text NOT NULL,
  `posted` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `question2tag`
--

CREATE TABLE IF NOT EXISTS `question2tag` (
  `questionId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `question2tag`
--

INSERT INTO `question2tag` (`questionId`, `tagId`) VALUES
(27, 4),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(29, 5),
(29, 6),
(29, 7),
(29, 8),
(29, 9),
(29, 10),
(30, 1),
(31, 1),
(32, 3),
(33, 10),
(34, 3),
(35, 2),
(36, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` varchar(20) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `active` datetime DEFAULT NULL,
  `avatar` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acronym` (`acronym`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`id`, `acronym`, `email`, `name`, `password`, `created`, `updated`, `deleted`, `active`, `avatar`) VALUES
(1, 'admin', 'admin@dbwebb.se', 'Administrator', '$2y$10$zUybqO2Mm9/IBjdV1zR5MOHYIZ63t5fx9IC//PZPczrgChurfmbse', '0000-00-00 00:00:00', NULL, NULL, '2014-12-01 20:41:03', NULL),
(2, 'doe', 'doe@dbwebb.se', 'John/Jane Doe', '$2y$10$wpc6NeHBE6cRk6mY6/Ktu.RIUDc8lkRlh9drC6Nlkjm2qU2iruJdy', '0000-00-00 00:00:00', NULL, NULL, '2014-12-01 16:01:29', NULL);

-- --------------------------------------------------------

--
-- Ersättningsstruktur för vy `vanswer`
--
CREATE TABLE IF NOT EXISTS `vanswer` (
`id` int(11)
,`text` text
,`posted` datetime
,`userId` int(11)
,`questionId` int(11)
,`user` varchar(20)
,`email` varchar(80)
);
-- --------------------------------------------------------

--
-- Ersättningsstruktur för vy `vcomment`
--
CREATE TABLE IF NOT EXISTS `vcomment` (
`id` int(11)
,`text` text
,`posted` datetime
,`answerId` int(11)
,`questionId` int(11)
,`userId` int(11)
,`user` varchar(20)
);
-- --------------------------------------------------------

--
-- Ersättningsstruktur för vy `vquestion`
--
CREATE TABLE IF NOT EXISTS `vquestion` (
`id` int(11)
,`title` varchar(80)
,`text` text
,`posted` datetime
,`userId` int(11)
,`user` varchar(20)
,`email` varchar(80)
,`tag` varchar(341)
,`answers` bigint(21)
);
-- --------------------------------------------------------

--
-- Ersättningsstruktur för vy `vtag`
--
CREATE TABLE IF NOT EXISTS `vtag` (
`id` int(11)
,`name` varchar(30)
,`questionId` int(11)
);
-- --------------------------------------------------------

--
-- Struktur för vy `vanswer`
--
DROP TABLE IF EXISTS `vanswer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vanswer` AS select `a`.`id` AS `id`,`a`.`text` AS `text`,`a`.`posted` AS `posted`,`a`.`userId` AS `userId`,`a`.`questionId` AS `questionId`,`u`.`acronym` AS `user`,`u`.`email` AS `email` from (`answer` `a` left join `user` `u` on((`u`.`id` = `a`.`userId`)));

-- --------------------------------------------------------

--
-- Struktur för vy `vcomment`
--
DROP TABLE IF EXISTS `vcomment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vcomment` AS select `c`.`id` AS `id`,`c`.`text` AS `text`,`c`.`posted` AS `posted`,`c`.`answerId` AS `answerId`,`c`.`questionId` AS `questionId`,`c`.`userId` AS `userId`,`u`.`acronym` AS `user` from (`comment` `c` left join `user` `u` on((`c`.`userId` = `u`.`id`)));

-- --------------------------------------------------------

--
-- Struktur för vy `vquestion`
--
DROP TABLE IF EXISTS `vquestion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vquestion` AS select `q`.`id` AS `id`,`q`.`title` AS `title`,`q`.`text` AS `text`,`q`.`posted` AS `posted`,`q`.`userId` AS `userId`,`u`.`acronym` AS `user`,`u`.`email` AS `email`,group_concat(`t`.`name` separator ',') AS `tag`,(select count(`a`.`id`) AS `COUNT(A.id)` from `answer` `a` where (`a`.`questionId` = `q`.`id`)) AS `answers` from (((`question` `q` left join `user` `u` on((`q`.`userId` = `u`.`id`))) left join `question2tag` `q2t` on((`q`.`id` = `q2t`.`questionId`))) left join `tags` `t` on((`q2t`.`tagId` = `t`.`id`))) group by `q`.`posted`;

-- --------------------------------------------------------

--
-- Struktur för vy `vtag`
--
DROP TABLE IF EXISTS `vtag`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vtag` AS select `t`.`id` AS `id`,`t`.`name` AS `name`,`q2t`.`questionId` AS `questionId` from (`tags` `t` left join `question2tag` `q2t` on((`t`.`id` = `q2t`.`tagId`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
