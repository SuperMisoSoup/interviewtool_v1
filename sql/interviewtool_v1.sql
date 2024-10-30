-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-10-30 16:19:38
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `interviewtool_v1`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `category_table`
--

CREATE TABLE `category_table` (
  `category_id` int(8) NOT NULL,
  `category_type_id` tinyint(4) NOT NULL,
  `description` text DEFAULT NULL,
  `service_url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `category_table`
--

INSERT INTO `category_table` (`category_id`, `category_type_id`, `description`, `service_url`, `created_at`, `deleted_at`, `user_id`) VALUES
(1, 1, 'もっとPV数を増やしたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-10-28 15:47:57', NULL, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `category_type_table`
--

CREATE TABLE `category_type_table` (
  `category_type_id` int(11) NOT NULL,
  `category_type` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `category_type_table`
--

INSERT INTO `category_type_table` (`category_type_id`, `category_type`) VALUES
(1, 'Webページ改善'),
(2, 'クリエイティブのアドバイス'),
(3, 'CX改善');

-- --------------------------------------------------------

--
-- テーブルの構造 `chat_log_table`
--

CREATE TABLE `chat_log_table` (
  `chat_log_id` int(11) NOT NULL,
  `scenario_id` int(11) NOT NULL,
  `interviewee_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `chat_log_order` int(11) NOT NULL,
  `chat_by` int(11) NOT NULL,
  `chat_text` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `interviewee_table`
--

CREATE TABLE `interviewee_table` (
  `interviewee_id` int(11) NOT NULL,
  `sex` tinyint(2) NOT NULL,
  `age` tinyint(2) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `question_table`
--

CREATE TABLE `question_table` (
  `question_id` int(8) NOT NULL,
  `category_id` int(8) NOT NULL,
  `question_text` longtext NOT NULL,
  `delete_flg` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `question_table`
--

INSERT INTO `question_table` (`question_id`, `category_id`, `question_text`, `delete_flg`, `created_at`, `deleted_at`) VALUES
(1, 1, '現在のWebページのPV数をどのように測定していますか？', NULL, '2024-10-29 07:56:28', NULL),
(2, 1, 'あなたにとって、PV数の増加はどのような意味を持ちますか？', NULL, '2024-10-29 07:56:28', NULL),
(3, 1, '訪問者がページに留まるための要因は何だと考えますか？', NULL, '2024-10-29 07:56:28', NULL),
(4, 1, '現在のコンテンツやデザインに関して、どのような改善点があると思いますか？', NULL, '2024-10-29 07:56:28', NULL),
(5, 1, '競合他社のWebページで魅力的だと感じる点は何ですか？', NULL, '2024-10-29 07:56:28', NULL),
(6, 1, '訪問者があなたのWebページを知るために、どのようなルートを利用していますか？', NULL, '2024-10-29 07:56:28', NULL),
(7, 1, 'どのデバイス（PC、スマートフォン、タブレット）でよくアクセスがありますか？', NULL, '2024-10-29 07:56:28', NULL),
(8, 1, 'ユーザーエンゲージメントを高めるために、どのような施策を講じていますか？', NULL, '2024-10-29 07:56:28', NULL),
(9, 1, '訪問者からのフィードバックをどのように活用していますか？', NULL, '2024-10-29 07:56:28', NULL),
(10, 1, 'PV数を向上させるための理想的な戦略やアイデアはありますか？', NULL, '2024-10-29 07:56:28', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `scenario_table`
--

CREATE TABLE `scenario_table` (
  `scenario_id` int(8) NOT NULL,
  `category_id` int(8) NOT NULL,
  `question_order` int(11) NOT NULL,
  `next_question_id` int(11) NOT NULL,
  `rule` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(8) NOT NULL,
  `name` text NOT NULL,
  `email` text DEFAULT NULL,
  `login_id` text NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_flg` tinyint(2) NOT NULL,
  `resigned_flg` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `user_table`
--

INSERT INTO `user_table` (`user_id`, `name`, `email`, `login_id`, `password`, `created_at`, `admin_flg`, `resigned_flg`) VALUES
(4, '高野　宏紀', NULL, 'takano', '$2y$10$5jksUdFD5aiumhFKvJr8I.d.0Bci4yPsmk1wB22a1Va2MCK2ni24u', '2024-10-29 07:43:20', 1, 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `category_table`
--
ALTER TABLE `category_table`
  ADD PRIMARY KEY (`category_id`);

--
-- テーブルのインデックス `category_type_table`
--
ALTER TABLE `category_type_table`
  ADD PRIMARY KEY (`category_type_id`);

--
-- テーブルのインデックス `chat_log_table`
--
ALTER TABLE `chat_log_table`
  ADD PRIMARY KEY (`chat_log_id`);

--
-- テーブルのインデックス `interviewee_table`
--
ALTER TABLE `interviewee_table`
  ADD PRIMARY KEY (`interviewee_id`);

--
-- テーブルのインデックス `question_table`
--
ALTER TABLE `question_table`
  ADD PRIMARY KEY (`question_id`);

--
-- テーブルのインデックス `scenario_table`
--
ALTER TABLE `scenario_table`
  ADD PRIMARY KEY (`scenario_id`);

--
-- テーブルのインデックス `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `category_table`
--
ALTER TABLE `category_table`
  MODIFY `category_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `category_type_table`
--
ALTER TABLE `category_type_table`
  MODIFY `category_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `chat_log_table`
--
ALTER TABLE `chat_log_table`
  MODIFY `chat_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `interviewee_table`
--
ALTER TABLE `interviewee_table`
  MODIFY `interviewee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `question_table`
--
ALTER TABLE `question_table`
  MODIFY `question_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `scenario_table`
--
ALTER TABLE `scenario_table`
  MODIFY `scenario_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
