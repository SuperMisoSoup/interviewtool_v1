<?php
session_start();

//POST値
$login_id = $_POST["login_id"];
$password = $_POST["password"];

//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

//2. データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM user_table WHERE login_id=:login_id");
$stmt->bindValue(':login_id', $login_id, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//3. SQL実行時にエラーがある場合STOP
if ($status == false) {
  sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得する方法

//5.該当１レコードがあればSESSIONに値を代入
//入力したPasswordと暗号化されたPasswordを比較！[戻り値：true,false]
$pw = password_verify($password, $val["password"]); //$password = password_hash($password, PASSWORD_DEFAULT);   //パスワードハッシュ化
if ($val["resigned_flg"]) {
  //退職時(login.phpへ)
  redirect("login.php");
} else {
  if ($pw) { //trueなら
    //Login成功時$_SESSIONに値を代入
    $_SESSION["chk_ssid"]  = session_id(); //session_IDを取得して代入
    $_SESSION["admin_flg"] = $val['admin_flg'];
    $_SESSION["name"]      = $val['name'];
    //Login成功時（select.phpへ）
    redirect("interviewtool_category.php");
  } else {
    //Login失敗時(login.phpへ)
    redirect("login.php");
  }
}
exit();
?>