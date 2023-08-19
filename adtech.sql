-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3400
-- Время создания: Авг 18 2023 г., 20:41
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `adtech`
--

-- --------------------------------------------------------

--
-- Структура таблицы `day`
--

CREATE TABLE `day` (
  `hour` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `day`
--

INSERT INTO `day` (`hour`) VALUES
(0),
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23);

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE `links` (
  `id` int NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `master_id` int NOT NULL,
  `offer_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `links`
--

INSERT INTO `links` (`id`, `time`, `master_id`, `offer_id`) VALUES
(1, '2023-08-14 18:46:23', 3, 1),
(2, '2023-08-15 03:21:25', 3, 1),
(3, '2023-08-15 03:21:25', 3, 1),
(4, '2023-08-15 03:54:42', 3, 4),
(5, '2023-08-17 19:22:34', 6, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `master_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `offer_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `time`, `master_id`, `customer_id`, `offer_id`, `status`) VALUES
(1, '2023-01-06 18:25:25', 3, 2, 1, 1),
(2, '2023-02-06 16:49:04', 4, 2, 2, 1),
(3, '2023-08-14 12:27:05', 3, 2, 1, 0),
(4, '2023-03-10 17:54:37', 3, 2, 3, 1),
(5, '2023-04-02 17:54:37', 3, 2, 3, 1),
(6, '2023-05-11 17:55:24', 3, 2, 1, 1),
(7, '2023-06-16 17:55:24', 3, 2, 1, 1),
(8, '2023-07-01 17:55:55', 3, 2, 3, 1),
(9, '2023-07-26 17:55:55', 3, 2, 1, 1),
(10, '2023-08-02 09:56:52', 3, 2, 1, 1),
(11, '2023-08-03 10:56:52', 3, 2, 2, 0),
(12, '2023-08-15 16:57:42', 3, 2, 1, 1),
(13, '2023-08-15 17:57:42', 3, 2, 1, 1),
(14, '2023-08-18 08:22:28', 3, 2, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `month`
--

CREATE TABLE `month` (
  `day` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `month`
--

INSERT INTO `month` (`day`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31);

-- --------------------------------------------------------

--
-- Структура таблицы `offers`
--

CREATE TABLE `offers` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `url` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `offers`
--

INSERT INTO `offers` (`id`, `customer_id`, `name`, `price`, `url`, `keywords`, `status`) VALUES
(1, 2, 'Фитнес', 2.5, 'www.fitnes.ru', 'фитнес спорт зож', 1),
(2, 2, 'Магазин Корзинка', 1, 'www.korz.ru', 'продукты еда', 0),
(3, 2, 'Кофе доставка', 1.2, 'www.coffe.ru', 'кофе еда', 1),
(4, 2, 'Грузчики 24*7', 1.9, 'www.gruz555.com', 'груз доставка', 1),
(5, 2, 'Гайка онлайн', 2.3, 'www.gaika.com', 'крепеж метиз', 0),
(6, 2, 'Булко', 1.26, 'www.bul.co', 'еда', 0),
(7, 2, 'Пышко', 2, 'www.pusk.co', 'еда', 1),
(8, 2, 'Чашко', 2.2, 'www.cha.sha', 'посуда', 1),
(9, 2, 'Рожко', 1.55, 'www.roj.co', 'рога копыта', 1),
(11, 2, 'Дорожко', 3.2, 'www.doroj.co', 'дорога', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `master_id` int NOT NULL,
  `offer_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `master_id`, `offer_id`, `status`) VALUES
(1, 3, 1, 1),
(2, 3, 3, 1),
(3, 3, 4, 1),
(4, 4, 1, 1),
(5, 4, 3, 1),
(6, 4, 2, 1),
(23, 6, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `verified` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `resettable` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask` int UNSIGNED NOT NULL DEFAULT '0',
  `registered` int UNSIGNED NOT NULL,
  `last_login` int UNSIGNED DEFAULT NULL,
  `force_logout` mediumint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`) VALUES
(1, 'a@a.com', '$2y$10$8sRgjfPcsw6H6g7pxH.xlORaTurIBeWyEm77NRANNRBUmDaG.IQKS', 'Admin', 0, 1, 1, 1, 1690880372, 1692300111, 0),
(2, 'b@b.com', '$2y$10$FAmpLDBzxOhaJ./3bfYgq.nnfUWDHpElo0YS5huAlgLVA6x2zAunS', 'Tetra', 0, 1, 1, 163856, 1690886471, 1692300176, 0),
(3, 'c@c.com', '$2y$10$OUYoazgFxR6GQwUomN9Cqeq5gF8h.sQ5I6c7cJxXq.aj5uYiqqRRS', 'Alfa', 0, 1, 1, 131090, 1690891278, 1692038697, 0),
(4, 'd@d.com', '$2y$10$BC4.V0Si3sdgL6/5aOGsqOWVc/kWji6pttSf3M9J6oq5L15tpqfOG', 'Nan', 0, 1, 1, 131090, 1691300702, 1692299193, 0),
(5, 'q@a.com', '$2y$10$0bzGOkz3pR8.PA/7hlBEBOCh8rqJnywoytxtH5boGiu8glvlzHr2.', 'Qiqi', 0, 1, 1, 0, 1691317424, 1692335771, 0),
(6, 'e@e.com', '$2y$10$yfpDyf1e7UhqR9A92bhi9O2kxbwwRWODSYLUm/9VC0mpTRLWX5mfa', 'Nike', 0, 1, 1, 131090, 1692299349, 1692300144, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_confirmations`
--

CREATE TABLE `users_confirmations` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_remembered`
--

CREATE TABLE `users_remembered` (
  `id` bigint UNSIGNED NOT NULL,
  `user` int UNSIGNED NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_resets`
--

CREATE TABLE `users_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `user` int UNSIGNED NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users_throttling`
--

CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float UNSIGNED NOT NULL,
  `replenished_at` int UNSIGNED NOT NULL,
  `expires_at` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_throttling`
--

INSERT INTO `users_throttling` (`bucket`, `tokens`, `replenished_at`, `expires_at`) VALUES
('QduM75nGblH2CDKFyk0QeukPOwuEVDAUFE54ITnHM38', 74, 1692335771, 1692875771),
('PZ3qJtO_NLbJfRIP-8b4ME4WA3xxc6n9nbCORSffyQ0', 4, 1692299349, 1692731349),
('OMhkmdh1HUEdNPRi-Pe4279tbL5SQ-WMYf551VVvH8U', 19, 1692258486, 1692294486),
('2oeo8WJMkKMNsGkf4DTpiq5kjSC_OKBGW6eYi-5wxjw', 499, 1692078514, 1692251314),
('--DpkQdTE21qonY7l7n0PX5JU0a5dXIOJ94Tk37Hvnc', 499, 1692258486, 1692431286);

-- --------------------------------------------------------

--
-- Структура таблицы `year`
--

CREATE TABLE `year` (
  `month` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `year`
--

INSERT INTO `year` (`month`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `day`
--
ALTER TABLE `day`
  ADD UNIQUE KEY `hour` (`hour`);

--
-- Индексы таблицы `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `month`
--
ALTER TABLE `month`
  ADD KEY `day` (`day`);

--
-- Индексы таблицы `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `users_confirmations`
--
ALTER TABLE `users_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `email_expires` (`email`,`expires`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users_remembered`
--
ALTER TABLE `users_remembered`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users_resets`
--
ALTER TABLE `users_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user_expires` (`user`,`expires`);

--
-- Индексы таблицы `users_throttling`
--
ALTER TABLE `users_throttling`
  ADD PRIMARY KEY (`bucket`),
  ADD KEY `expires_at` (`expires_at`);

--
-- Индексы таблицы `year`
--
ALTER TABLE `year`
  ADD UNIQUE KEY `month` (`month`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `links`
--
ALTER TABLE `links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users_confirmations`
--
ALTER TABLE `users_confirmations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_remembered`
--
ALTER TABLE `users_remembered`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users_resets`
--
ALTER TABLE `users_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
