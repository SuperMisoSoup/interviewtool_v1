<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$category_id = $_SESSION["category_id"];
$_SESSION["category_id"]    = $category_id;

// カテゴリtableの参照
$sql_select_question = "SELECT ct.category_type, q.question_text, c.description, c.service_url, q.delete_flg, c.user_id, q.question_id, c.category_id, ct.category_type_id FROM question_table q INNER JOIN category_table c ON q.category_id = c.category_id INNER JOIN category_type_table ct ON c.category_type_id = ct.category_type_id WHERE c.category_id =" . $category_id . ";";
$stmt_question = $pdo->prepare($sql_select_question);
$status_question = $stmt_question->execute();
// SQLエラー確認
if ($status_question == false) {
  sql_error($stmt_question);
}
// 全データ取得
$values = "";
$values =  $stmt_question->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]

// カテゴリタイプtableの参照
$sql_select_category = "SELECT * FROM category_table c INNER JOIN category_type_table ct ON c.category_type_id = ct.category_type_id WHERE c.category_id =" . $category_id . ";";
$stmt_category = $pdo->prepare($sql_select_category);
$status_category = $stmt_category->execute();
// SQLエラー確認
if ($status_category == false) {
  sql_error($stmt_category);
}
// 全データ取得
$values_category = "";
$values_category =  $stmt_category->fetch(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>インタビュー設計</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 60px;
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
  <div class="container mt-4">

    <!-- 作成済み質問の表示 -->
    <div class="card shadow">
      <div class="card-header bg-success text-white">
        <h2 class="h4 mb-0">質問リスト</h2>
      </div>
      <div class="card-body">
        <p><span class="font-weight-bold">カテゴリ</span>：<?= h($values_category["category_type"]) ?></p>
        <p><span class="font-weight-bold">詳細目的</span>：<?= h($values_category["description"]) ?></p>
        <p><span class="font-weight-bold">URL</span>：<?= h($values_category["service_url"]) ?></p>
        <hr>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>質問</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($values as $v) { ?>
                <tr>
                  <td><?= h($v["question_text"]) ?></td>
                  <td>
                    <a href="interview_question_edit.php?question_id=<?= h($v["question_id"]) ?>" class="btn btn-sm btn-outline-primary">編集</a>
                    <?php if ($v["delete_flg"] == 1) { ?>
                      <a href="interview_question_undelete.php?question_id=<?= h($v["question_id"]) ?>" class="btn btn-sm btn-outline-dark">元に戻す</a>
                    <?php } else { ?>
                      <a href="interview_question_delete.php?question_id=<?= h($v["question_id"]) ?>" class="btn btn-sm btn-outline-danger">削除</a>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- TODO:interviewtool_scenario_add.php -->
    <a href="chat.php" class="btn btn-primary">
      チャットを開始
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>



<!-- 

③チャットボットに流し込む
  与えられた質問に沿ってユーザと会話してください
  ユーザの回答に対して2~3回深掘りをしてください


③チャットツール
　-②の質問をチャット形式で表示
　-2~3回深掘り

TODO:シナリオ管理tableに登録

TODO:配布用のURLの作成方法
TODO:過去に生成したインタビューも編集できるように

TODO:自分の質問の追加ができるように
TODO:順番変えれるように ※不要かも



-->