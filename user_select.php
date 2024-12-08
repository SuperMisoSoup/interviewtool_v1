<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$pdo = db_conn();
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
$json = json_encode($values, JSON_UNESCAPED_UNICODE);

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
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <a class="navbar-brand" href="interviewtool_category.php">AI InterView</a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="interviewtool_scenario_view.php">インタビューシナリオ</a>
                    </li>
                    <?php if ($admin_flg == 1) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">ユーザ管理</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="user_add.php">ユーザ追加</a></li>
                                <li><a class="dropdown-item" href="#">ユーザ編集</a></li>
                                <!-- <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body id="main">
    <div>
        <div class="container jumbotron">

            <table>
                <?php foreach ($values as $v) { ?>
                    <tr>
                        <td><?= $v["id"] ?></td>
                        <?php if ($UserRoleId == "1") { ?>
                            <td><a href="user_edit.php?id=<?= $v["id"] ?>"><?= $v["name"] ?></a></td>
                            <td><?= $v["UserRole"] ?></td>
                            <?php if ($v["life_flg"] == "1") { ?>
                                <td><a href="user_delete.php?id=<?= $v["id"] ?>">[退職に変更]</a></td>
                            <?php } else { ?>
                                <td><a href="user_revive.php?id=<?= $v["id"] ?>">[復活させる]</a></td>
                            <?php } ?>
                        <?php } else { ?>
                            <td><a href="user_edit.php?id=<?= $v["id"] ?>"><?= $v["name"] ?></a></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </div>


    <script>
        const a = '<?php echo $json; ?>';
        console.log(JSON.parse(a));
    </script>
</body>

</html>