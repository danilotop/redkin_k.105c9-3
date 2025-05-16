-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 16 2025 г., 19:46
-- Версия сервера: 8.0.19
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pm09`
--

-- --------------------------------------------------------

--
-- Структура таблицы `achievements`
--

CREATE TABLE `achievements` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `achievement_text` text NOT NULL,
  `achievement_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `achievements`
--

INSERT INTO `achievements` (`id`, `user_id`, `achievement_text`, `achievement_date`) VALUES
(10, 8, 'я ем железо', '2025-04-01 22:09:31'),
(19, 6, '123', '2025-05-12 21:30:51'),
(20, 6, '123', '2025-05-12 21:32:16'),
(21, 27, 'qweqwe', '2025-05-12 21:58:54'),
(22, 33, '123', '2025-05-12 22:13:56'),
(24, 34, 'дада', '2025-05-12 22:15:23'),
(26, 37, 'не ел 3 года, за это время набрал 5 тонн', '2025-05-13 15:38:43'),
(27, 27, 'qazwsxedc', '2025-05-14 15:30:13'),
(28, 27, 'qazwsxedc', '2025-05-14 15:33:33'),
(29, 38, 'sldfks', '2025-05-14 17:52:35'),
(30, 6, '123123', '2025-05-16 15:47:01'),
(31, 44, 'dfgdfg', '2025-05-16 19:04:32'),
(32, 45, 'dfsdf', '2025-05-16 23:31:13'),
(33, 46, 'qwerty', '2025-05-16 23:39:08'),
(34, 46, 'asd', '2025-05-16 23:42:01');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `achievements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
