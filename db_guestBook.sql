-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.2
-- Время создания: Сен 08 2024 г., 02:43
-- Версия сервера: 8.2.0
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db_guestBook`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `text` text COLLATE utf8mb4_general_ci NOT NULL,
  `date` text COLLATE utf8mb4_general_ci NOT NULL,
  `browser` text COLLATE utf8mb4_general_ci NOT NULL,
  `ip` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `text`, `date`, `browser`, `ip`) VALUES
(38, 'ffffff', 'wewf@dscsdc.ert', 'gggggg', 'Sat Sep 07 2024 21:19:42 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(39, 'qqqq', 'qweqew@fdsdf.rre', 'ewfwef', 'Sat Sep 07 2024 21:21:35 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(40, 'ssss', 'asas@trtrtr.tr', 'dfgdfgdfgfdgfdgdf', 'Sat Sep 07 2024 21:31:15 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(41, 'kkkkk', 'kkkk@qqqq.hg', 'bvbbvbbvb', 'Sat Sep 07 2024 21:40:57 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(43, 'trtrtrtere', 'ererer@wqwqw.ty', 'fawefawefawefawefawefhnawoefhaoweihfboawiehfoawiefoiawhrfrhguerbygueyrboguayedhogfoiaeurhgoiuegoherigheignaodfjkgnoeirugoaieurgoidfnjkgnaoierugoiauerhgo', 'Sat Sep 07 2024 23:00:56 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(45, 'sdfsdfsdf', 'ertet@gerge.wef', 'wfeghwtwhf', 'Sat Sep 07 2024 23:57:13 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(46, 'sdfsdfsdf', 'ertet@gerge.wef', 'tyhjhsfgd', 'Sat Sep 07 2024 23:57:37 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(47, 'sdfsdf', 'sdfsdf@ertert.ytr', 'sdfsdfsdfsfds', 'Sat Sep 07 2024 23:59:53 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(48, 'qweqweqwe', 'werwer@ghjgj.tryry', 'sdfsdfsdfsdf', 'Sun Sep 08 2024 00:02:23 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1'),
(49, 'waraewr', 'tyry@cbvb.ty', 'fghfghfgh', 'Sun Sep 08 2024 00:05:11 GMT+0500 (Екатеринбург, стандартное время)', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '127.0.0.1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
