-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 17 2025 г., 20:47
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lr2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `id_supplier` int(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `cost` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `img_path`, `name`, `id_supplier`, `description`, `cost`) VALUES
(1, '5_1_1.png', 'Серия ГАРАНТ', 1, 'Глубокий почтовый ящик усиленной конструкции серии «Гарант». Корреспонденция располагается в секции горизонтально. Дверца открывается слева направо.', 3919),
(2, '5_1_2.png', 'Серия ГАРАНТ ЛЮКС', 2, 'Почтовый ящик усиленной конструкции серии «Гарант Люкс». Корреспонденция располагается в секции под углом 40 градусов. Дверца открывается слева направо.', 4023),
(3, 'прев-5.png', 'Серия СИГМА', 3, 'Узкий почтовый ящик усиленной конструкции серии «Сигма». Корреспонденция располагается в секции под углом 25 градусов. Дверца открывается снизу вверх. ', 3615),
(4, '5_1.png', 'Серия ОПТИМА', 4, 'Глубокий и удобный почтовый ящик для узких подъездов серии «Оптима». Корреспонденция располагается в секции горизонтально.', 6682),
(5, '5_1_8.png', 'Серия ОРИОН М нержавеющий', 5, 'Почтовые ящики для подъездов многоквартирных домов серии «Орион М» с дверцами из нержавеющей стали. Корреспонденция располагается в секции под углом 30 градусов.', 4467),
(6, '5_1_4.png', 'Серия ОРИОН М', 1, 'Почтовые ящики для подъездов многоквартирных домов серии «Орион М» с задней стенкой. Корреспонденция располагается в секции под углом 30 градусов. «Орион М» имеет нижнюю фальшпанель.', 3724),
(7, '5_1_10.png', 'Серия ОМЕГА нержавеющий', 2, 'Компактные почтовые ящики для подъездов с большим количеством квартир «Омега» с дверцами из нержавеющей стали.', 4523),
(8, '5_1_9.png', 'Серия ОМЕГА', 3, 'Компактные почтовые ящики для подъездов с большим количеством квартир «Омега» Конструкция имеет уменьшенные габариты, что позволяет размещать на небольшом пространстве большее количество ящиков.', 4081),
(9, '5_1_5.png', 'Серия ОРИОН ПРЕСТИЖ М', 4, 'Почтовые ящики для подъездов многоквартирных домов серии «Орион Престиж М» со стеклом и задней стенкой. Корреспонденция располагается в секции под углом 30 градусов.', 4293),
(10, '5_1_7.png', 'Серия ОПТИМА ЛЮКС', 5, 'Компактный и вместительный почтовый ящик для узких подъездов серии «Оптима Люкс». Корреспонденция располагается в секции под углом 50 градусов.', 2686);

-- --------------------------------------------------------

--
-- Структура таблицы `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `namesupplier` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `supplier`
--

INSERT INTO `supplier` (`id`, `namesupplier`) VALUES
(1, 'ferrumformat.com'),
(2, 'mailbox.com'),
(3, 'ящик.ру'),
(4, 'ВИВАС.ру'),
(5, 'metromember.com');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Индексы таблицы `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `supplier_ibfk_1` FOREIGN KEY (`id`) REFERENCES `product` (`id_supplier`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
