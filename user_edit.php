<?php
session_start();
include "funcs.php";
sschk();
$pdo = db_conn();

$admin_flg = $_SESSION["admin_flg"];
$user_id = $_GET["user_id"];

$stmt = $pdo->prepare("SELECT * FROM user_table WHERE user_id=:user_id");
$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

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
    <title>ユーザ登録</title>
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
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <a class="navbar-brand" href="interviewtool_category.php">AI InterView</a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">インタビューシナリオ</a>
                    </li>
                    <?php if ($admin_flg == 1) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">ユーザ管理</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="user_add.php">ユーザ追加</a></li>
                                <li><a class="dropdown-item" href="#">ユーザ編集</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body class="bg-light">
    <!-- Main Content -->
    <div class="container px-4 py-5">
        <h1 class="pb-2 border-bottom">ユーザ編集</h1>
        <form method="post" action="user_update.php">
            <fieldset>
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <!-- 名前 -->
                <div class="mb-3">
                    <label for="name" class="form-label">名前</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $row["name"] ?>">
                </div>

                <!-- Login ID -->
                <div class="mb-3">
                    <label for="login_id" class="form-label">Login ID</label>
                    <input type="text" id="login_id" name="login_id" class="form-control" value="<?= $row["login_id"] ?>">
                </div>

                <!-- Login PW -->
                <div class="mb-3">
                    <label for="password" class="form-label">Login PW</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>

                <!-- 管理FLG -->
                <div class="mb-3">
                    <label class="form-label">管理FLG</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="admin_flg" id="general" value="0">
                        <label class="form-check-label" for="general">一般</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="admin_flg" id="admin" value="1">
                        <label class="form-check-label" for="admin">管理者</label>
                    </div>
                </div>

                <!-- 登録ボタン -->
                <button type="submit" class="btn btn-primary">登録</button>
            </fieldset>
        </form>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>