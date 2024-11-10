<!-- 

・登録された質問に対してquestion_orderカラムに順番を登録する
A)question_tableに登録済みのquestion_orderの削除
B)新しいquestion_orderの登録

-->

<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$category_id               = $_SESSION["category_id"];
$_SESSION["category_id"]   = $category_id;
$question_orders = explode(",", $_SESSION['question_order']);
echo '<pre>';
var_dump($question_orders);
echo '</pre>';

// A)question_tableに登録済みのquestion_orderの削除
$sql_reset = "UPDATE question_table SET question_order = '' WHERE category_id = " . $category_id . ";";
$stmt_reset = $pdo->prepare($sql_reset);
$status_reset = $stmt_reset->execute();

// B)新しいquestion_orderの登録
foreach ($question_orders as $index => $question_id) {
    $new_order = $index + 1;

    $sql_update = "UPDATE question_table SET question_order = :question_order WHERE question_id = :question_id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindValue(':question_order', $new_order, PDO::PARAM_INT);
    $stmt_update->bindValue(':question_id', $question_id, PDO::PARAM_INT);
    echo $question_id;
    $status_update = $stmt_update->execute();

    if ($status_update == false) {
        sql_error($stmt_update); // エラーメッセージの出力やエラーログの処理
    }
}
// 画面遷移
header("Location: chat.php");


?>