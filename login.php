<!-- 
・ログイン画面
  ->login_act.php
-->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ログイン</title>
  <!-- Bootstrap 5.3.0 CSSの追加 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<header class="bg-light py-3 mb-4">
  <div class="container">
    <nav class="navbar navbar-light">
      <span class="navbar-brand mb-0 h1">LOGIN</span>
    </nav>
    <a href="user_add.php" class="btn btn-primary">アカウントを作成する</a>
  </div>
</header>

<!-- ログインフォーム -->
<div class="container">
  <form name="form1" action="login_act.php" method="post">  <!-- post送信 -->
  <div class="mb-3">
      <label for="login_id" class="form-label">ID</label>
      <input type="text" id="login_id" name="login_id" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">PW</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">ログイン</button>
  </form>
</div>

<!-- Bootstrap 5.3.0 JSの追加 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
