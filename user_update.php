<?php
session_start();
include("funcs.php");
$pdo = db_conn();
sschk();

$name       = $_POST["name"];
$login_id   = $_POST["login_id"];
$password   = $_POST["password"];
$user_id    = $_POST["user_id"];

$password   = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE user_table SET name=:name,login_id=:login_id, password=:password WHERE user_id=:user_id");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':login_id', $login_id, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    redirect("user_select.php");
}
