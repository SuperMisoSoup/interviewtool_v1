<!-- 
ユーザの入力をOpenAIにAPI連携して質問を生成

A)category DB登録
B)target DB登録
C)質問生成
D)question DB登録

-->


<?php
include("funcs.php");
session_start();
sschk();

// POSTデータ取得
$category_type_id   = filter_input(INPUT_POST, "category_type_id");
$service_name       = filter_input(INPUT_POST, "service_name");
$core_purpose       = filter_input(INPUT_POST, "core_purpose");
$core_issue         = filter_input(INPUT_POST, "core_issue");
$service_feature    = filter_input(INPUT_POST, "service_feature");
$competition        = filter_input(INPUT_POST, "competition");
$service_url        = filter_input(INPUT_POST, "service_url");
// $user_id         = filter_input(INPUT_POST, "user_id");
foreach ($_POST as $key => $value) {
    if (strpos($key, 'target_gender') === 0) {
        $target_gender[] = $value;
    }
}
foreach ($_POST as $key => $value) {
    if (strpos($key, 'target_age') === 0) {
        $target_age[] = $value;
    }
}

// 確認用
echo '<pre>';
var_dump($core_purpose);
var_dump($service_feature);
var_dump($competition);
var_dump($target_gender);
var_dump($target_age);
echo '</pre>';


// A)category DB登録
try {
    $pdo = db_conn();
    $stmt = $pdo->prepare("INSERT INTO category_table (category_type_id, service_name, core_purpose, core_issue, service_feature, competition, service_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$category_type_id, $service_name, $core_purpose, $core_issue, $service_feature, $competition, $service_url]);

    // 最後に挿入されたIDを取得
    $lastInsertId = $pdo->lastInsertId();
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}

// // B)category_target DB登録
$stmt = $pdo->prepare("INSERT INTO category_target_table (category_id, target_type_id, target_id) VALUES (?, ?, ?)");
foreach ($target_age as $age) {
    $stmt->bindValue(1, $lastInsertId);
    $stmt->bindValue(2, 1);
    $stmt->bindValue(3, $age);
    $stmt->execute();
}
foreach ($target_gender as $gender) {
    $stmt->bindValue(1, $lastInsertId);
    $stmt->bindValue(2, 2);
    $stmt->bindValue(3, $gender);
    $stmt->execute();
}

// C)質問生成
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
$core_purpose   = $row["core_purpose"];
$service_url    = $row["service_url"];
$generated_question = str_replace(['`json', '`'], ['', ''], generate_question_v1($category_type, $core_purpose, $core_issue, $service_feature, $competition, $service_url));
$generated_questions = json_decode($generated_question, true);
// // 確認用
// echo '<pre>';
// var_dump($generated_question);
// echo '</pre>';

// D)question DB登録
$stmt = $pdo->prepare("INSERT INTO question_table (category_id, question_text) VALUES (?, ?)");
foreach ($generated_questions as $gq) {
    $stmt->bindValue(1, $lastInsertId);
    $stmt->bindValue(2, $gq);
    $stmt->execute();
}

// サーバで値を保持しておく
$_SESSION["category_id"] = $lastInsertId;


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