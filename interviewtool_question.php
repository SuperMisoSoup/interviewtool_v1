<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$generated_question = "";
$purpose = "";
$category_id = $_SESSION["category_id"];

// OpenAI APIを使用して質問を生成する関数を呼び出し
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purpose'])) {
  $purpose = $_POST['purpose'];
  $generated_question = generate_question($purpose);
}

//データ参照SQL
$sql_select_category = "SELECT ct.category_type, q.question_text, c.description, c.service_url, q.delete_flg, c.user_id, q.question_id, c.category_id, ct.category_type_id FROM question_table q INNER JOIN category_table c ON q.category_id = c.category_id INNER JOIN category_type_table ct ON c.category_type_id = ct.category_type_id WHERE c.category_id =" .$category_id . ";";
$stmt = $pdo->prepare($sql_select_category);
$status = $stmt->execute();
//SQLエラー確認
if ($status == false) {
  sql_error($stmt);
}
//全データ取得
$values = "";
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values, JSON_UNESCAPED_UNICODE); //JSON化してJSに渡す場合

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
        <p><span class="font-weight-bold">カテゴリ</span>：<?= h($values["category_type"]) ?></p>
        <p><span class="font-weight-bold">詳細目的</span>：<?= h($values["description"]) ?></p>
        <p><span class="font-weight-bold">URL</span>：<?= h($values["service_url"]) ?></p>
        <!-- FIXME:カテゴリと詳細目的を表示させる -->
        <hr>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <!-- <th>カテゴリ</th>
                <th>詳細目的</th>
                <th>URL</th> -->
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
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>



<!-- 

DONE:①ユーザから目的を聞いて8~10のインタビューシナリオを作る
                └DBに登録する
②生成された質問を編集
③チャットボットに流し込む
  与えられた質問に沿ってユーザと会話してください
  ユーザの回答に対して2~3回深掘りをしてください





①質問シナリオ生成
　-目的(category)を入力するとOpenAI APIで質問生成　(ex.①Webページの改善、②サービスUXの改善…)　→dマガジンの例で作る
　-具体のWebページなども併せて入力　(ex.https://docomo-tech-tkn.sakura.ne.jp/01_HTMLCSS/html_name_00/index.html)
　-返答を画面に表示
②質問シナリオ編集
　-編集・削除・順番変更できる
　-生成！ボタンを押すとDBに保存
　-URL？別画面に移動
③チャットツール
　-②の質問をチャット形式で表示
　-2~3回深掘り






-->