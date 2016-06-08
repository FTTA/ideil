-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Час створення: Чрв 08 2016 р., 22:51
-- Версія сервера: 5.5.48
-- Версія PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `ideil`
--

-- --------------------------------------------------------

--
-- Структура таблиці `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `date_creation` datetime NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `articles`
--

INSERT INTO `articles` (`id`, `title`, `text`, `user_id`, `date_creation`, `is_published`) VALUES
(1, 'asdasdasd', ' asdasd asd asdas dasd', 20, '2016-05-14 09:50:04', 0),
(3, 'wqeqwewq2', 'dfg dfgdf dfgdfgdfg dfgdfg ', 20, '2016-05-20 22:17:14', 1),
(7, 'qweqweqwqwe', 'qwqweqweqwewqeqwe qweqweqw', 20, '2016-06-04 20:53:27', 0),
(8, 'qwqwtrytrytry', 'sddsfewwefewfewfewwerewr', 20, '2016-06-05 18:46:26', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `articles_categories`
--

CREATE TABLE IF NOT EXISTS `articles_categories` (
  `article_id` int(10) unsigned NOT NULL,
  `category_id` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `articles_categories`
--

INSERT INTO `articles_categories` (`article_id`, `category_id`) VALUES
(3, 2),
(3, 3),
(7, 2),
(7, 3),
(8, 2);

-- --------------------------------------------------------

--
-- Структура таблиці `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` smallint(5) unsigned NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(2, 'test 2'),
(3, 'jkjk');

-- --------------------------------------------------------

--
-- Структура таблиці `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL,
  `text` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  `date_creation` datetime NOT NULL,
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `comments`
--

INSERT INTO `comments` (`id`, `text`, `user_id`, `article_id`, `date_creation`, `is_blocked`) VALUES
(1, 'asdasdcxzcx asdasd', 20, 1, '2016-05-16 21:05:49', 0),
(2, 'asdasdcxzcx asdasd', 20, 1, '2016-05-16 21:10:46', 0),
(3, 'asdasdcxzcx asdasd', 20, 1, '2016-05-16 21:10:49', 0),
(4, 'asdasdcxzcx asdasd', 20, 1, '2016-05-16 21:10:55', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(4) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Пример специфичной роли - Администратор'),
(3, 'user', 'Разрешён вход в систему.');

-- --------------------------------------------------------

--
-- Структура таблиці `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(20, 1),
(9, 3),
(16, 3),
(18, 3),
(19, 3),
(21, 3),
(22, 3),
(25, 3);

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` smallint(6) unsigned DEFAULT '3'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Bob', 'bob@ukr.net', '$2y$10$4WvdME2PG9Tinz1hAefjCeJ36uSdEUsNWU8pyQz3HOnIT/wpt2orG', '1qWlQ9OsHA4QNExwUOvxtleNZPttKsTMvdh0zxwc4aAYMm0R0c44h85WGVj6', '2016-06-07 16:41:58', '2016-06-08 16:14:30', 1),
(2, 'bob name', 'bob2@ukr.net', '$2y$10$ntsxI6dIBfz0ENBKS2Zg4ux.Jp0uEBK0HdiM5Z0WqIMLGGh1pcecG', 'Xegbuchdn4PnoST0C0tgaZkEqDHaQ5nBPxPFr4WD9XNy8B9BiwCVXcVoNNer', '2016-06-08 16:14:59', '2016-06-08 16:15:11', 3);

-- --------------------------------------------------------

--
-- Структура таблиці `users_`
--

CREATE TABLE IF NOT EXISTS `users_` (
  `id` int(11) unsigned NOT NULL,
  `password` char(64) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `last_login` datetime NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `users_`
--

INSERT INTO `users_` (`id`, `password`, `email`, `first_name`, `last_name`, `salt`, `last_login`, `is_confirmed`) VALUES
(9, '01f5117e8bda92fa0f04e72189cd3524faefa76d5093471d6b73ce888f48a910', 'riddleman@ukr.net', '', '0', 'dvAiIOZ73D', '0000-00-00 00:00:00', 1),
(16, '7133f25ee666292348f26a6d54c22af5055cc4df277b3b9f0b4a43cc16d9727d', 'qweqwe@yhjk.jk', '', '0', 'nDlNr', '0000-00-00 00:00:00', 0),
(18, '38b30b1f5fc5e44c112b44265d2e54be6163809327fb9e7e0613616c42a10717', 'eqweqwe@hjk.jk', '', '0', 'mWHmSFZUQ', '0000-00-00 00:00:00', 0),
(19, '92f7b2827256bca71751849fd58dd550e330b80acf97bfc297a198530bf6c4af', 'bob@ukr.net', '', '0', 'lrEcdyU0', '0000-00-00 00:00:00', 1),
(20, '090714d882df7241e7fee48c3d4c18794f3371a7a3d6dcd891799b1be2e7e692', 'test@ukr.net', 'first 3', 'last 2', '9N65lO', '0000-00-00 00:00:00', 1),
(21, 'ac829a29f7619fac6506c87b6a93a906d310df3c5c3c3327c533bd2db6150cd9', 'werwrqw@ukr.net', '', '', 'O18wLcDX', '0000-00-00 00:00:00', 1),
(22, '31f3745a7353117d789c7a22a87d16c305e9b2513ae32fb6e6ce22ca4cfb8c3b', 'qww@yh.hj', '', '', 'l209lX', '0000-00-00 00:00:00', 1),
(25, '435f433783f378176a83021a3a4595fdc9d3321c474490bf4b9a4574dca3c6e6', 'testn@ukr.net', '', '', '86xATd0', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `users_img`
--

CREATE TABLE IF NOT EXISTS `users_img` (
  `id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `users_img`
--

INSERT INTO `users_img` (`id`, `user_id`, `image_name`, `file_name`, `description`) VALUES
(2, 20, '', '20_1464130348_36.jpg', '');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_articles.user_id__users.id` (`user_id`);

--
-- Індекси таблиці `articles_categories`
--
ALTER TABLE `articles_categories`
  ADD KEY `article_id` (`article_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Індекси таблиці `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `FK_comments.user_id__users.id` (`user_id`);

--
-- Індекси таблиці `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Індекси таблиці `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_name` (`name`);

--
-- Індекси таблиці `roles_users`
--
ALTER TABLE `roles_users`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_role_id` (`role_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Індекси таблиці `users_`
--
ALTER TABLE `users_`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_email` (`email`);

--
-- Індекси таблиці `users_img`
--
ALTER TABLE `users_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_img.user_id__users.id` (`user_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблиці `categories`
--
ALTER TABLE `categories`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблиці `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `users_`
--
ALTER TABLE `users_`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблиці `users_img`
--
ALTER TABLE `users_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `FK_articles.user_id__users.id` FOREIGN KEY (`user_id`) REFERENCES `users_` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `articles_categories`
--
ALTER TABLE `articles_categories`
  ADD CONSTRAINT `FK_articles_categories.article_id__articles.id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `FK_articles_categories.category_id__categories.id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_comments.article_id__articles.id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `FK_comments.user_id__users.id` FOREIGN KEY (`user_id`) REFERENCES `users_` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `FK_roles_users.role_id__roles.id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FK_roles_users.user_id__users.id` FOREIGN KEY (`user_id`) REFERENCES `users_` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `users_img`
--
ALTER TABLE `users_img`
  ADD CONSTRAINT `FK_users_img.user_id__users.id` FOREIGN KEY (`user_id`) REFERENCES `users_` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
