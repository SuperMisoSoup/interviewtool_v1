-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-11-24 18:32:32
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
  `service_name` text DEFAULT NULL,
  `service_url` text DEFAULT NULL,
  `core_purpose` text DEFAULT NULL,
  `core_issue` text NOT NULL COMMENT 'コア課題',
  `service_feature` text NOT NULL COMMENT 'サービスの特徴',
  `competition` text NOT NULL COMMENT '競合サービス',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `category_table`
--

INSERT INTO `category_table` (`category_id`, `category_type_id`, `service_name`, `service_url`, `core_purpose`, `core_issue`, `service_feature`, `competition`, `created_at`, `deleted_at`, `user_id`) VALUES
(1, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'もっとPV数を増やしたい', '', '', '', '2024-10-28 15:47:57', NULL, 1),
(12, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'PV数を改善したい', '', '', '', '2024-11-03 03:42:52', NULL, 1),
(55, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'PV数を改善したい', '', '', '', '2024-11-03 17:47:57', NULL, 1),
(57, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'PV数を改善したい', '', '', '', '2024-11-03 18:00:26', NULL, 0),
(58, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'PV数を改善したい', '', '', '', '2024-11-03 18:01:08', NULL, 0),
(59, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'PV数を稼ぎたい', '', '', '', '2024-11-04 02:38:10', NULL, 0),
(60, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '明るいサイトにしたい', '', '', '', '2024-11-07 14:50:11', NULL, 0),
(61, 2, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '楽しい雰囲気にしたい', '', '', '', '2024-11-07 15:08:23', NULL, 0),
(62, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '', '', '', '', '2024-11-09 02:13:46', NULL, 0),
(63, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'バリバリにしたい', '', '', '', '2024-11-10 00:23:01', NULL, 0),
(64, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'ムキムキにしたい', '', '', '', '2024-11-10 07:55:16', NULL, 0),
(65, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '滑らかにしたい', '', '', '', '2024-11-11 15:36:30', NULL, 0),
(66, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '', '', '', '', '2024-11-18 14:31:05', NULL, 0),
(67, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'さわやかな印象にしたい', '', '', '', '2024-11-20 23:11:26', NULL, 0),
(68, 1, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', 'あったかくしたい', '', '', '', '2024-11-21 04:12:02', NULL, 0),
(69, 3, 'チーズアカデミー', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '目的テスト', '特徴テスト', '課題テスト', '競合テスト', '2024-11-24 17:03:21', NULL, 0),
(70, 3, 'dポイント', '', 'ユーザーの普段のサービス利用方法、使い方の解像度を上げたい', 'ポイントサービスとして多数の加盟店を保有しており、経済圏を構築できている', 'ポイントのアクティブユーザーを増やしたい', '楽天ポイント、Vポイント、Paypayポイント', '2024-11-24 17:20:59', NULL, 0),
(71, 3, 'dポイント', '', 'ユーザーの普段のサービス利用方法、使い方の解像度を上げたい', 'ポイントサービスとして多数の加盟店を保有しており、経済圏を構築できている', 'ポイントのアクティブユーザーを増やしたい', '楽天ポイント、Vポイント、Paypayポイント', '2024-11-24 17:23:42', NULL, 0),
(72, 3, 'dポイント', '', 'ユーザーの普段のサービス利用方法、使い方の解像度を上げたい', 'ポイントのアクティブユーザーを増やしたい', 'ポイントサービスとして多数の加盟店を保有しており、経済圏を構築できている', '楽天ポイント、Vポイント、Paypayポイント', '2024-11-24 17:30:05', NULL, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `category_target_table`
--

CREATE TABLE `category_target_table` (
  `category_target_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `target_type_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `category_target_table`
--

INSERT INTO `category_target_table` (`category_target_id`, `category_id`, `target_type_id`, `target_id`) VALUES
(1, 69, 1, 3),
(2, 69, 1, 4),
(3, 69, 2, 2),
(4, 70, 1, 3),
(5, 70, 1, 4),
(6, 70, 2, 2),
(7, 71, 1, 4),
(8, 71, 1, 5),
(9, 71, 2, 1),
(10, 71, 2, 2),
(11, 72, 1, 4),
(12, 72, 1, 5),
(13, 72, 2, 1),
(14, 72, 2, 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `category_type_table`
--

CREATE TABLE `category_type_table` (
  `category_type_id` int(11) NOT NULL,
  `category_type` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `image_tag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `category_type_table`
--

INSERT INTO `category_type_table` (`category_type_id`, `category_type`, `description`, `image_tag`) VALUES
(1, 'Webページ改善', 'URLと目的を記載するだけで魅力的なWebページにするためのヒントを得ることができます', '<path d=\"M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1\" /><path d=\"M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm13 2v2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1M2 14a1 1 0 0 1-1-1V6h14v7a1 1 0 0 1-1 1z\" />'),
(2, 'クリエイティブのアドバイス', 'ターゲットの心に響く効果的なクリエイティブのためのヒントを得ることができます', '<path d=\"M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3\" /><path d=\"M14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM4 1a1 1 0 0 0-1 1v10l2.224-2.224a.5.5 0 0 1 .61-.075L8 11l2.157-3.02a.5.5 0 0 1 .76-.063L13 10V4.5h-2A1.5 1.5 0 0 1 9.5 3V1z\" />'),
(3, 'インサイト調査', 'サービス利用者のインサイトを深く掘り下げることで顧客の潜在的なニーズを可視化します', '<path d=\"M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105\" /><path d=\"M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8m0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5\" />');

-- --------------------------------------------------------

--
-- テーブルの構造 `chat_log_table`
--

CREATE TABLE `chat_log_table` (
  `chat_log_id` int(11) NOT NULL,
  `chat_log_order` int(11) NOT NULL,
  `chat_by` char(16) NOT NULL,
  `chat_text` text NOT NULL,
  `for_question_id` int(11) NOT NULL,
  `dig_count` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `interviewee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `chat_log_table`
--

INSERT INTO `chat_log_table` (`chat_log_id`, `chat_log_order`, `chat_by`, `chat_text`, `for_question_id`, `dig_count`, `created_at`, `interviewee_id`) VALUES
(164, 1, 'assistant', 'ウェブページのデザインについて、どのように感じましたか？', 143, 0, '2024-11-21 07:03:57', 0),
(165, 2, 'user', 'いいっすよ', 143, 0, '2024-11-21 07:04:04', 0),
(166, 3, 'assistant', 'ありがとうございます！それでは、具体的にどのようなお話をしたいですか？何か特定のトピックがありますか？', 143, 1, '2024-11-21 07:04:05', 0),
(167, 4, 'user', 'おいっす！', 143, 1, '2024-11-21 07:04:07', 0),
(168, 5, 'assistant', 'おいっす！最近の出来事や興味のあることについて教えてもらえますか？', 143, 2, '2024-11-21 07:04:08', 0),
(169, 6, 'user', 'M', 143, 2, '2024-11-21 07:04:13', 0),
(170, 7, 'assistant', 'このウェブページを訪れた際の最初の印象は何でしたか？', 142, 0, '2024-11-21 07:04:17', 0),
(171, 8, 'user', 'MFゴーストみたい。MFゴースト好きやねん', 142, 0, '2024-11-21 07:04:26', 0),
(172, 9, 'assistant', 'MFゴーストが好きなんですね！どの部分が特に気に入っていますか？ストーリー、キャラクター、アクションなど、具体的に教えてもらえると嬉しいです。', 142, 1, '2024-11-21 07:04:27', 0),
(173, 10, 'user', '車が早いっす', 142, 1, '2024-11-21 07:04:35', 0),
(174, 11, 'assistant', '早い車の魅力についてもう少し詳しく教えてもらえますか？具体的にどの車種やシーンが印象に残っていますか？', 142, 2, '2024-11-21 07:04:36', 0),
(175, 12, 'user', '86じゃな', 142, 2, '2024-11-21 07:04:44', 0),
(176, 1, 'assistant', 'ウェブページのデザインについて、どのように感じましたか？', 143, 0, '2024-11-21 07:52:15', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `interviewee_table`
--

CREATE TABLE `interviewee_table` (
  `interviewee_id` int(11) NOT NULL,
  `gender` tinyint(2) NOT NULL,
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
  `question_order` int(11) NOT NULL DEFAULT 0,
  `delete_flg` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `question_table`
--

INSERT INTO `question_table` (`question_id`, `category_id`, `question_text`, `question_order`, `delete_flg`, `created_at`, `deleted_at`) VALUES
(1, 1, '現在のWebページのPV数をどのように測定していますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(2, 1, 'あなたにとって、PV数の増加はどのような意味を持ちますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(3, 1, '訪問者がページに留まるための要因は何だと考えますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(4, 1, '現在のコンテンツやデザインに関して、どのような改善点があると思いますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(5, 1, '競合他社のWebページで魅力的だと感じる点は何ですか？', 0, 0, '2024-10-29 07:56:28', NULL),
(6, 1, '訪問者があなたのWebページを知るために、どのようなルートを利用していますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(7, 1, 'どのデバイス（PC、スマートフォン、タブレット）でよくアクセスがありますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(8, 1, 'ユーザーエンゲージメントを高めるために、どのような施策を講じていますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(9, 1, '訪問者からのフィードバックをどのように活用していますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(10, 1, 'PV数を向上させるための理想的な戦略やアイデアはありますか？', 0, 0, '2024-10-29 07:56:28', NULL),
(11, 12, 'このウェブページを訪れる前に、どのような情報を探していましたか？', 0, 0, '2024-11-03 03:42:54', NULL),
(12, 12, 'ウェブページにアクセスした際の最初の印象はどうでしたか？', 0, 0, '2024-11-03 03:42:54', NULL),
(13, 12, 'HTMLやCSSに関するコンテンツはどの程度理解していますか？', 0, 0, '2024-11-03 03:42:54', NULL),
(14, 12, 'このページを閲覧することで、期待した情報は得られましたか？', 0, 0, '2024-11-03 03:42:54', NULL),
(15, 12, 'このウェブページで特に関心を持ったセクションはどれですか？その理由は？', 0, 0, '2024-11-03 03:42:54', NULL),
(16, 12, 'サイトのナビゲーションの使いやすさについてどう思いますか？改善点はありますか？', 0, 0, '2024-11-03 03:42:54', NULL),
(17, 12, 'ページのデザインやレイアウトについて、どのような印象を持っていますか？', 0, 0, '2024-11-03 03:42:54', NULL),
(18, 12, 'ウェブページで発見した問題やエラーはありましたか？あれば具体的に教えてください。', 0, 0, '2024-11-03 03:42:54', NULL),
(19, 12, 'どのような改善があれば、このページを再度訪問したいと思いますか？', 0, 0, '2024-11-03 03:42:54', NULL),
(20, 12, 'このページを他の人に推薦する場合、どのように説明しますか？', 0, 0, '2024-11-03 03:42:54', NULL),
(31, 55, 'このウェブページを見たとき、最初にどのような印象を持ちましたか？', 0, 0, '2024-11-03 17:48:01', NULL),
(32, 55, 'ウェブページのデザインについてどう思いましたか？特に気に入った点や改善が必要だと感じた点はありますか？', 0, 0, '2024-11-03 17:48:01', NULL),
(33, 55, '情報を探す際、ウェブページのナビゲーションは使いやすいと感じましたか？何か不便に思ったことはありますか？', 0, 0, '2024-11-03 17:48:01', NULL),
(34, 55, 'コンテンツの内容について、役に立つと感じましたか？もっと知りたい情報は何ですか？', 0, 0, '2024-11-03 17:48:01', NULL),
(35, 55, 'ページの読み込み時間についてどう思いましたか？ストレスを感じることはありましたか？', 0, 0, '2024-11-03 17:48:01', NULL),
(36, 55, 'モバイルデバイスでこのウェブページを閲覧する際の体験はどうでしたか？', 0, 0, '2024-11-03 17:48:01', NULL),
(37, 55, 'このウェブページに訪れた理由は何ですか？期待していた情報は得られましたか？', 0, 0, '2024-11-03 17:48:01', NULL),
(38, 55, 'ウェブページでのCTA（コール・トゥ・アクション）は明確だと思いましたか？どのCTAが特に印象に残りましたか？', 0, 0, '2024-11-03 17:48:01', NULL),
(39, 55, '他の競合サイトと比較して、このウェブページのどの点が優れているまたは劣っていると感じましたか？', 0, 0, '2024-11-03 17:48:01', NULL),
(40, 55, '最終的に、このウェブページから得た経験をどのように評価しますか？改善が必要な点があれば教えてください。', 0, 0, '2024-11-03 17:48:01', NULL),
(41, 57, 'このウェブページを初めて見たときの印象はどうでしたか？', 0, 0, '2024-11-03 18:00:30', NULL),
(42, 57, '情報の見つけやすさについてどう感じましたか？', 0, 0, '2024-11-03 18:00:30', NULL),
(43, 57, 'デザインやレイアウトは使いやすいと感じましたか？', 0, 0, '2024-11-03 18:00:30', NULL),
(44, 57, 'ページ内のコンテンツはあなたにとってわかりやすかったですか？', 0, 0, '2024-11-03 18:00:30', NULL),
(45, 57, 'ナビゲーションメニューは使いやすいと感じましたか？', 0, 0, '2024-11-03 18:00:30', NULL),
(46, 57, 'モバイルデバイスでの表示について、使いやすさはどうでしたか？', 0, 0, '2024-11-03 18:00:30', NULL),
(47, 57, 'このページを訪問する目的は何でしたか？', 0, 0, '2024-11-03 18:00:30', NULL),
(48, 57, 'ページの読み込み速度についてどう感じましたか？', 0, 0, '2024-11-03 18:00:30', NULL),
(49, 57, '改善してほしい点や追加してほしい機能はありますか？', 0, 0, '2024-11-03 18:00:30', NULL),
(50, 57, '他に訪れたウェブサイトと比べて、このページの良かった点や悪かった点は何ですか？', 0, 0, '2024-11-03 18:00:30', NULL),
(51, 58, 'このウェブページを最初に訪れたときの印象はどうでしたか？', 0, 0, '2024-11-03 18:01:11', NULL),
(52, 58, 'ウェブページの内容は、自分のニーズに合っていますか？', 0, 0, '2024-11-03 18:01:11', NULL),
(53, 58, 'ウェブページのナビゲーションは使いやすいですか？特にどの部分が使いやすいと感じましたか？', 0, 0, '2024-11-03 18:01:11', NULL),
(54, 58, 'ウェブページのデザインについてどう思いますか？改善点はありますか？', 0, 0, '2024-11-03 18:01:11', NULL),
(55, 58, 'ページの読み込み速度について、満足していますか？早いと感じますか？', 0, 0, '2024-11-03 18:01:11', NULL),
(56, 58, 'このウェブページから得た情報は、明確でしたか？もう少し詳細が必要だと思いますか？', 0, 0, '2024-11-03 18:01:11', NULL),
(57, 58, 'リンクやボタンの位置は適切ですか？どこかに不便を感じるところはありましたか？', 0, 0, '2024-11-03 18:01:12', NULL),
(58, 58, 'このウェブページと類似の他のウェブサイトと比較して、何か特別な点はありますか？', 0, 0, '2024-11-03 18:01:12', NULL),
(59, 58, 'モバイルデバイスでの閲覧時に問題点はありましたか？', 0, 0, '2024-11-03 18:01:12', NULL),
(60, 58, '今後、このウェブページにどのような機能や情報を追加してほしいですか？', 0, 0, '2024-11-03 18:01:12', NULL),
(61, 59, 'このWebページを最初に見たときの印象はどうでしたか？', 0, 0, '2024-11-04 02:38:14', NULL),
(62, 59, 'ページのデザインやレイアウトに満足していますか？その理由は何ですか？', 0, 0, '2024-11-04 02:38:14', NULL),
(63, 59, 'ナビゲーションは使いやすいと思いますか？改善点があれば教えてください。', 0, 0, '2024-11-04 02:38:14', NULL),
(64, 59, 'コンテンツの情報は分かりやすいですか？どの部分が特に良い／悪いと感じましたか？', 0, 0, '2024-11-04 02:38:14', NULL),
(65, 59, 'ページの読み込み速度についてどう思いますか？遅い場合、どのくらいの待ち時間が許容範囲ですか？', 0, 0, '2024-11-04 02:38:14', NULL),
(66, 59, 'モバイルデバイスでの表示はどうでしたか？使いやすさに関して改善が必要な点はありますか？', 0, 0, '2024-11-04 02:38:14', NULL),
(67, 59, 'リンクやボタンの位置は適切ですか？使いにくいと思うところがあれば教えてください。', 0, 0, '2024-11-04 02:38:14', NULL),
(68, 59, 'このWebページの内容に関連して他のWebページと比較したとき、どう感じましたか？', 0, 0, '2024-11-04 02:38:14', NULL),
(69, 59, '何か不満に思った点があれば具体的に教えてください。', 0, 0, '2024-11-04 02:38:14', NULL),
(70, 59, '全体的にこのWebページに対する評価は何点ですか？その理由も教えてください。', 0, 0, '2024-11-04 02:38:14', NULL),
(71, 60, '1. あなたはこのウェブページをどのように見つけましたか？', 0, 0, '2024-11-07 14:50:16', NULL),
(72, 60, '2. このウェブページを訪れた理由は何ですか？', 0, 0, '2024-11-07 14:50:16', NULL),
(73, 60, '3. ページのデザインやレイアウトについて、どのように感じましたか？', 0, 0, '2024-11-07 14:50:16', NULL),
(74, 60, '4. コンテンツの分かりやすさについて、どの程度満足していますか？', 0, 0, '2024-11-07 14:50:16', NULL),
(75, 60, '5. ウェブページを使っていてどの部分が使いやすいと感じましたか？', 0, 0, '2024-11-07 14:50:16', NULL),
(76, 60, '6. 逆に、どの部分が使いにくいと感じましたか？', 0, 0, '2024-11-07 14:50:16', NULL),
(77, 60, '7. どの情報が最も役立ったと感じましたか？', 0, 0, '2024-11-07 14:50:16', NULL),
(78, 60, '8. 今後、どのような情報や機能が追加されると良いと思いますか？', 0, 0, '2024-11-07 14:50:16', NULL),
(79, 60, '9. SNSや他のウェブサイトと比較して、このページの印象はどうですか？', 0, 0, '2024-11-07 14:50:16', NULL),
(80, 60, '10. このウェブページに対して、改善してほしい点や意見はありますか？', 0, 0, '2024-11-07 14:50:16', NULL),
(81, 61, 'このウェブサイトを訪れた理由は何ですか？', 0, 0, '2024-11-07 15:08:29', NULL),
(82, 61, 'サイトのデザインやレイアウトについて、初めての印象はどうでしたか？', 0, 0, '2024-11-07 15:08:29', NULL),
(83, 61, 'コンテンツの読みやすさや理解しやすさについて、どのように感じましたか？', 0, 0, '2024-11-07 15:08:29', NULL),
(84, 61, '特に印象に残ったコンテンツや要素はありましたか？それはなぜですか？', 0, 0, '2024-11-07 15:08:29', NULL),
(85, 61, 'サイトを利用している間、ユーザーエクスペリエンスに改善が必要だと思う点は何ですか？', 0, 0, '2024-11-07 15:08:30', NULL),
(86, 61, '他の同様のサイトと比較して、このサイトの強みや弱みは何ですか？', 0, 0, '2024-11-07 15:08:30', NULL),
(87, 61, 'サイト内のナビゲーションについて、使いやすさはどうでしたか？改善点はありますか？', 0, 0, '2024-11-07 15:08:30', NULL),
(88, 61, 'あなたがこのサイトに追加してほしい機能やコンテンツはありますか？', 0, 0, '2024-11-07 15:08:30', NULL),
(89, 61, 'このサイトを友人や同僚に薦める可能性はどのくらいありますか？その理由は何ですか？', 0, 0, '2024-11-07 15:08:30', NULL),
(90, 61, '最後に、全体的な満足度を5段階で評価するとしたら、どの評価をつけますか？その理由は何ですか？', 0, 0, '2024-11-07 15:08:30', NULL),
(91, 62, 'このウェブページにアクセスした最初の印象はどうでしたか？', 0, 0, '2024-11-09 02:13:54', NULL),
(92, 62, 'ページの内容はあなたの期待に応えていますか？何が不足していると感じますか？', 0, 0, '2024-11-09 02:13:54', NULL),
(93, 62, 'ユーザーインターフェースは使いやすいですか？どの部分が特に良い、または改善が必要だと思いますか？', 0, 0, '2024-11-09 02:13:54', NULL),
(94, 62, '情報を見つけるのは簡単でしたか？どのような情報がさらに必要だと感じましたか？', 0, 0, '2024-11-09 02:13:54', NULL),
(95, 62, 'ページのデザインやレイアウトについてどう思いますか？視覚的な魅力を感じますか？', 0, 0, '2024-11-09 02:13:54', NULL),
(96, 62, '動線（ナビゲーション）は直感的ですか？何か confusing な点はありましたか？', 0, 0, '2024-11-09 02:13:54', NULL),
(97, 62, 'ページの読み込み速度についてどう思いますか？快適に利用できましたか？', 0, 0, '2024-11-09 02:13:54', NULL),
(98, 62, 'モバイルデバイスでの閲覧体験はどうでしたか？デスクトップと比較してどのように感じましたか？', 0, 0, '2024-11-09 02:13:54', NULL),
(99, 62, 'あなたがこのページを他の人に勧めるとしたら、どのような点を強調しますか？', 0, 0, '2024-11-09 02:13:54', NULL),
(100, 62, '今後、どのような機能やコンテンツの追加を期待しますか？', 0, 0, '2024-11-09 02:13:54', NULL),
(101, 64, 'このウェブページを訪れた際の最初の印象はどうでしたか？', 2, 0, '2024-11-10 07:55:21', NULL),
(102, 64, 'ウェブページのデザインについて、良いと思った点は何ですか？', 3, 0, '2024-11-10 07:55:21', NULL),
(103, 64, '逆に、デザインで改善が必要だと思う点はありますか？', 4, 0, '2024-11-10 07:55:21', NULL),
(104, 64, '情報の構造について、分かりやすいと感じましたか？それとも混乱しましたか？', 0, 1, '2024-11-10 07:55:21', NULL),
(105, 64, 'ウェブページの内容は目的に合っていますか？', 0, 1, '2024-11-10 07:55:21', NULL),
(106, 64, 'ナビゲーション（メニューやリンク）は使いやすいですか？改善点があれば教えてください。', 5, 0, '2024-11-10 07:55:21', NULL),
(107, 64, 'ページの読み込み速度について、どう感じましたか？', 6, 0, '2024-11-10 07:55:21', NULL),
(108, 64, 'レスポンシブデザインは機能していますか？異なるデバイスでの使用について教えてください。', 7, 0, '2024-11-10 07:55:21', NULL),
(109, 64, '情報を探している際に、どのようなツールや機能が役立つと感じましたか？', 8, 0, '2024-11-10 07:55:21', NULL),
(110, 64, '今後、このウェブページに追加してほしい機能や情報はありますか？', 1, 0, '2024-11-10 07:55:21', NULL),
(111, 64, 'Webページはごちゃごちゃしていると感じましたか？それともスカスカしていると感じましたか？', 0, 0, '2024-11-10 10:38:02', NULL),
(112, 65, 'このWebページを訪れた際、最初にどのような印象を持ちましたか？', 7, 0, '2024-11-11 15:36:38', NULL),
(113, 65, 'ページのナビゲーションはユーザーフレンドリーだと思いますか？ どの部分が改善できるでしょうか？', 1, 0, '2024-11-11 15:36:38', NULL),
(114, 65, '必要な情報を見つけるのは簡単でしたか？ どのような情報が具体的に見つけにくかったですか？', 2, 0, '2024-11-11 15:36:38', NULL),
(115, 65, 'このWebページのデザインやレイアウトについて、どのような感想がありますか？', 3, 0, '2024-11-11 15:36:38', NULL),
(116, 65, 'ページの読み込み速度はいかがでしたか？ 改善点があるとすれば何ですか？', 4, 0, '2024-11-11 15:36:38', NULL),
(117, 65, 'コンテンツの内容について、どの部分が特に好印象でしたか？ 逆に、改善が必要だと思う部分はありますか？', 5, 0, '2024-11-11 15:36:38', NULL),
(118, 65, 'モバイルデバイスからの閲覧はいかがでしたか？ スマートフォン用に最適化されていると思いますか？', 8, 0, '2024-11-11 15:36:38', NULL),
(119, 65, 'Webページの色使いやフォントスタイルについて、感じたことを教えてください。', 10, 0, '2024-11-11 15:36:38', NULL),
(120, 65, '他の類似のWebページと比較して、ここの特徴は何ですか？ どの部分が優れている/劣っていると思いますか？', 9, 0, '2024-11-11 15:36:38', NULL),
(121, 65, 'このWebページを友人や知人に勧めたいと思いますか？ 理由も教えてください。', 6, 0, '2024-11-11 15:36:38', NULL),
(122, 66, 'このウェブページを訪問した理由は何ですか？', 0, 1, '2024-11-18 14:31:08', NULL),
(123, 66, 'ページにアクセスして最初に目に入った要素は何ですか？', 0, 1, '2024-11-18 14:31:08', NULL),
(124, 66, 'このウェブページのデザインについてどう思いますか？', 0, 1, '2024-11-18 14:31:08', NULL),
(125, 66, '情報は必要な時に見つけやすかったですか？', 0, 1, '2024-11-18 14:31:08', NULL),
(126, 66, 'ナビゲーションはスムーズでしたか？', 0, 1, '2024-11-18 14:31:08', NULL),
(127, 66, 'あなたがこのページで最も気に入った点は何ですか？', 0, 1, '2024-11-18 14:31:08', NULL),
(128, 66, '逆に、改善が必要だと思う点はどこですか？', 0, 1, '2024-11-18 14:31:08', NULL),
(129, 66, 'レスポンス速度や読み込み時間についての印象はどうですか？', 0, 1, '2024-11-18 14:31:08', NULL),
(130, 66, 'このウェブページのコンテンツは自分の期待に応えていますか？', 1, 0, '2024-11-18 14:31:08', NULL),
(131, 66, '他のウェブサイトと比較して、このページの独自性や魅力は何だと感じますか？', 2, 0, '2024-11-18 14:31:08', NULL),
(132, 67, 'このウェブページを訪れた際、最初にどのような印象を持ちましたか？', 1, 0, '2024-11-20 23:11:32', NULL),
(133, 67, 'ページの読み込み速度について、あなたはどのように感じましたか？', 0, 1, '2024-11-20 23:11:32', NULL),
(134, 67, 'コンテンツのレイアウトやデザインについて、どのような点が気に入りましたか？逆に、改善が必要だと感じた点はありますか？', 0, 1, '2024-11-20 23:11:32', NULL),
(135, 67, '情報を探す際、ナビゲーションは使いやすいと感じましたか？もし難しい部分があれば教えてください。', 0, 1, '2024-11-20 23:11:32', NULL),
(136, 67, 'ページ内のテキストのフォントやサイズについて、読みやすさはどうでしたか？', 0, 1, '2024-11-20 23:11:32', NULL),
(137, 67, '画像やビジュアルコンテンツは効果的だと思いましたか？どのような印象を受けましたか？', 0, 1, '2024-11-20 23:11:32', NULL),
(138, 67, 'このページで提供されている情報は、あなたのニーズに対してどれくらい関連性がありましたか？', 0, 1, '2024-11-20 23:11:32', NULL),
(139, 67, 'ページがモバイルデバイスで表示される際の使いやすさについて、どのように感じましたか？', 0, 1, '2024-11-20 23:11:32', NULL),
(140, 67, 'ウェブページに再度訪れたいと思う理由はありますか？それとも、他のサイトを利用する理由がありますか？', 0, 1, '2024-11-20 23:11:32', NULL),
(141, 67, 'このウェブページの全体的な満足度について、10点満点で評価するとしたら何点をつけますか？その理由も教えてください。', 0, 1, '2024-11-20 23:11:32', NULL),
(142, 68, 'このウェブページを訪れた際の最初の印象は何でしたか？', 2, 0, '2024-11-21 04:12:08', NULL),
(143, 68, 'ウェブページのデザインについて、どのように感じましたか？', 1, 0, '2024-11-21 04:12:08', NULL),
(144, 68, '情報の見つけやすさについて、どのように評価しますか？', 0, 1, '2024-11-21 04:12:08', NULL),
(145, 68, 'コンテンツの内容は役に立ちましたか？具体的にどの部分が良かったですか？', 0, 1, '2024-11-21 04:12:08', NULL),
(146, 68, 'ページの読み込み速度について、どう感じましたか？', 0, 1, '2024-11-21 04:12:08', NULL),
(147, 68, 'ナビゲーションの使いやすさについて、意見を教えてください。', 0, 1, '2024-11-21 04:12:08', NULL),
(148, 68, 'ウェブページで特に気に入った点や改善が必要だと感じた点は何ですか？', 0, 1, '2024-11-21 04:12:08', NULL),
(149, 68, 'このページを他のユーザーにすすめたいと思いますか？その理由は何ですか？', 0, 1, '2024-11-21 04:12:08', NULL),
(150, 68, '携帯電話やタブレットでの表示について、何か気になる点はありますか？', 0, 1, '2024-11-21 04:12:08', NULL),
(151, 68, '今後、ウェブページに追加してほしい機能や情報はありますか？', 0, 1, '2024-11-21 04:12:08', NULL),
(152, 70, '普段、ポイントサービスを利用する際にどのような目的やニーズがありますか？', 0, 0, '2024-11-24 17:21:03', NULL),
(153, 70, 'どのポイントサービスを最も頻繁に利用していますか？その理由は何ですか？', 0, 0, '2024-11-24 17:21:03', NULL),
(154, 70, 'ポイントを獲得するために、どのような購買行動を取ることが多いですか？', 0, 0, '2024-11-24 17:21:03', NULL),
(155, 70, '私たちのサービスを利用する中で、最も魅力を感じる機能や特典は何ですか？', 0, 0, '2024-11-24 17:21:03', NULL),
(156, 70, '他のポイントサービスと比較して、私たちのサービスに足りないと感じる部分はありますか？', 0, 0, '2024-11-24 17:21:03', NULL),
(157, 70, '普段の生活の中で、ポイントをどのように管理していますか？', 0, 0, '2024-11-24 17:21:03', NULL),
(158, 70, 'ポイントを利用する際に、どのような時に一番楽しさを感じますか？', 0, 0, '2024-11-24 17:21:03', NULL),
(159, 70, '過去にポイントを獲得した経験で、特に印象に残っているエピソードはありますか？', 0, 0, '2024-11-24 17:21:03', NULL),
(160, 70, '今後、私たちのポイントサービスに追加してほしい機能はありますか？', 0, 0, '2024-11-24 17:21:03', NULL),
(161, 70, '競合サービスに対して、私たちのサービスを選ぶ理由と選ばない理由を教えてください。', 0, 0, '2024-11-24 17:21:03', NULL),
(162, 71, '普段、ポイントサービスを利用する際の選択基準は何ですか？', 0, 0, '2024-11-24 17:23:45', NULL),
(163, 71, '利用するポイントサービスの中で、特に重視している機能や特徴はありますか？', 0, 0, '2024-11-24 17:23:45', NULL),
(164, 71, 'ポイントを獲得するために、どのような加盟店を利用していますか？', 0, 0, '2024-11-24 17:23:45', NULL),
(165, 71, 'ポイントを使う際に、どのようなシチュエーションで使用することが多いですか？', 0, 0, '2024-11-24 17:23:45', NULL),
(166, 71, 'サービスを利用する頻度はどのくらいですか？具体的な活動例を教えてください。', 0, 0, '2024-11-24 17:23:45', NULL),
(167, 71, '現在利用しているポイントサービスに対する満足度はどのように感じていますか？', 0, 0, '2024-11-24 17:23:45', NULL),
(168, 71, '他のポイントサービス（楽天ポイント、Vポイント、Paypayポイントなど）と比較した時、何が一番の違いだと思いますか？', 0, 0, '2024-11-24 17:23:45', NULL),
(169, 71, 'アクティブユーザーとして、ポイントを利用する際に障害に感じることは何ですか？', 0, 0, '2024-11-24 17:23:45', NULL),
(170, 71, 'ポイントサービスを使っていない期間はありますか？その理由は何ですか？', 0, 0, '2024-11-24 17:23:45', NULL),
(171, 71, '今後、ポイントサービスが提供するべき機能やサービスは何だと思いますか？', 0, 0, '2024-11-24 17:23:45', NULL),
(172, 72, '普段、どのようなシチュエーションでポイントサービスを利用していますか？', 0, 0, '2024-11-24 17:30:08', NULL),
(173, 72, 'ポイントサービスを選ぶ際に、一番重視するポイントは何ですか？', 0, 0, '2024-11-24 17:30:08', NULL),
(174, 72, '特定の加盟店を利用する際、ポイントがどのように影響を与えていますか？', 0, 0, '2024-11-24 17:30:08', NULL),
(175, 72, 'ポイントを貯める動機と、その利用方法について教えてください。', 0, 0, '2024-11-24 17:30:08', NULL),
(176, 72, '競合のポイントサービス（楽天ポイント、Vポイント、Paypayポイント）と比べて、当サービスのどの点が魅力的ですか？', 0, 0, '2024-11-24 17:30:08', NULL),
(177, 72, 'ポイントを使う際の具体的な体験やエピソードを教えてください。', 0, 0, '2024-11-24 17:30:08', NULL),
(178, 72, 'ポイントの利用促進のために、どのようなキャンペーンやインセンティブがあれば参加したいと思いますか？', 0, 0, '2024-11-24 17:30:08', NULL),
(179, 72, '普段の買い物でポイントを活用する際、どのような困りごとや悩みがありますか？', 0, 0, '2024-11-24 17:30:08', NULL),
(180, 72, 'サービスに対する要望や改善点があれば教えてください。', 0, 0, '2024-11-24 17:30:08', NULL),
(181, 72, '今後、当サービスによってどのような体験を期待していますか？', 0, 0, '2024-11-24 17:30:08', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `scenario_table`
--

CREATE TABLE `scenario_table` (
  `scenario_id` int(8) NOT NULL,
  `question_id` int(8) NOT NULL,
  `question_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `target_age_table`
--

CREATE TABLE `target_age_table` (
  `target_age_id` int(11) NOT NULL,
  `target_age` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `target_age_table`
--

INSERT INTO `target_age_table` (`target_age_id`, `target_age`) VALUES
(1, '10代未満'),
(2, '10代'),
(3, '20代'),
(4, '30代'),
(5, '40代'),
(6, '50代'),
(7, '60代以上');

-- --------------------------------------------------------

--
-- テーブルの構造 `target_gender_table`
--

CREATE TABLE `target_gender_table` (
  `target_gender_id` int(11) NOT NULL,
  `target_gender` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `target_gender_table`
--

INSERT INTO `target_gender_table` (`target_gender_id`, `target_gender`) VALUES
(1, '男性'),
(2, '女性');

-- --------------------------------------------------------

--
-- テーブルの構造 `target_type_table`
--

CREATE TABLE `target_type_table` (
  `target_type_id` int(11) NOT NULL,
  `target_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `target_type_table`
--

INSERT INTO `target_type_table` (`target_type_id`, `target_type`) VALUES
(1, 'age'),
(2, 'gender');

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
-- テーブルのインデックス `category_target_table`
--
ALTER TABLE `category_target_table`
  ADD PRIMARY KEY (`category_target_id`);

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
-- テーブルのインデックス `target_age_table`
--
ALTER TABLE `target_age_table`
  ADD PRIMARY KEY (`target_age_id`);

--
-- テーブルのインデックス `target_gender_table`
--
ALTER TABLE `target_gender_table`
  ADD PRIMARY KEY (`target_gender_id`);

--
-- テーブルのインデックス `target_type_table`
--
ALTER TABLE `target_type_table`
  ADD PRIMARY KEY (`target_type_id`);

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
  MODIFY `category_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- テーブルの AUTO_INCREMENT `category_target_table`
--
ALTER TABLE `category_target_table`
  MODIFY `category_target_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- テーブルの AUTO_INCREMENT `category_type_table`
--
ALTER TABLE `category_type_table`
  MODIFY `category_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `chat_log_table`
--
ALTER TABLE `chat_log_table`
  MODIFY `chat_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- テーブルの AUTO_INCREMENT `interviewee_table`
--
ALTER TABLE `interviewee_table`
  MODIFY `interviewee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `question_table`
--
ALTER TABLE `question_table`
  MODIFY `question_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- テーブルの AUTO_INCREMENT `scenario_table`
--
ALTER TABLE `scenario_table`
  MODIFY `scenario_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `target_age_table`
--
ALTER TABLE `target_age_table`
  MODIFY `target_age_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- テーブルの AUTO_INCREMENT `target_gender_table`
--
ALTER TABLE `target_gender_table`
  MODIFY `target_gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `target_type_table`
--
ALTER TABLE `target_type_table`
  MODIFY `target_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
