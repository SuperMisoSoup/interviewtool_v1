<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

//データ参照SQL
$sql_select_question = "SELECT * FROM category_type_table;";
$stmt = $pdo->prepare($sql_select_question);
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
    <title>カテゴリ選択</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px;
        }
    </style>
</head>

<body class="bg-light">
    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">カテゴリ選択</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- 質問の新規作成フォーム -->
        <div class="card mb-5 shadow">
            <div class="card-header bg-secondary text-white">
                <h2 class="h4 mb-0">新規作成</h2>
            </div>
            <p><span class="font-weight-bold">カテゴリを選択</span></p>
            <div class="card-body">

                <div class="d-grid gap-2 col-6 mx-auto">
                    <?php
                    // ボタンを表示
                    foreach ($values as $v) {
                        echo '<a href="interviewtool_detail.php?category_id=' . $v['category_type_id'] . '">';
                        echo '<button class="btn btn-primary" type="button">' . $v['category_type'] . '</button>';
                        echo '</a>';
                    }
                    ?>
                    <!-- FIXME:表示を2x3とかにしたい -->
                </div>


                <form method="POST" action="" id="questionForm">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="purpose" name="purpose" placeholder="把握したいこと" value="<?= h($purpose) ?>">
                        <label for="purpose">把握したいこと</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="question" name="question" style="height: 100px" placeholder="質問"><?= h($generated_question) ?></textarea>
                        <label for="question">生成された質問</label>
                    </div>
                    <button type="submit" class="btn btn-info" name="generate">質問を自動生成</button>
                    <?php if ($generated_question): ?>
                        <button type="submit" class="btn btn-primary" formaction="design.insert.php">保存</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>