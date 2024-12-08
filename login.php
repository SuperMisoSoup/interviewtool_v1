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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
  body {
    padding-top: 50px;
  }
</style>

<body class="align-items-center bg-light">
  <!-- Header -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <div class="navbar-brand">AI InterView</div>
      </div>
    </nav>
  </header>

  <!-- ログインフォーム -->
  <div class="container px-4 py-5">
    <h1 class="pb-2 border-bottom">ログイン</h1>
    <form name="form1" action="login_act.php" method="post"> <!-- post送信 -->
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
</body>

</html>