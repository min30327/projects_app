-- phpMyAdmin SQL Dump
-- version 4.0.10.2
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2014 年 10 月 24 日 20:14
-- サーバのバージョン: 5.1.73
-- PHP のバージョン: 5.5.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `project`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `ws-messages`
--

CREATE TABLE IF NOT EXISTS `ws-messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=125 ;

--
-- テーブルのデータのダンプ `ws-messages`
--

INSERT INTO `ws-messages` (`id`, `project_id`, `user_id`, `date`, `body`, `created`, `modified`) VALUES
(122, 1, 2, '1414065571977', '【JavaScript】 文字列切り出し（slice, substr, substring）の違い\nJavaScript\nf:id:catprogram:20130513221124j:image:w250:right\n\n引っ越し前のサイトから移植しました。\n\n文字列の切り出しっていつも迷うよね。\n\n実際にスクリプトを動かして確認してみよう。\n\nslice\n\n文字列.slice(開始位置 [,終了位置] )\n\n開始位置と終了位置を指定。終了位置は省略可能。\n省略すると最後まで切り出す。\n終了位置は、末尾が0になる。\n開始位置をマイナス値にすると、後からの桁数になる（右端のみ切り出せる）。\n<例> \nstr.slice(3); //"3456789"\nstr.slice(-2); //"89" \nstr.slice(3, -1)); //"345678"\n\nvar str = "0123456789";\nstr.slice(  , );  \nstrの内容 : 結果', '2014-10-23 20:59:41', '2014-10-23 20:59:41'),
(120, 1, 3, '1414049697765', 'asfsf', '2014-10-23 16:10:36', '2014-10-23 16:35:04'),
(107, 1, 2, '1414025903506', 'ｗｗｗｗ', '2014-10-23 09:58:24', '2014-10-23 09:58:24'),
(109, 1, 2, '1414039442275', 'http://192.168.33.10/dev/project_app/projects#!1&p=1 aaaa', '2014-10-23 11:12:46', '2014-10-23 13:44:19'),
(111, 2, 3, '1414045624201', 'sss', '2014-10-23 15:27:05', '2014-10-23 15:27:05'),
(112, 2, 3, '1414049564151', 'aa', '2014-10-23 15:30:42', '2014-10-23 16:32:50'),
(121, 1, 3, '1414053210935', 'aasd', '2014-10-23 17:33:32', '2014-10-23 17:33:32'),
(113, 1, 3, '1414048109491', 'qadsasdgaassdfssfsfsfadfssffssffsa', '2014-10-23 16:03:17', '2014-10-23 16:08:33'),
(116, 1, 3, '1414047944200', 'fas', '2014-10-23 16:05:45', '2014-10-23 16:05:45'),
(117, 1, 3, '1414048089474', 'fsasasdasd', '2014-10-23 16:08:11', '2014-10-23 16:08:11'),
(118, 1, 3, '1414048176360', 'gdggddgg', '2014-10-23 16:09:38', '2014-10-23 16:09:38'),
(119, 2, 3, '1414048222363', 'ad', '2014-10-23 16:10:23', '2014-10-23 16:10:23'),
(104, 1, 2, '1414025815259', 'ああああ', '2014-10-23 09:56:56', '2014-10-23 09:56:56'),
(99, 1, 2, '1413886798000', 'dasdasds\n\nsa\nf\nasgdgdgfdasda', '2014-10-22 17:37:29', '2014-10-22 17:39:21'),
(100, 2, 2, '1413967163682', 'affsdas', '2014-10-22 17:39:25', '2014-10-22 17:39:25'),
(101, 1, 2, '1413967606436', 'gadssf', '2014-10-22 17:46:47', '2014-10-22 17:46:47'),
(102, 1, 2, '1413967647556', 'afsfasdasd', '2014-10-22 17:47:30', '2014-10-22 17:47:30'),
(105, 1, 2, '1414025845128', '本日○○提出です。', '2014-10-23 09:57:51', '2014-10-23 09:57:51'),
(123, 4, 2, '1414068310252', 'ああああ', '2014-10-23 21:45:11', '2014-10-23 21:45:11'),
(124, 6, 2, '1414068453986', 'ffff', '2014-10-23 21:47:35', '2014-10-23 21:47:35');

-- --------------------------------------------------------

--
-- テーブルの構造 `ws-onetime_tokens`
--

CREATE TABLE IF NOT EXISTS `ws-onetime_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `ws-projects`
--

CREATE TABLE IF NOT EXISTS `ws-projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- テーブルのデータのダンプ `ws-projects`
--

INSERT INTO `ws-projects` (`id`, `name`, `data`, `created`, `modified`) VALUES
(1, '株式会社リグナイト', '[{"key":"URL","value":"\\u4f55\\u30c1\\u30e3\\u30e9aas"}]', '2014-10-15 00:00:00', '2014-10-23 21:32:17'),
(2, '松山畳店', '[{"key":"test","value":"testdgfasdsd","order":"1"},{"key":"URL","value":"asfadgdasdsf","order":"5"},{"key":"agagadg","value":"gadg\\u3042\\u3042","order":"6"},{"key":"fffqegqegg","value":"qegq"}]', '2014-10-15 00:00:00', '2014-10-23 21:31:18'),
(4, 'ペットショップ　ピーターパン', '', '2014-10-23 21:44:23', '2014-10-24 13:54:02'),
(5, 'aaaa', '', '2014-10-23 21:46:04', '2014-10-23 21:46:04'),
(6, 'ffff', '', '2014-10-23 21:47:03', '2014-10-23 21:47:35'),
(7, 'ffff', '', '2014-10-23 21:47:40', '2014-10-23 21:47:40');

-- --------------------------------------------------------

--
-- テーブルの構造 `ws-roles`
--

CREATE TABLE IF NOT EXISTS `ws-roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- テーブルのデータのダンプ `ws-roles`
--

INSERT INTO `ws-roles` (`id`, `name`, `created`, `modified`) VALUES
(1, '管理者', '2014-09-16 15:46:47', '2014-09-16 15:46:47');

-- --------------------------------------------------------

--
-- テーブルの構造 `ws-schedules`
--

CREATE TABLE IF NOT EXISTS `ws-schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `completer_id` int(11) DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `completed` int(11) DEFAULT NULL,
  `complete_date` date NOT NULL,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- テーブルのデータのダンプ `ws-schedules`
--

INSERT INTO `ws-schedules` (`id`, `project_id`, `author_id`, `completer_id`, `date`, `completed`, `complete_date`, `title`, `body`, `created`, `modified`) VALUES
(21, 1, 2, NULL, '2014-12-24', 1, '2014-10-23', 'aaa', NULL, '2014-10-23 10:57:58', '2014-10-23 10:57:58'),
(23, 2, 3, NULL, '2014-10-15', 1, '2014-10-24', 'safsfaffsa', NULL, '2014-10-23 17:33:47', '2014-10-23 17:33:47'),
(22, 2, 3, NULL, '2014-10-14', 1, '2014-10-24', 'fsasaf', NULL, '2014-10-23 16:35:27', '2014-10-23 16:35:27'),
(17, 1, 2, NULL, '2014-10-03', 1, '2014-10-23', 'gaagdadgadgdga', NULL, '2014-10-23 10:44:06', '2014-10-23 10:44:06'),
(20, 1, 2, NULL, '2014-10-30', 1, '2014-10-23', 'aaa', NULL, '2014-10-23 10:56:55', '2014-10-23 10:56:55');

-- --------------------------------------------------------

--
-- テーブルの構造 `ws-users`
--

CREATE TABLE IF NOT EXISTS `ws-users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `username` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `passport` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_file_name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover_file_name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- テーブルのデータのダンプ `ws-users`
--

INSERT INTO `ws-users` (`id`, `role_id`, `username`, `password`, `passport`, `name`, `avatar_file_name`, `cover_file_name`, `created`) VALUES
(2, 1, 'mineo.okuda@4digit.jp', '$2a$10$O8z7/Ve8yBAkqAYhNM8IROD0xdfe/3hiKL2wryqJ5UNLIc5AhcYqq', 'cafc1a8ed129f476ea1ed296c811a77a993c5e5a', '奥田峰夫', '201410152bbef61183c07bae963f0c54fefd706a2316.png', '20141015350c0bd4c8f62852986dd6b04c36099c2315.jpeg', '2014-10-14 19:28:26'),
(3, 1, 'min30327@gmail.com', '$2a$10$AyrVXAmxGTaNE9sPMD4/pOPpNs/yft.EXF6Ez65qN7DPe41qzwa.y', '0215eea0d50208113efeb214d36c793f938402da', 'テストユーザー', NULL, NULL, '2014-10-23 14:54:22');

-- --------------------------------------------------------

--
-- テーブルの構造 `ws-users_projects`
--

CREATE TABLE IF NOT EXISTS `ws-users_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
