<!-- 
・質問を手動で追加
A)入力内容をquestion_tableにINSERT
-->

<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$category_id                = $_SESSION["category_id"];
$_SESSION["category_id"]    = $category_id;
$question_text              = $_POST["question_text"];

// A)入力内容をquestion_tableにINSERT
$sql = "INSERT INTO question_table(category_id, question_text) VALUES(:category_id, :question_text)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$stmt->bindValue(':question_text', $question_text, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("interviewtool_question.php");
}

?>