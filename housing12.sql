-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 20-09-04 04:22
-- 서버 버전: 10.4.11-MariaDB
-- PHP 버전: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `housing12`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `expert_reviews`
--

CREATE TABLE `expert_reviews` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `contents` text NOT NULL,
  `price` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `knowhows`
--

CREATE TABLE `knowhows` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `contents` text NOT NULL,
  `before_img` varchar(30) NOT NULL,
  `after_img` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `knowhow_reviews`
--

CREATE TABLE `knowhow_reviews` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `kid` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `contents` text NOT NULL,
  `start_date` date NOT NULL,
  `sid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_id` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `photo` varchar(30) NOT NULL,
  `auth` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_id`, `password`, `photo`, `auth`) VALUES
(22, '전문가1', 'specialist1', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'specialist1.jpg', 1),
(23, '전문가2', 'specialist2', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'specialist2.jpg', 1),
(24, '전문가3', 'specialist3', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'specialist3.jpg', 1),
(25, '전문가4', 'specialist4', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'specialist4.jpg', 1),
(26, '관리자', 'admin', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'specialist3.jpg', 0);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `expert_reviews`
--
ALTER TABLE `expert_reviews`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `knowhows`
--
ALTER TABLE `knowhows`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `knowhow_reviews`
--
ALTER TABLE `knowhow_reviews`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `expert_reviews`
--
ALTER TABLE `expert_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 테이블의 AUTO_INCREMENT `knowhows`
--
ALTER TABLE `knowhows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 테이블의 AUTO_INCREMENT `knowhow_reviews`
--
ALTER TABLE `knowhow_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 테이블의 AUTO_INCREMENT `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
