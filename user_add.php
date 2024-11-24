<?php
session_start();
include "funcs.php";
// sschk();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>USERデータ登録</title>
  <!-- Bootstrap 5.3.0 CSSの追加 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 50px;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="mb-4 bg-light py-3">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <span><?php echo $_SESSION["name"]; ?>さん</span>
        <a href="login.php" class="btn btn-primary">ログイン画面へ</a>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <h1 class="text-center mb-4">ユーザー登録</h1>
    <form method="post" action="user_insert.php">
      <fieldset>
        <legend class="mb-3">登録情報</legend>

        <!-- 名前 -->
        <div class="mb-3">
          <label for="name" class="form-label">名前</label>
          <input type="text" id="name" name="name" class="form-control">
        </div>

        <!-- Login ID -->
        <div class="mb-3">
          <label for="login_id" class="form-label">Login ID</label>
          <input type="text" id="login_id" name="login_id" class="form-control">
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

  <!-- Bootstrap 5.3.0 JSの追加 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>