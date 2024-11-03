<?php
include("funcs.php");
session_start();
sschk();

// POSTデータ取得
$category_type_id   = filter_input(INPUT_POST, "category_type_id");
$description        = filter_input(INPUT_POST, "description");
$service_url        = filter_input(INPUT_POST, "service_url");
// $user_id         = filter_input(INPUT_POST, "user_id");


// A)category DB登録
try {
    $pdo = db_conn();
    $stmt = $pdo->prepare("INSERT INTO category_table (category_type_id, description, service_url) VALUES (?, ?, ?)");
    $stmt->execute([$category_type_id, $description, $service_url]);

    // 最後に挿入されたIDを取得
    $lastInsertId = $pdo->lastInsertId();
    // echo "category_id: " . $lastInsertId;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}


// B)質問生成
// 最後に登録されたcategoryを配列形式で取得
$stmt = $pdo->prepare("SELECT * FROM category_table AS c INNER JOIN category_type_table AS ct ON c.category_type_id = ct.category_type_id WHERE c.category_id=:category_id");
$stmt->bindValue(":category_id", $lastInsertId, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}

// OpenAI連携 質問生成
$category_type  = $row["category_type"];
$description    = $row["description"];
$service_url    = $row["service_url"];
$generated_question = json_decode(generate_question_v1($category_type, $description, $service_url));
var_dump($generated_question);

// C)question DB登録
$stmt = $pdo->prepare("INSERT INTO question_table (category_id, question_text) VALUES (?, ?)");
foreach ($generated_question as $gq) {
    $stmt->bindValue(1, $lastInsertId);
    $stmt->bindValue(2, $gq);
    $stmt->execute();
}

// 登録後処理
if ($stmt->errorCode() !== '00000') {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("SQLError:" . $error[2]);
    $error_update = $stmt_update->errorInfo();
    exit("SQLError_update:" . $error_update[2]);
} else {

    // 画面遷移
    header("Location: interviewtool_question.php");
    exit();
}
?>


<!-- 
TODO:POST値受け取り
        - category_type_id
        - description
        - service_url
        - user_id
TODO:API連携して質問を生成
TODO:ユーザ入力値と生成された質問をそれぞれDBに登録
-->