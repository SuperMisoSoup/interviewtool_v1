<!-- 
ユーザが作成したシナリオを表示
A)ユーザIDを基に表示するシナリオをSELECT
B)画面描画
-->

<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

//ログインデータ取得
$admin_flg = $_SESSION["admin_flg"];
$user_id = $_SESSION["user_id"];

// tableの参照
$sql_select = "
    SELECT 
        c.category_id,
        ct.category_type,
        c.service_name,
        c.core_purpose
    FROM 
        category_table AS c
    INNER JOIN
        category_type_table AS ct ON c.category_type_id = ct.category_type_id
    WHERE 
        c.user_id = :user_id
    ORDER BY 
        c.category_id;
";

//データ参照SQL
$stmt = $pdo->prepare($sql_select);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
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
    <title>インタビューシナリオ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
        }

        .list1 {
            width: 10%;
        }

        .list2 {
            width: 10%;
        }

        .list3 {
            width: 50%;
        }

        .list4 {
            width: 5%;
        }
    </style>
</head>

<!-- ナビゲーションバー -->
<?php create_header($admin_flg); ?>

<body class="bg-light">
    <div class="container px-4 py-5" id="hanging-icons">
        <h1 class="pb-2 border-bottom">作成済みインタビューシナリオ</h1>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th class="list1">カテゴリ</th>
                        <th class="list2">サービス名</th>
                        <th class="list3">インタビューの目的</th>
                        <th class="list4"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($values as $v) { ?>
                        <tr>
                            <td class="align-middle"><?= $v['category_type'] ?></td>
                            <td class="align-middle"><?= $v['service_name'] ?></td>
                            <td class="align-middle"><?= $v['core_purpose'] ?></td>
                            <td class="align-middle"><a href="interviewtool_question.php" class="btn btn-sm btn-outline-primary">表示</a></td>
                            <!-- FIXME:SESSIONにcategory_idがないとエラーになる -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>