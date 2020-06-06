-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 06 2020 г., 16:30
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vkr`
--

-- --------------------------------------------------------

--
-- Структура таблицы `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `doc_type` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `check_answer` text NOT NULL DEFAULT 'не проверено',
  `positive` tinyint(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `document`
--

INSERT INTO `document` (`id`, `doc_type`, `project_id`, `check_answer`, `positive`) VALUES
(1, 1, 1, 'Не проверено', 2),
(2, 2, 1, 'Не проверено', 2),
(3, 3, 1, 'Не проверено', 2),
(4, 4, 1, 'Не проверено', 2),
(5, 5, 1, 'Проверено', 0),
(6, 6, 1, 'Проверено', 0),
(7, 1, 2, 'Не проверено', 2),
(8, 2, 2, '123', 1),
(9, 3, 2, 'Не проверено', 2),
(10, 4, 2, '123', 1),
(11, 5, 2, '123', 1),
(12, 6, 2, '123', 1),
(14, 1, 3, '123', 1),
(15, 2, 3, '123', 1),
(16, 3, 3, '123', 1),
(17, 4, 3, '123', 1),
(18, 5, 3, '123', 1),
(19, 6, 3, '123', 1),
(20, 1, 4, 'не проверено', 2),
(21, 2, 4, 'не проверено', 2),
(22, 3, 4, 'не проверено', 2),
(23, 4, 4, 'не проверено', 2),
(24, 5, 4, 'не проверено', 2),
(25, 6, 4, 'не проверено', 2),
(26, 1, 5, 'нет файла', 1),
(27, 2, 5, 'Проверено', 0),
(28, 3, 5, 'Проверено', 0),
(29, 4, 5, 'Проверено', 0),
(30, 5, 5, 'не проверено', 2),
(31, 6, 5, 'не проверено', 2),
(32, 1, 6, 'не проверено', 2),
(33, 2, 6, 'не проверено', 2),
(34, 3, 6, 'не проверено', 2),
(35, 4, 6, 'не проверено', 2),
(36, 5, 6, 'не проверено', 2),
(37, 6, 6, 'не проверено', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `path` text NOT NULL,
  `uploaded` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `file`
--

INSERT INTO `file` (`id`, `document_id`, `path`, `uploaded`) VALUES
(171, 3, '1Лапутина_doc3_3.docx', '2020-06-06 17:28:52'),
(172, 3, '1Лапутина_doc3_4.docx', '2020-06-06 17:29:57'),
(173, 3, '1Лапутина_doc3_5.jpeg', '2020-06-06 17:29:57'),
(174, 3, '1Лапутина_doc3_6.jpeg', '2020-06-06 17:29:57');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'КМБО-02-19'),
(2, 'КММО-01-10'),
(3, 'КМБО-05-19');

-- --------------------------------------------------------

--
-- Структура таблицы `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `oper_type` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `oper_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `operation`
--

INSERT INTO `operation` (`id`, `oper_type`, `file_id`, `oper_time`) VALUES
(1, 1, 1, '2020-03-25 19:28:06');

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `document1_id` int(11) NOT NULL,
  `document2_id` int(11) NOT NULL,
  `document3_id` int(11) NOT NULL,
  `document4_id` int(11) NOT NULL,
  `document5_id` int(11) NOT NULL,
  `document6_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`id`, `document1_id`, `document2_id`, `document3_id`, `document4_id`, `document5_id`, `document6_id`, `student_id`) VALUES
(1, 1, 2, 3, 4, 5, 6, 1),
(2, 7, 8, 9, 10, 11, 12, 2),
(3, 14, 15, 16, 17, 18, 19, 3),
(4, 20, 21, 22, 23, 24, 25, 4),
(5, 26, 27, 28, 29, 30, 31, 5),
(6, 32, 33, 34, 35, 36, 37, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `date` datetime DEFAULT NULL,
  `register` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `first_name`, `middle_name`, `last_name`, `date`, `register`) VALUES
(1, 'Дарья', 'Лапутина', 'Кирилловна', '2020-05-03 12:00:00', 1),
(2, 'Александра', 'Лешану', '', '2020-05-30 13:00:00', 0),
(3, 'Кирилл', 'Погнерыбко', '', '2020-05-30 14:00:00', 0),
(4, 'Дзерасса', 'Кодзасова', '', '2020-05-15 16:00:00', 0),
(5, 'Ирина', 'Патрикеева', '', NULL, 0),
(6, 'Сергей', 'Тест', '', '2020-02-03 13:13:43', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `students_to_group`
--

CREATE TABLE `students_to_group` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `students_to_group`
--

INSERT INTO `students_to_group` (`id`, `student_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 2),
(5, 5, 2),
(6, 6, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students_to_group`
--
ALTER TABLE `students_to_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `document`
--
ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT для таблицы `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `students_to_group`
--
ALTER TABLE `students_to_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
