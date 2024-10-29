<?php
//1. POSTデータ取得
$question_id = $_GET["question_id"];

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ削除SQL作成
$stmt = $pdo->prepare("DELETE FROM question WHERE question_id=:question_id");
$stmt->bindValue(':question_id', $question_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
  sql_error($stmt);
} else {
  redirect("interview_create.php");
}
?>