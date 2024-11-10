<!-- 

・chatに流し込む質問を順番通りに取得する
A)question_tableから順番通りに質問配列を取得 -> $question_texts

・

-->



<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$category_id = $_SESSION["category_id"];

// A)question_tableから順番通りに質問配列を取得
$sql_select = "SELECT c.category_id, q.question_id, q.question_text, q.question_order FROM question_table q INNER JOIN category_table c ON q.category_id = c.category_id WHERE c.category_id = :category_id AND q.question_order != 0 ORDER BY q.question_order;";
$stmt = $pdo->prepare($sql_select);
$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$status = $stmt->execute();
// SQLエラー確認
if ($status == false) {
    sql_error($stmt);
}
// 全データ取得
$values = $stmt->fetchAll(PDO::FETCH_ASSOC); // 全レコードを取得
$question_texts = array_column($values, 'question_text');

echo '<pre>';
var_dump($question_texts);
echo '</pre>';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>デプスインタビュー</title>
    <style>
        .chat-container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
        }

        .chat-box {
            border: 1px solid #ddd;
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            margin-bottom: 10px;
        }

        .message {
            margin: 5px 0;
            padding: 8px;
            border-radius: 4px;
        }

        .interviewer {
            background-color: #f0f0f0;
            margin-right: 20%;
        }

        .user {
            background-color: #e3f2fd;
            margin-left: 20%;
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <div class="chat-box" id="chat-box"></div>
        <button id="start-interview">インタビュー開始</button>
        <div>
            <input type="text" id="user-input" placeholder="回答を入力してください" disabled>
            <button id="send" disabled>送信</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="config_chat.js"></script>
    <script src="interview.js"></script>
    <script>
        // インタビューマネージャーの初期化
        $(document).ready(function() {
            const interview = new InterviewManager();
        });
    </script>







</body>

</html>