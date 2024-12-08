<?php
session_start();
include("funcs.php");
$pdo = db_conn();
sschk();

$user_id = $_GET["user_id"];

$stmt = $pdo->prepare("UPDATE user_table SET resigned_flg = 0 WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    redirect("user_select.php");
}
