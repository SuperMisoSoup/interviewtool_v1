<!-- 
ユーザの一覧を表示させる
    ->編集画面に遷移

-->


<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$admin_flg = $_SESSION["admin_flg"];

$sql = "SELECT * FROM user_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if ($status == false) {
    sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values, JSON_UNESCAPED_UNICODE);

// // 確認用
// echo '<pre>';
// var_dump($values);
// echo '</pre>';

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

        .accordion {
            padding-top: 50px;
        }

        .accordion-collapse.show {
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
</head>

<!-- ナビゲーションバー -->
<?php create_header($admin_flg); ?>

<body class="bg-light">
    <div class="container px-4 py-5" id="hanging-icons">
        <h1 class="pb-2 border-bottom">ユーザ一覧</h1>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <thead>
                        <tr>
                            <th class="list1">名前</th>
                            <th class="list2">ログインID</th>
                            <th class="list3"></th>
                            <th class="list4"></th>
                            <th class="list5"></th>
                        </tr>
                    </thead>
                <tbody>
                    <?php foreach ($values as $v) { ?>
                        <tr>
                            <td class="align-middle"><?= $v['name'] ?></td>
                            <td class="align-middle"><?= $v['login_id'] ?></td>

                            <?php if ($v["admin_flg"] == 0) { ?>
                                <td class="align-middle"></td>
                            <?php } else { ?>
                                <td class="align-middle">管理者</td>
                            <?php } ?>
                            <?php if ($v["resigned_flg"] == 0) { ?>
                                <td class="align-middle"><a href="user_delete.php?user_id=<?= $v["user_id"] ?>" class="btn btn-sm btn-outline-dark">退職に変更</a></td>
                            <?php } else { ?>
                                <td class="align-middle"><a href="user_revive.php?user_id=<?= $v["user_id"] ?>" class="btn btn-sm btn-outline-primary">復活させる</a></td>
                            <?php } ?>
                            <td class="align-middle"><a href="user_edit.php?user_id=<?= $v["user_id"] ?>" class="btn btn-sm btn-outline-primary">編集</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>