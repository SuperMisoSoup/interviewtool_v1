<?php
include("funcs.php");
session_start();
sschk();

$questions = $_POST['questions'];
var_dump($questions);

// A)questionテーブル登録
if (!empty($questions)) {
    foreach ($questions as $question) {
        $pdo = db_conn();
        $stmt = $pdo->prepare("INSERT INTO question_table (category_type_id, question_text) VALUES (:category_type_id, :question_text)");

        $stmt->bindValue(':category_id', $_SESSION["category_id"], PDO::PARAM_INT);
        $stmt->bindValue(':question_text', $question, PDO::PARAM_STR);

        // 実行
        $status = $stmt->execute();

        // SQLエラーの確認
        if ($status == false) {
            sql_error($stmt);
        }
    }
    // 完了メッセージやリダイレクト処理
    header("Location: chat.php");
    exit;
} else {
    echo "質問が見つかりませんでした。";
}
?>