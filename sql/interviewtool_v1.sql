-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-11-07 08:32:34
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
  `category_type_id` int(11) NOT NULL,
  `service_name` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `service_url` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `category_table`
--

INSERT INTO `category_table` (`category_id`, `category_type_id`, `service_name`, `description`, `service_url`, `created_at`, `deleted_at`, `user_id`) VALUES
(1, 1, NULL, 'もっとPV数を増やしたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-10-28 15:47:57', NULL, 1),
(2, 1, 'チーズアカデミー', 'もっとPV数を増やしたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-05 05:37:46', NULL, 0),
(3, 1, 'チーズアカデミー', 'PV数を稼ぎたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-05 06:14:40', NULL, 0),
(4, 3, 'チーズアカデミー', 'ユーザをワクワクさせたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-05 07:36:03', NULL, 0),
(5, 1, 'チーズアカデミー', '優しい雰囲気にしたいので、利用者がどのような雰囲気を感じているのか調査したい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-07 06:52:54', NULL, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `category_type_table`
--

CREATE TABLE `category_type_table` (
  `category_type_id` int(11) NOT NULL,
  `category_type` text NOT NULL
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
  `chat_log_order` int(11) NOT NULL,
  `chat_by` int(11) NOT NULL,
  `chat_text` int(11) NOT NULL,
  `for_question_id` int(11) NOT NULL,
  `dig_count` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `interviewee_id` int(11) NOT NULL
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
(10, 1, 'PV数を向上させるための理想的な戦略やアイデアはありますか？', NULL, '2024-10-29 07:56:28', NULL),
(11, 2, 'このウェブページを訪れた際の最初の印象はどうでしたか？', NULL, '2024-11-05 05:37:49', NULL),
(12, 2, 'ページの読み込み速度について、どのように感じましたか？', NULL, '2024-11-05 05:37:49', NULL),
(13, 2, 'ウェブページのデザインについて、特に気に入った点や改善が必要だと思う点はありますか？', NULL, '2024-11-05 05:37:49', NULL),
(14, 2, '情報の配置やナビゲーションは使いやすかったですか？それについて具体的に教えてください。', NULL, '2024-11-05 05:37:49', NULL),
(15, 2, 'コンテンツの内容はあなたの期待に応えましたか？どのような内容がもっと欲しいですか？', NULL, '2024-11-05 05:37:49', NULL),
(16, 2, 'ウェブページを使う際にどのデバイスを主に使用していますか？その理由も教えてください。', NULL, '2024-11-05 05:37:49', NULL),
(17, 2, 'このウェブページを他の同様なサイトと比較した場合、どのような印象を持ちましたか？', NULL, '2024-11-05 05:37:49', NULL),
(18, 2, '特に印象に残った要素（画像、テキスト、ボタンなど）はありますか？それはなぜですか？', NULL, '2024-11-05 05:37:49', NULL),
(19, 2, 'サポートや問い合わせの情報は見つけやすかったですか？', NULL, '2024-11-05 05:37:49', NULL),
(20, 2, '今後、このウェブページに追加してほしい機能や情報はありますか？', NULL, '2024-11-05 05:37:49', NULL),
(21, 3, '何歳ですか', NULL, '2024-11-05 06:14:47', NULL),
(22, 3, 'このWebページの全体的なデザインについてどう思いますか？', NULL, '2024-11-05 06:14:47', NULL),
(23, 3, 'コンテンツの分かりやすさについて、どのように感じましたか？', NULL, '2024-11-05 06:14:47', NULL),
(24, 3, 'ナビゲーションは使いやすいと感じましたか？それはなぜですか？', NULL, '2024-11-05 06:14:47', NULL),
(25, 3, '特定の情報を探すのは簡単でしたか？もし難しい場合、どのような点が影響していましたか？', NULL, '2024-11-05 06:14:47', NULL),
(26, 3, 'あなたがこのWebページに期待する主な機能は何ですか？', NULL, '2024-11-05 06:14:47', NULL),
(27, 3, 'ページの読み込み速度についてどう感じましたか？', NULL, '2024-11-05 06:14:47', NULL),
(28, 3, 'モバイルデバイスで閲覧したときの体験はどうでしたか？', NULL, '2024-11-05 06:14:47', NULL),
(29, 3, '競合他社のWebページと比較して、このページの強みや弱みは何だと思いますか？', NULL, '2024-11-05 06:14:47', NULL),
(30, 3, '改善してほしい点や追加してほしい機能があれば教えてください。', NULL, '2024-11-05 06:14:47', NULL),
(31, 4, 'このウェブサイトを訪れた理由は何ですか？', NULL, '2024-11-05 07:36:06', NULL),
(32, 4, 'サイト内で情報を探す際に、どのような体験をしましたか？', NULL, '2024-11-05 07:36:06', NULL),
(33, 4, 'ページの読み込み速度について、どのように感じましたか？', NULL, '2024-11-05 07:36:06', NULL),
(34, 4, 'サイトのデザインやレイアウトについて、どう思いますか？', NULL, '2024-11-05 07:36:06', NULL),
(35, 4, '情報を見つけやすかったですか？それとも難しかったですか？', 1, '2024-11-05 07:36:06', NULL),
(36, 4, '特に印象に残ったコンテンツや機能はありましたか？', NULL, '2024-11-05 07:36:06', NULL),
(37, 4, '他の類似サイトと比べて、このサイトの使いやすさはいかがでしたか？', NULL, '2024-11-05 07:36:06', NULL),
(38, 4, 'フィードバックを提供する機能があった場合、利用されましたか？', NULL, '2024-11-05 07:36:06', NULL),
(39, 4, 'このサイトでの体験を改善するために、どのような提案がありますか？', NULL, '2024-11-05 07:36:06', NULL),
(40, 4, '今後、このサイトにどのような機能や情報を追加してほしいですか？', NULL, '2024-11-05 07:36:06', NULL),
(41, 5, 'このWebページを最初に訪れたときの印象はどうでしたか？', NULL, '2024-11-07 06:52:58', NULL),
(42, 5, 'ページの読み込み速度に満足していますか？それはなぜですか？', NULL, '2024-11-07 06:52:58', NULL),
(43, 5, '情報が分かりやすいと感じましたか？改善点があれば教えてください。', NULL, '2024-11-07 06:52:58', NULL),
(44, 5, 'ナビゲーションはスムーズでしたか？特に使いづらい部分があれば教えてください。', NULL, '2024-11-07 06:52:58', NULL),
(45, 5, 'このWebページのデザインについてどう思いますか？好みの部分や改善点は何ですか？', NULL, '2024-11-07 06:52:58', NULL),
(46, 5, '必要な情報を見つけるのに時間がかかりましたか？どの部分でそう感じましたか？', NULL, '2024-11-07 06:52:58', NULL),
(47, 5, 'モバイルデバイスでの閲覧は快適でしたか？改善が必要だと思う部分はありますか？', NULL, '2024-11-07 06:52:58', NULL),
(48, 5, 'このページを友人や同僚に推薦しますか？その理由は何ですか？', NULL, '2024-11-07 06:52:58', NULL),
(49, 5, '他の競合Webサイトと比べて、ここは優れている点、または劣っている点は何だと思いますか？', NULL, '2024-11-07 06:52:58', NULL),
(50, 5, 'このページの改善のために、具体的な提案があれば教えてください。', NULL, '2024-11-07 06:52:58', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `scenario_table`
--

CREATE TABLE `scenario_table` (
  `scenario_id` int(8) NOT NULL,
  `category_id` int(8) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_order` int(11) NOT NULL,
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
(4, '高野　宏紀', NULL, 'takano', '$2y$10$5jksUdFD5aiumhFKvJr8I.d.0Bci4yPsmk1wB22a1Va2MCK2ni24u', '2024-10-29 07:43:20', 1, 0),
(5, '管理者', NULL, 'kanri', '$2y$10$cGv.AuRLIU4GG/LEJ6HMD.rscNlbYtpbmpOUKvoW2WadvZ13qCLC2', '2024-11-07 06:51:32', 1, 0),
(6, '一般ユーザ', NULL, 'user', '$2y$10$XGK50fVfCXZrirLDuHN3deL/F4zgPd8qjEfBT9iQ8X3PZBgb1MjqC', '2024-11-07 06:51:43', 0, 0);

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
  MODIFY `category_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `question_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- テーブルの AUTO_INCREMENT `scenario_table`
--
ALTER TABLE `scenario_table`
  MODIFY `scenario_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
