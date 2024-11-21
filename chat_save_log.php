<!-- 
chat.phpから呼び出してチャットログを保存
-->

<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

try{
$chat_log_order = $_POST['chat_log_order'];
$chat_by = $_POST['chat_by'];
$chat_text = $_POST['chat_text'];
$for_question_id = $_POST['for_question_id'];
$dig_count = $_POST['dig_count'];

$sql = "INSERT INTO chat_log_table (chat_log_order, chat_by, chat_text, for_question_id, dig_count) 
        VALUES (:chat_log_order, :chat_by, :chat_text, :for_question_id, :dig_count)";
// TODO: 回答者のidも登録する必要あり

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':chat_log_order', $chat_log_order, PDO::PARAM_INT);
$stmt->bindValue(':chat_by', $chat_by, PDO::PARAM_STR);
$stmt->bindValue(':chat_text', $chat_text, PDO::PARAM_STR);
$stmt->bindValue(':for_question_id', $for_question_id, PDO::PARAM_INT);
$stmt->bindValue(':dig_count', $dig_count, PDO::PARAM_INT);

    // 実行
    $status = $stmt->execute();
    if ($status === false) {
        // エラーハンドリング
        $error = $stmt->errorInfo();
        echo json_encode(["status" => "error", "message" => $error[2]]);
    } else {
        echo json_encode(["status" => "success"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>