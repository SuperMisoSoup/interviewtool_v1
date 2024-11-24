<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

//データ参照SQL
$sql_select_category = "SELECT * FROM category_type_table;";
$stmt = $pdo->prepare($sql_select_category);
$status = $stmt->execute();
//SQLエラー確認
if ($status == false) {
    sql_error($stmt);
}
//全データ取得
$values = "";
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            padding-top: 50px;
        }
    </style>
</head>

<!-- ナビゲーションバー -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">カテゴリ選択</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</header>

<body class="bg-light">
    <div class="container px-4 py-5" id="hanging-icons">
        <h1 class="pb-2 border-bottom">カテゴリ選択</h1>

        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">

            <?php foreach ($values as $v) { ?>
                <div class="col d-flex align-items-start grid gap-0 column-gap-3">
                    <div class="bg-body-secondary d-inline-flex align-items-center justify-content-center flex-shrink-0 rounded-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-window" viewBox="-4 -4 24 24">
                            <?= htmlspecialchars_decode($v["image_tag"]) ?>
                        </svg>
                    </div>
                    <div>
                        <h2 class="fs-2 text-body-emphasis"><?= h($v["category_type"]) ?></h2>
                        <p><?= h($v["description"]) ?></p>
                        <a href="interviewtool_detail.php?category_type_id=<?= h($v["category_type_id"]) ?>" class="btn btn-primary">
                            始める
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- FIXME:表示を2x3とかにしたい -->
    <!-- FIXME:【メモ】3項目前提のコードになってます -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>