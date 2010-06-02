-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2010 at 12:01 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pagination`
--

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE IF NOT EXISTS `tutorials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tutorials`
--

INSERT INTO `tutorials` (`id`, `title`, `url`) VALUES
(1, 'Show The URL Of The Page ', 'http://www.jooria.com/Tutorials/Website-Programming-16/Show-The-URL-Of-The-Page-49/index.html'),
(2, 'Delete Records With Effect Using jQuery And PHP ', 'http://www.jooria.com/Tutorials/Website-Programming-16/Delete-Records-With-Effect-Using-jQuery-And-PHP-152/index.html'),
(3, 'Limit Characters From Your Text ', 'http://www.jooria.com/Tutorials/Website-Programming-16/Limit-Characters-From-Your-Text-139/index.html'),
(4, 'Operators In Php', 'http://www.jooria.com/Tutorials/Website-Programming-16/Operators-In-Php-129/index.html'),
(5, 'Advanced PHP Comments System With jQuery ', 'http://www.jooria.com/Tutorials/Website-development-10/Advanced-PHP-Comments-System-With-jQuery-155/index.html'),
(6, 'Simple PHP JS loader ', 'http://www.jooria.com/Tutorials/Website-Programming-16/Simple-PHP-JS-loader-154/index.html'),
(7, 'Empty Directories from the files ', 'http://www.jooria.com/Tutorials/Website-Programming-16/Empty-Directories-from-the-files-151/index.html'),
(8, 'Templating Your Site with RainTPL ', 'http://www.jooria.com/Tutorials/Website-Programming-16/Templating-Your-Site-with-RainTPL-141/index.html'),
(9, 'Drawing Glossy Button ', 'http://www.jooria.com/Tutorials/Graphics-5/Drawing-Glossy-Button-138/index.html'),
(10, 'Forcing www in the site url ', 'http://www.jooria.com/Tutorials/Website-development-10/Forcing-www-in-the-site-url-136/index.html'),
(11, 'Textarea Maxlength script ', 'http://www.jooria.com/Tutorials/Website-Designing-11/Textarea-Maxlength-script-128/index.html');
