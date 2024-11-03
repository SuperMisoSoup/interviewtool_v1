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
            <div class="col d-flex align-items-start grid gap-0 column-gap-3">
                <div class="bg-body-secondary d-inline-flex align-items-center justify-content-center flex-shrink-0 rounded-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-window" viewBox="-4 -4 24 24">
                        <path d="M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                        <path d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm13 2v2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1M2 14a1 1 0 0 1-1-1V6h14v7a1 1 0 0 1-1 1z" />
                    </svg>
                </div>
                <div>
                    <h2 class="fs-2 text-body-emphasis">Webページ改善</h2>
                    <p>URLと目的を記載するだけで魅力的なWebページにするためのヒントを得ることができます</p>
                    <a href="interviewtool_detail.php?category_type_id=1" class="btn btn-primary">
                        始める
                    </a>
                </div>
            </div>
            <div class="col d-flex align-items-start grid gap-0 column-gap-3">
                <div class="bg-body-secondary d-inline-flex align-items-center justify-content-center flex-shrink-0 rounded-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-window" viewBox="-4 -4 24 24">
                        <path d="M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                        <path d="M14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM4 1a1 1 0 0 0-1 1v10l2.224-2.224a.5.5 0 0 1 .61-.075L8 11l2.157-3.02a.5.5 0 0 1 .76-.063L13 10V4.5h-2A1.5 1.5 0 0 1 9.5 3V1z" />
                    </svg>
                </div>
                <div>
                    <h2 class="fs-2 text-body-emphasis">クリエイティブのアドバイス</h2>
                    <p>URLと目的を記載するだけで魅力的なWebページにするためのヒントを得ることができます</p>
                    <a href="interviewtool_detail.php?category_type_id=2" class="btn btn-primary">
                        始める
                    </a>
                </div>
            </div>
            <div class="col d-flex align-items-start grid gap-0 column-gap-3">
                <div class="bg-body-secondary d-inline-flex align-items-center justify-content-center flex-shrink-0 rounded-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-window" viewBox="-4 -4 24 24">
                        <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                        <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8m0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" />

                    </svg>
                </div>
                <div>
                    <h2 class="fs-2 text-body-emphasis">CX改善</h2>
                    <p>URLと目的を記載するだけで魅力的なWebページにするためのヒントを得ることができます</p>
                    <a href="interviewtool_detail.php?category_type_id=3" class="btn btn-primary">
                        始める
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container mt-4">
        <div class="card mb-5 shadow">
            <div class="card-header bg-secondary text-white">
                <h2 class="h4 mb-0">カテゴリ選択</h2>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2 col-6 mx-auto"> -->
    <?php
    // // ボタンを表示
    // foreach ($values as $v) {
    //     echo '<a href="interviewtool_detail.php?category_type_id=' . $v['category_type_id'] . '">';
    //     echo '<button class="btn btn-primary" type="button">' . $v['category_type'] . '</button>';
    //     echo '</a>';
    // }
    ?>
    <!-- FIXME:表示を2x3とかにしたい -->
    <!-- </div>
            </div>
        </div>
    </div> -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>