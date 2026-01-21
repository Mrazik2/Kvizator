-- Adminer 5.4.1 MariaDB 12.1.2-MariaDB-ubu2404 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

INSERT INTO `answers` (`id`, `attemptId`, `number`, `chosen`, `correct`) VALUES
(1,	1,	1,	2,	0),
(2,	1,	2,	2,	1),
(3,	1,	3,	1,	0),
(4,	2,	1,	3,	1),
(5,	2,	2,	1,	0),
(6,	2,	3,	3,	1),
(7,	3,	1,	2,	0),
(8,	3,	2,	1,	1),
(9,	3,	3,	2,	0),
(10,	4,	1,	1,	1),
(11,	4,	2,	1,	1),
(12,	4,	3,	4,	1),
(13,	5,	1,	1,	0),
(14,	5,	2,	1,	0),
(15,	5,	3,	1,	0);

INSERT INTO `attempts` (`id`, `userId`, `quizId`, `correctCount`) VALUES
(1,	2,	1,	1),
(2,	NULL,	1,	2),
(3,	NULL,	2,	1),
(4,	3,	2,	3),
(5,	3,	1,	0);

INSERT INTO `likes` (`id`, `quizId`, `userId`) VALUES
(1,	1,	2),
(2,	2,	3);

INSERT INTO `questions` (`id`, `number`, `question`, `answer1`, `answer2`, `answer3`, `answer4`, `answer`, `quizId`) VALUES
(1,	1,	'Aka mrkva je najlepsia?',	'Cista',	'Velka',	'Cerstva',	'Oranzova',	3,	1),
(2,	2,	'Ako sa volam?',	'Jozko Mrkva',	'Jozef Mrkvička',	'',	'',	2,	1),
(3,	3,	'Posledna otazka.',	'Ahoj',	'Uvidime sa',	'Dovidenia',	'',	3,	1),
(4,	1,	'Ako sa vola tvorca kvizu?',	'Hrac1',	'1Hrac',	'Hr3c',	'',	1,	2),
(5,	2,	'Ake cislo ma tvorca v mene?',	'1',	'2',	'3',	'16',	1,	2),
(6,	3,	'Kolko je 2 krat 2?',	'12',	'76',	'6',	'2 na druhu',	4,	2),
(7,	1,	'1 + 2 = ?',	'1',	'3',	'2',	'12',	2,	3),
(8,	2,	'2 * 4 = ?',	'17',	'12',	'8',	'7',	3,	3),
(9,	3,	'Logaritmus cisla 16 pri zaklade 2?',	'8',	'4',	'16',	'2',	2,	3),
(10,	4,	'Suma postupnosti s 50 prvkami zacinajuca cislo 12 a d = 3?',	'neviem :(',	'vela',	'4275',	'malo',	3,	3);

INSERT INTO `quizzes` (`id`, `title`, `description`, `topic`, `difficulty`, `published`, `creatorId`, `questionCount`) VALUES
(1,	'Jozko',	'Kviz o mrkvach',	'Mrkvy',	'medium',	1,	1,	3),
(2,	'Moj prvy kviz',	'Toto je moj prvy kviz',	'Zoznamovanie',	'easy',	1,	2,	3),
(3,	'Tazka matika',	'Velmi tazke',	'Matematika',	'hard',	1,	3,	4);

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1,	'Jozko',	'$2y$10$gQRgTdonOANYspCgiS4qveBqmCX5VVh0Q9jh6rddU1igaVBXB2OZy'),
(2,	'Hrac1',	'$2y$10$/ofb9nfUtM9ZDWooVsiPl.wxa2oE6DiJ.EpS0QJ6Vy5x3Be1oO992'),
(3,	'Druhy',	'$2y$10$QNhrOAJ9Krj.KxjajWji5uEL/jXCqYCaWp8Dy5PnV067i.4MqNifa');

-- 2026-01-21 16:43:13 UTC
