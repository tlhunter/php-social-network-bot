SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `messages` (`id`, `subject`, `body`) VALUES
(1, 'T1', 'TEST1'),
(2, 'T2', 'TEST2');

CREATE TABLE IF NOT EXISTS `state` (
  `name` varchar(63) NOT NULL,
  `value` varchar(63) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `state` (`name`, `value`) VALUES
('halt', '0');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  `password` varchar(20) NOT NULL,
  `flag` smallint(1) NOT NULL DEFAULT '0',
  `reported` tinyint(4) NOT NULL DEFAULT '0',
  `friends` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
