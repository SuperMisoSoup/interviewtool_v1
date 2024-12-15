<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$category_id  = $_SESSION["category_id"];
$admin_flg    = $_SESSION["admin_flg"];

// カテゴリtableの参照
$sql_select = "
    SELECT 
        c.category_id,
        ct.category_type,
        s.section_id,
        s.section_text,
        s.section_order,
        q.question_id,
        q.question_text,
        q.question_purpose,
        q.question_order,
        d.dig_point_id,
        d.dig_point_text,
        d.dig_point_order
    FROM 
        category_table AS c
    INNER JOIN
        category_type_table AS ct ON c.category_type_id = ct.category_type_id
    INNER JOIN 
        section_table AS s ON c.category_id = s.category_id
    INNER JOIN 
        question_table AS q ON s.section_id = q.section_id
    LEFT JOIN 
        dig_point_table AS d ON q.question_id = d.for_question_id
    WHERE 
        c.category_id = :category_id
    ORDER BY 
        c.category_id, s.section_order, q.question_order, d.dig_point_order;
";

$stmt = $pdo->prepare($sql_select);
$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$status = $stmt->execute();

// SQLエラー確認
if ($status == false) {
    sql_error($stmt);
}
// 全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]

// // 確認用
// echo '<pre>';
// var_dump($values);
// echo '</pre>';


// データ構造を整理
$sections = [];
foreach ($values as $row) {
    $sectionText = $row['section_text'];
    $questionText = $row['question_text'];
    $questionPurpose = $row['question_purpose'];
    $digPointText = $row['dig_point_text'];

    // セクション単位でグループ化
    if (!isset($sections[$sectionText])) {
        $sections[$sectionText] = [];
    }

    // 質問単位で深掘りポイントを整理
    if (!isset($sections[$sectionText][$questionText])) {
        $sections[$sectionText][$questionText] = [
            'purpose' => $questionPurpose,
            'dig_points' => []
        ];
    }
    if (!empty($digPointText)) {
        $sections[$sectionText][$questionText]['dig_points'][] = $digPointText;
    }
}
$section_index = 1;
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>インタビューシナリオ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <style>
        body {
            padding-top: 50px;
        }

        .horizontal-scroll {
            display: flex;
            overflow-x: hidden;
            /* スクロールバーを非表示に */
            gap: 1rem;
            /* セクション間の間隔 */
            scroll-behavior: smooth;
            /* スムーズスクロール */
            padding: 20px;
        }

        .card {
            border-radius: 16px;
            /* カード全体を角丸に */
            overflow: hidden;
            /* 子要素がカードの丸みに従うように */
        }

        .card-header {
            border-top-left-radius: 16px;
            /* 左上の角を丸める */
            border-top-right-radius: 16px;
            /* 右上の角を丸める */
        }

        #section_card {
            width: 45%;
            flex-shrink: 0;
        }

        #question_card {
            width: 95%;
            flex-shrink: 0;
            margin: auto;
            box-shadow:
                8px 8px 16px rgba(0, 0, 0, 0.2),
                /* 下部右の影 */
                -8px -8px 16px rgba(250, 250, 250, 0.8);
            /* 上部左の明るい影 */
            transition: all 0.3s ease;
            /* スムーズなアニメーション */
        }

        #question_card:hover {
            background: #f1f3f4;
            /* 薄い灰色でニューモーフィズム背景 */
            box-shadow:
                12px 12px 24px rgba(0, 0, 0, 0.3),
                /* 強調された下部右の影 */
                -12px -12px 24px rgba(255, 255, 255, 0.9);
            /* 強調された上部左の明るい影 */
        }


        .mb-1 {
            color: gray;
        }

        .scroll-button {
            position: relative;
            z-index: 10;
            /* 背景半透明 */
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .scroll-container {
            position: relative;
        }

        .scroll-left,
        .scroll-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .scroll-left {
            left: -20px;
        }

        .scroll-right {
            right: -20px;
        }
    </style>
</head>

<!-- ナビゲーションバー -->
<?php create_header($admin_flg); ?>

<body class="bg-light">
    <div class="container px-4 py-5" id="hanging-icons">
        <h1 class="pb-2 border-bottom">インタビューシナリオ</h1>

        <div class="scroll-container">

            <!-- 左スクロールボタン -->
            <button class="scroll-button scroll-left bg-dark-subtle" id="scrollLeft">&lt;</button>

            <!-- 横スクロールのセクションリスト -->
            <div class="horizontal-scroll" id="scrollArea">
                <?php foreach ($sections as $sectionText => $questions): ?>

                    <!-- Section Card -->
                    <div class="card shadow border-0" id="section_card">
                        <div class="card-header bg-primary-subtle border-0"></div>
                        <div class="card-body">
                            <h4 class="mb-3"><?= $section_index++ ?>.<?= htmlspecialchars($sectionText) ?></h4>
                            <?php foreach ($questions as $questionText => $details): ?>

                                <!-- Question Card -->
                                <div class="card mb-4 shadow border-0" id="question_card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($questionText) ?></h5>
                                        <p class="mb-1"> 　<?= htmlspecialchars($details['purpose']) ?></p>
                                        <ul class="list-unstyled">
                                            <?php foreach ($details['dig_points'] as $index => $digPointText): ?>
                                                <li>
                                                    　<svg class="h-4 w-4 text-gray-500" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" />
                                                        <circle cx="10" cy="10" r="7" />
                                                        <line x1="7" y1="10" x2="13" y2="10" />
                                                        <line x1="10" y1="7" x2="10" y2="13" />
                                                        <line x1="21" y1="21" x2="15" y2="15" />
                                                    </svg>
                                                    <?= htmlspecialchars($digPointText) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

            <!-- 右スクロールボタン -->
            <button class="scroll-button scroll-right bg-dark-subtle" id="scrollRight">&gt;</button>
            
        </div>
    </div>


    <script>
        // スクロールエリアとボタンの取得
        const scrollArea = document.getElementById('scrollArea');
        const scrollLeft = document.getElementById('scrollLeft');
        const scrollRight = document.getElementById('scrollRight');

        // スクロール幅を動的に計算
        const sectionCardWidth = document.getElementById('section_card').offsetWidth; // カード1つ分の幅

        // 左スクロール
        scrollLeft.addEventListener('click', () => {
            scrollArea.scrollBy({
                left: -sectionCardWidth, // カード幅分だけスクロール
                behavior: 'smooth'
            });
        });

        // 右スクロール
        scrollRight.addEventListener('click', () => {
            scrollArea.scrollBy({
                left: sectionCardWidth, // カード幅分だけスクロール
                behavior: 'smooth'
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>