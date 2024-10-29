<?php
//$_SESSION使うよ！
session_start();
include "funcs.php";
//sschk();

//1. POSTデータ取得
$name      = filter_input( INPUT_POST, "name" );
$login_id       = filter_input( INPUT_POST, "login_id" );
$password       = filter_input( INPUT_POST, "password" );
$admin_flg = filter_input( INPUT_POST, "admin_flg" );
$password       = password_hash($password, PASSWORD_DEFAULT);   //パスワードハッシュ化

//2. DB接続
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO user_table(login_id,name,password,admin_flg,resigned_flg)VALUES(:login_id,:name,:password,:admin_flg,0)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':login_id', $login_id, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':password', $password, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':admin_flg', $admin_flg, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("user_add.php");
}
