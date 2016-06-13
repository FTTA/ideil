-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Час створення: Чрв 14 2016 р., 00:46
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

-- --------------------------------------------------------

--
-- Структура таблиці `articles_categories`
--

CREATE TABLE IF NOT EXISTS `articles_categories` (
  `article_id` int(10) unsigned NOT NULL,
  `category_id` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collection_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disk` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `manipulations` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_properties` text COLLATE utf8_unicode_ci NOT NULL,
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `media`
--

INSERT INTO `media` (`id`, `model_id`, `model_type`, `collection_name`, `name`, `file_name`, `disk`, `size`, `manipulations`, `custom_properties`, `order_column`, `created_at`, `updated_at`) VALUES
(1, 2, 'App\\User', 'images', '1465635573_4619', '1465635573_4619.jpg', 'media', 744898, '[]', '[]', 1, '2016-06-11 06:04:15', '2016-06-11 06:04:15'),
(2, 1, 'App\\User', 'images', '1465842641_3438', '1465842641_3438.jpg', 'media', 566820, '[]', '[]', 2, '2016-06-13 15:30:47', '2016-06-13 15:30:47');

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
('2014_10_12_100000_create_password_resets_table', 1),
('2016_06_10_201742_create_media_table', 2);

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
(1, 'Bob', 'bob@ukr.net', '$2y$10$4WvdME2PG9Tinz1hAefjCeJ36uSdEUsNWU8pyQz3HOnIT/wpt2orG', '4QpGDleUCzU3DRZGWx3nV7ua8V3KwyhDLEwfia1dwC8V2DSzgOQ7CSVasU4q', '2016-06-07 16:41:58', '2016-06-13 18:24:58', 1),
(2, 'bob name', 'bob2@ukr.net', '$2y$10$ntsxI6dIBfz0ENBKS2Zg4ux.Jp0uEBK0HdiM5Z0WqIMLGGh1pcecG', 'pdpIfH1EG5SiTjPyMkjxkH97Ym33o5lDK6xGlIqd7YktJBPuRXgK2pHh0l2m', '2016-06-08 16:14:59', '2016-06-13 16:37:38', 3);

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
-- Індекси таблиці `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Індекси таблиці `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблиці `media`
--
ALTER TABLE `media`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `FK_articles.user_id__users.id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
  ADD CONSTRAINT `FK_comments.user_id__users.id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_comments.article_id__articles.id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
