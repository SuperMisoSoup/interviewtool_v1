<?php

//1. POSTデータ取得
$question_id = $_POST["question_id"];
$question_text = $_POST["question_text"];

//2. DB接続
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql_update = "UPDATE question_table SET question_text=:question_text WHERE question_id=:question_id";
// TODO:UPDATE文を作る

$stmt = $pdo->prepare($sql_update);
$stmt->bindValue(':question_id', $question_id, PDO::PARAM_INT);
$stmt->bindValue(':question_text', $question_text, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("interviewtool_question.php");
}
?>