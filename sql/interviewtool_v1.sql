-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-11-10 16:28:17
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
(1, 1, 'チーズアカデミー', 'もっとPV数を増やしたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-10-28 15:47:57', NULL, 1),
(12, 1, 'チーズアカデミー', 'PV数を改善したい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-03 03:42:52', NULL, 1),
(55, 1, 'チーズアカデミー', 'PV数を改善したい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-03 17:47:57', NULL, 1),
(57, 1, 'チーズアカデミー', 'PV数を改善したい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-03 18:00:26', NULL, 0),
(58, 1, 'チーズアカデミー', 'PV数を改善したい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-03 18:01:08', NULL, 0),
(59, 1, 'チーズアカデミー', 'PV数を稼ぎたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-04 02:38:10', NULL, 0),
(60, 1, 'チーズアカデミー', '明るいサイトにしたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-07 14:50:11', NULL, 0),
(61, 2, 'チーズアカデミー', '楽しい雰囲気にしたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-07 15:08:23', NULL, 0),
(62, 1, 'チーズアカデミー', '', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-09 02:13:46', NULL, 0),
(63, 1, 'チーズアカデミー', 'バリバリにしたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-10 00:23:01', NULL, 0),
(64, 1, 'チーズアカデミー', 'ムキムキにしたい', 'https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html', '2024-11-10 07:55:16', NULL, 0);

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
  `chat_log_order` int(11) NOT NULL,
  `chat_by` int(11) NOT NULL,
  `chat_text` int(11) NOT NULL,
  `for_question_id` int(11) NOT NULL,
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
(111, 64, 'Webページはごちゃごちゃしていると感じましたか？それともスカスカしていると感じましたか？', 0, 0, '2024-11-10 10:38:02', NULL);

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
  MODIFY `category_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
  MODIFY `question_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

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
