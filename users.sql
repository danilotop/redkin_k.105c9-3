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
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'danil', '$2y$10$wwYq3Jfpsf9v2nyiUdsaEeXjQ9v1e/Ju0fR17r0nrRvWnkv/xKyRi'),
(2, 'danil', '$2y$10$ebU/HVRPPAfiJxlbhv8/Y.bOIRiDYYyBYt3R1jhpBDzcxwkLhz3H6'),
(3, 'danil', '$2y$10$Qcn0iGWa7glNr/JWIwe8z.rXyrWn3T4oLIrZ9QlogViGpH0uxJmhu'),
(4, 'redkin', '$2y$10$FZyb.VwY78JjX/FKcCpT6edxi41/xAB/tFJURzsBm.XphRBi50ABe'),
(5, 'danil', '$2y$10$bdP83jAsbI9WnDtE.wexteQBSa9.5sbHD7G4IDyXr.fdZVs.oveyu'),
(6, '123', '$2y$10$5Qs4ifu3MONMgE6HQfujI.H2wFOOw1Xqhg4i5kxEa/oyWrg.QlPk2'),
(7, 'dan', '$2y$10$MppBULSc8VsbNoWC6dmURui51Vy05.4ipWgQMOegM8sCR.gb1XtBu'),
(8, '333', '$2y$10$HclTQgajWs9PiWVMCRlxae6f7Ei5IgPoY53nqxPG35iLMiX0EGXkK'),
(9, 'danil', '$2y$10$3f3c3GLRTVtm0X1boaOMseATHPBKYgvBuM/DGR38zhtKRYOrR.evu'),
(27, 'qazwsxedc', '$2y$10$En5IBciyrSUynHlVjVl.JeIqGxx0mckdgEafWbsnDlS4GYxjuiFWi'),
(28, 'zxcvbn', '$2y$10$ktFOjPBlaTtYAdI3Q7pu3O/AsKXxgIveeV5XUjhVe1g1cn7fdgs7G'),
(29, '678678678', '$2y$10$MVo5SCxhZRaI2LOx29z3DeDW6xo4z2VJdFkX79g9CzBMU2X13.Koa'),
(30, 'qwertysasd', '$2y$10$s9q/1ibupiQDB8F2N07T2eWPdWuSyw0sMdRAxWYe.y3EPrpMMGqim'),
(31, 'fghfg', '$2y$10$Ti0TFG/08fxScNSIILihp.ByBOSxr6n5tMxhoN/pDeMAvxbwPDarG'),
(32, 'qaz', '$2y$10$LSAuZUyejwFYD2m3VY9rw.R6X6j6Cg6bsiEl.MCq./V0DIHYKeK.e'),
(33, 'qwaszx', '$2y$10$/.I68ppVHKirp5FLPcppweVvHmNUTSfUmycVcQdF0hsH6CRhQK1ge'),
(34, 'qweasd', '$2y$10$4TBJeXe3aRbBvM2kDvJlgOsiKvFcIuQR.IeMizCJACvRtagYQ1WcC'),
(35, 'ymberto', '$2y$10$pBT4pYyfVpVPhCWafOlmRu6jl8dGlYlUhtrPczTkAI3HLF7FFj7Su'),
(36, 'redki', '$2y$10$DwhMMQ.ZWVmVbIqKMEQcRufbKoy2ENhhdNgr4TXzsbE2WBjRPiHWi'),
(37, 'chmo', '$2y$10$04.fiO.zr6bNUqwXQofhVOBl/hIGGQA1wSNxaWuXmmgP/Qdd9JFNW'),
(38, 'sldfks', '$2y$10$/zEEdB90gvmxEoUlPeEgX.zuEeZ1FpwtE3mITbBgnqcPmCF6n6o4C'),
(39, 'qwertfdv', '$2y$10$x7qYFs5J7I.88WOZ5Yx6h.DILlhUXYhIVOLcHCs9RGuSULF3aKTMq'),
(40, 'edfgdf', '$2y$10$.LFhoFEUHsDrmrLehIqeeeC8VJxyqGJqr2T/hsEidpokQBBHPN7Zq'),
(41, 'Sdfsdf', '$2y$10$cpd.vGKeWpFm5dl.gwin3e91GcbTiEoUBi.N7mgMV2N053kpzfK6.'),
(42, 'asdqwegtdf', '$2y$10$Y/cn.gZ0Z7LRfvyWGwTAduHRvCmzOCaoTkr629MWtjuspUsnD5Wfy'),
(43, 'vcbnhyg', '$2y$10$9/ZqDmGsngNwJ86Me/iF3.gru.uieoKqoF6L6zhcdaM7E7r28CGT.'),
(44, 'redkinsdf', '$2y$10$38Ok.ZJ27u.Z4tDnCiTlteaWVxXgW86jBtR/ZlD3p1OHq/VQpwy1O'),
(45, 'asdfgzxcv', '$2y$10$Cc7UlJUAozYf.94z56iPrOfv10ZchhGjG1NA/vnnOlhzxoDBic3uy'),
(46, 'qwerty', '$2y$10$j97okF6icEQCbnmYtRz4i.oLpSktsAWRy9.y893DzDiYWfNFaQpMi');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
