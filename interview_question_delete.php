<?php
//1. POSTデータ取得
$question_id = $_GET["question_id"];

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ削除(delete_flg=1)SQL作成
$sql_update = "UPDATE question_table SET delete_flg=1 WHERE question_id=:question_id";
$stmt = $pdo->prepare($sql_update);
$stmt->bindValue(':question_id', $question_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
  sql_error($stmt);
} else {
  redirect("interviewtool_question.php");
}
?>