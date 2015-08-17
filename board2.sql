-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 17 2015 г., 17:30
-- Версия сервера: 5.6.22-log
-- Версия PHP: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `board2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mes_categories`
--

CREATE TABLE IF NOT EXISTS `mes_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `mes_categories`
--

INSERT INTO `mes_categories` (`category_id`, `name`, `parent_id`) VALUES
(1, 'Транспорт', 0),
(2, 'Дом', 0),
(5, 'Мото', 1),
(6, 'Грузовые', 1),
(7, 'Игры', 2),
(8, 'Лампы', 2),
(9, 'Интернет', 0),
(10, 'Google', 9),
(11, 'Yandex', 9),
(12, 'Bing', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `mes_posts`
--

CREATE TABLE IF NOT EXISTS `mes_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `date` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `town` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `published` enum('0','1') NOT NULL DEFAULT '0',
  `is_actual` enum('0','1') NOT NULL DEFAULT '1',
  `price` int(11) NOT NULL,
  `additional_images` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `mes_posts`
--

INSERT INTO `mes_posts` (`post_id`, `title`, `body`, `date`, `user_id`, `category_id`, `type_id`, `town`, `img`, `published`, `is_actual`, `price`, `additional_images`) VALUES
(16, 'Заголовок', '4212312312312313212', 1439797565, 1, 6, 1, 'Минск', '1439797565-55d1913d826d9.jpg', '0', '1', 100, '0-1439797565-55d1913d8a3db.jpg|1-1439797565-55d1913d93465.jpg|2-1439797565-55d1913d98e3e.jpg'),
(17, 'Заголовок 2', 'какой-то текст', 1439802876, 1, 10, 2, 'Минск', '1439802876-55d1a5fc802cc.jpg', '1', '1', 4444, '0-1439802876-55d1a5fc8879e.jpg|1-1439802876-55d1a5fc8ed30.jpg|2-1439802876-55d1a5fc95a91.jpg'),
(18, 'Заголовок 3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam beatae consequuntur exercitationem facere ipsum libero nisi nobis perferendis placeat possimus quas quidem suscipit, voluptatum! A asperiores deleniti dicta incidunt ipsam, ipsum maxime minus odio officia quisquam quod reiciendis repellat vero. Animi dolorem enim eum excepturi expedita impedit, mollitia non, omnis reiciendis sequi similique temporibus, vel voluptas. Beatae deserunt ipsum maxime optio perferendis. At culpa cum dolorem eveniet illum neque nulla placeat voluptatibus. Accusamus alias aut consectetur consequatur cum deserunt doloremque dolorum eaque eligendi id illo incidunt labore, neque officia perferendis quam quo saepe similique sunt tempore vel velit veritatis vero.', 1439809081, 1, 7, 1, 'Минск', '1439809081-55d1be39b9873.jpg', '0', '1', 23213, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mes_privilegies`
--

CREATE TABLE IF NOT EXISTS `mes_privilegies` (
  `priv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`priv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `mes_privilegies`
--

INSERT INTO `mes_privilegies` (`priv_id`, `name`) VALUES
(1, 'ADD_MESS'),
(2, 'MODERATION_MESS'),
(3, 'DEL_MESS'),
(4, 'RETIME_MESS'),
(5, 'EDIT_MESS'),
(6, 'ADD_CAT'),
(7, 'VIEW_ADMIN_PAGE');

-- --------------------------------------------------------

--
-- Структура таблицы `mes_role`
--

CREATE TABLE IF NOT EXISTS `mes_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `mes_role`
--

INSERT INTO `mes_role` (`role_id`, `name`) VALUES
(1, 'admin'),
(2, 'moderator'),
(3, 'user'),
(4, 'banned');

-- --------------------------------------------------------

--
-- Структура таблицы `mes_role_priv`
--

CREATE TABLE IF NOT EXISTS `mes_role_priv` (
  `role_id` int(11) NOT NULL,
  `priv_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mes_role_priv`
--

INSERT INTO `mes_role_priv` (`role_id`, `priv_id`) VALUES
(3, 1),
(1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mes_types`
--

CREATE TABLE IF NOT EXISTS `mes_types` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `mes_types`
--

INSERT INTO `mes_types` (`type_id`, `name`) VALUES
(1, 'Предложение'),
(2, 'Спрос');

-- --------------------------------------------------------

--
-- Структура таблицы `mes_users`
--

CREATE TABLE IF NOT EXISTS `mes_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '0',
  `sess` varchar(32) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '3',
  `created` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `mes_users`
--

INSERT INTO `mes_users` (`user_id`, `login`, `password`, `name`, `hash`, `active`, `sess`, `email`, `role_id`, `created`, `last_login`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Андрей', '36ed9de6b0cec29b771f91b91acde47f', '1', '55e0a52f3499bb3c90feb4857c94c6f0', 'andryfly7@gmail.com', 1, 1438471421, 1439805924),
(5, 'test10', '202cb962ac59075b964b07152d234b70', 'Серёга', '84f71fef3e3747abfa2a4dff1f5e1c83', '1', '50d8fe4a93d42c4fd13bb62d970c255e', 'a.ndr.yfly7@gmail.com', 3, 1438642228, 1438957813);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
