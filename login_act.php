<!-- 
・ログイン処理
  ->interviewtool_category.php
-->


<?php
session_start();

//POST値
$login_id = $_POST["login_id"];
$password = $_POST["password"];

// A)user_tableに接続
include("funcs.php");
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM user_table WHERE login_id=:login_id");
$stmt->bindValue(':login_id', $login_id, PDO::PARAM_STR);
$status = $stmt->execute(); //実行
if ($status == false) {
  sql_error($stmt);
}

$val = $stmt->fetch(); //1レコードだけ取得

$pw = password_verify($password, $val["password"]);
//$password = password_hash($password, PASSWORD_DEFAULT);   //パスワードハッシュ化
if ($val["resigned_flg"]) {
  //退職時(login.phpへ)
  redirect("login.php");
} else {
  if ($pw) { //trueなら
    //Login成功時$_SESSIONに値を代入
    $_SESSION["chk_ssid"]  = session_id(); //session_IDを取得して代入
    $_SESSION["admin_flg"] = $val['admin_flg'];
    $_SESSION["user_id"]      = $val['user_id'];
    //Login成功時（select.phpへ）
    redirect("interviewtool_category.php");
  } else {
    //Login失敗時(login.phpへ)
    redirect("login.php");
  }
}
?>