-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Час створення: Чрв 14 2016 р., 23:43
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `articles`
--

INSERT INTO `articles` (`id`, `title`, `text`, `user_id`, `date_creation`, `is_published`) VALUES
(1, 'test article 2', '2 Украина подпишет Соглашение о сотрудничестве с Европейской организацией по вопросам юстиции в конце июня 2016 года во время визита в Брюссель президента Петра Порошенко.\nОб этом заявил генеральный прокурор Юрий Луценко в Брюсселе на пресс-конференции "Судебная реформа в Украине" в рамках слушаний Комитета Европарламента по правовым вопросам, передает БизнесЦензор со ссылкой на Европейскую правду.\n\nПо словам Луценко, подписание соглашения расширит возможность украинских правоохранителей в проведении международных операций.\n\n"Да, я получил полномочия на подписание этого соглашения, но это состоится в конце этого месяца во время визита президента в Брюссель. К сожалению, у нас сейчас достаточно много проблем с международной правовой помощью с разными странами", - сказал Луценко.', 1, '2016-06-14 16:52:52', 1),
(2, 'Максимиллиано Ричезе', ' Максимиллиано Ричезе: «Вот это была гонка, до сих пор не могу поверить! Это как мечта. Утром, на собрании команды мы обсуждали финал этапа, знали, что он будет коварным, с технически трудным поворотом, который должен стать ключом к победе на этапе. Мы планировали, что в этот поворот должны зайти на первой и второй позициях.\n\n Мой спринт должен был длиться до поворота, но Фернандо не стал меня обгонять, решив вместо этого меня защищать, и я понёсся до финиша на полной скорости. Хочу поблагодарить Фернандо и всю команду за их огромный труд и поддержку! Я всегда поддерживал нашу команду, постоянно был последним гонщиком перед розыгрышем спринта, и, наконец, получить возможность побороться за победу – это действительно великолепно. Старт этого сезона не был для меня лёгким, я получил травму и восстанавливался.\n  Хочу наслаждаться этим днём. Я стал первым аргентинцем, одержавшим победу на этапе на Туре Швейцарии, это огромное достижение, я горжусь и счастлив».', 1, '2016-06-14 20:39:36', 1),
(3, 'Украинки сенсационно выиграли турнир в Вильнюсе', '\n\nУкраинские волейболистки Валентина Давидова и Евгения Щипкова сенсационно выиграли турнир в Вильнюсе.\n\nХарактерно, что свой путь на турнире украинки начинали с квалификационных раундов.\n\nНа пути к победе Давидова и Щипкова обыграли две литовские пары, дуэты с Чехии и Германии, уступив только норвежцам. По правилам турнира, борьба идет до двух поражений.\n\nВ финале украинские волейболистки обыграли хозяек турнира Андриукайтюте и Зобнину — 21:15, 14:21, 18:16.', 1, '2016-06-14 20:40:24', 1);

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
(1, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `comments`
--

INSERT INTO `comments` (`id`, `text`, `user_id`, `article_id`, `date_creation`, `is_blocked`) VALUES
(2, 'Коментар 1', 1, 1, '2016-06-14 18:15:13', 0),
(3, 'Test komment', 3, 1, '2016-06-14 20:32:15', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `media`
--

INSERT INTO `media` (`id`, `model_id`, `model_type`, `collection_name`, `name`, `file_name`, `disk`, `size`, `manipulations`, `custom_properties`, `order_column`, `created_at`, `updated_at`) VALUES
(11, 1, 'App\\User', 'images', '1465928148_1357', '1465928148_1357.jpg', 'media', 519042, '[]', '[]', 2, '2016-06-14 15:15:51', '2016-06-14 15:15:51'),
(12, 3, 'App\\User', 'images', '1465936423_8553', '1465936423_8553.jpg', 'media', 417608, '[]', '[]', 3, '2016-06-14 17:33:44', '2016-06-14 17:33:44');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Bob', 'bob@ukr.net', '$2y$10$4WvdME2PG9Tinz1hAefjCeJ36uSdEUsNWU8pyQz3HOnIT/wpt2orG', '4zS2cOs5vwdA1nHmP9Dx9xE2Pj23snppDEV0uJmD6YSZZawPbkzsCX2LBscH', '2016-06-07 16:41:58', '2016-06-14 17:31:44', 1),
(2, 'bob name', 'bob2@ukr.net', '$2y$10$ntsxI6dIBfz0ENBKS2Zg4ux.Jp0uEBK0HdiM5Z0WqIMLGGh1pcecG', 'tTpIuNqCDWh9dZ4BjUdeBG4qfnrDuzR45ysV85QSQSrN3GODbjDEgLf3JUSV', '2016-06-08 16:14:59', '2016-06-14 10:31:01', 3),
(3, 'Carl', 'bob3@ukr.net', '$2y$10$GN49lNljawThFNNb62z8.uwR6epvw192/d78UZX57H2twxdET/6ey', '86ePuj33FkZSevcRPOAg0OozIHQDp9Cgka1tJCpVtV4AdpBQx0qVlazE6FT9', '2016-06-14 10:31:29', '2016-06-14 17:33:52', 3);

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
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблиці `categories`
--
ALTER TABLE `categories`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблиці `media`
--
ALTER TABLE `media`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
  ADD CONSTRAINT `FK_comments.article_id__articles.id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `FK_comments.user_id__users.id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
