<?php
include("funcs.php");
session_start();
sschk();

//GETデータ取得
$category_type_id = $_GET["category_type_id"];

//データ参照SQL
$pdo = db_conn();
$sql_select_question = "SELECT * FROM category_type_table WHERE category_type_id=:category_type_id;";
$stmt = $pdo->prepare($sql_select_question);
$stmt->bindValue(":category_type_id", $category_type_id, PDO::PARAM_INT);
$status = $stmt->execute();
//SQLエラー確認
if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}

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

<!-- body -->
<body class="bg-light">
    <form method="post" action="interviewtool_create.php">
        <div class="container px-4 py-5" id="hanging-icons">
            <h2 class="pb-2 border-bottom">
                <?php
                echo $row["category_type"];
                ?>
            </h2>
            <input type="hidden" name="category_type_id" value="<?= $category_type_id ?>">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">サービス名を教えてください</label>
                <input type="text" class="form-control" id="basic-url" name="service_name" aria-describedby="basic-addon3 basic-addon4">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">サービスURLがあれば教えてください</label>
                <input type="text" class="form-control" id="basic-url" name="service_url" aria-describedby="basic-addon3 basic-addon4">
                <!-- <div class="form-text" id="basic-addon4">任意</div> -->
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">詳しい目的を教えてください</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="description" placeholder="SEO対策とリピート率改善を図りたい" rows="3"></textarea>
            </div>

            <div class="position-relative">
                <div class="position-absolute top-0 end-0">
                    <input type="submit" value="インタビューを生成" class="btn btn-primary">
                </div>
            </div>

        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>