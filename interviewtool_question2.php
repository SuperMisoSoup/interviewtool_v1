<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$category_id               = $_SESSION["category_id"];
$_SESSION["category_id"]   = $category_id;

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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>インタビューシナリオ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
  <style>
    body {
      padding-top: 50px;
    }

    /* カラムの幅を調整 */
    .col-question {
      width: 40%;
    }

    .col-purpose {
      width: 35%;
    }

    .col-dig-point {
      width: 25%;
    }
  </style>
</head>

<!-- ナビゲーションバー -->
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">インタビュー管理システム</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="design.php">インタビュー設計</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="respondent.php">インタビュアーリスト</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="answer.php">回答入力</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="analysis_2.php">結果分析</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="user.php">ユーザー登録</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">ログアウト</a>
          </li>
        </ul>
      </div> -->
    </div>
  </nav>
</header>

<body class="bg-light">
  <div class="container my-5">
    <?php foreach ($sections as $sectionText => $questions): ?>
      <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h4 class="border-bottom pb-2 mb-0"><?= $section_index ++ ?>.<?= htmlspecialchars($sectionText) ?></h4>
        <?php foreach ($questions as $questionText => $details): ?>
          <div class="d-flex pt-3">
            <div class="pb-3 mb-0 lh-sm border-bottom w-100">
              <div class="d-flex justify-content-between">
                <strong class="text-gray-dark"><?= htmlspecialchars($questionText) ?></strong>
              </div>
              <span class="d-block text-body-secondary"><?= htmlspecialchars($details['purpose']) ?></span>
              <?php foreach ($details['dig_points'] as $index => $digPointText): ?>
                <span class="d-block text-body-secondary">深堀ポイント<?= $index + 1 ?>: <?= htmlspecialchars($digPointText) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>






    <div class="container my-5">
      <?php $section_index = 1; ?>
      <?php foreach ($sections as $sectionText => $questions): ?>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
          <!-- セクションタイトル -->
          <h4 class="border-bottom pb-2 mb-0"><?= $section_index ++ ?>.<?= htmlspecialchars($sectionText) ?></h4>
          <div class="table-responsive pt-3">
            <table class="table table-borderless">
              <?php foreach ($questions as $questionText => $details): ?>
                <tr>
                  <td class="col-question"><strong><?= htmlspecialchars($questionText) ?></strong></td>
                  <td class="col-purpose text-body-secondary"><?= htmlspecialchars($details['purpose']) ?></td>
                  <td class="col-dig-point">
                    <?php foreach ($details['dig_points'] as $digPointText): ?>
                      <div><?= htmlspecialchars($digPointText) ?></div>
                    <?php endforeach; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      <?php endforeach; ?>
    </div>





</body>

</html>