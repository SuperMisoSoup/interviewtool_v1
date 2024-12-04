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
$target_detail      = filter_input(INPUT_POST, "target_detail");
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
$generated_data = str_replace(['`json', '`'], ['', ''], generate_question_v1($category_type, $core_purpose, $core_issue, $service_feature, $competition, $service_url));
$generated_data = json_decode($generated_data, true);
// // 確認用
// echo '<pre>';
// var_dump($generated_data);
// echo '</pre>';


// D)DB登録
// トランザクション開始
$pdo->beginTransaction();

try {
    $section_order = 1;

    foreach ($generated_data['scenario'] as $scenario) {
        foreach ($scenario['section'] as $section) {
            // section_tableに挿入
            $stmt = $pdo->prepare("
                INSERT INTO section_table (category_id, section_text, section_order, delete_flg, created_at, updated_at)
                VALUES (:category_id, :section_text, :section_order, 0, NOW(), NOW())
            ");
            $stmt->bindValue(':category_id', $lastInsertId, PDO::PARAM_INT);
            $stmt->bindValue(':section_text', $section['section_text'], PDO::PARAM_STR);
            $stmt->bindValue(':section_order', $section_order++, PDO::PARAM_INT);
            $stmt->execute();

            $sectionId = $pdo->lastInsertId();

            $question_order = 1;

            foreach ($section['questions'] as $question) {
                // question_tableに挿入
                $stmt = $pdo->prepare("
                    INSERT INTO question_table (section_id, question_text, question_purpose, question_order, delete_flg, created_at, deleted_at)
                    VALUES (:section_id, :question_text, :question_purpose, :question_order, 0, NOW(), NULL)
                ");
                $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
                $stmt->bindValue(':question_text', $question['question_text'], PDO::PARAM_STR);
                $stmt->bindValue(':question_purpose', $question['question_purpose'], PDO::PARAM_STR);
                $stmt->bindValue(':question_order', $question_order++, PDO::PARAM_INT);
                $stmt->execute();

                $questionId = $pdo->lastInsertId();

                $dig_point_order = 1;

                for ($i = 1; $i <= 2; $i++) {
                    $digPointKey = "dig_point_$i";
                    if (!empty($question[$digPointKey])) {
                        // dig_point_tableに挿入
                        $stmt = $pdo->prepare("
                            INSERT INTO dig_point_table (for_question_id, dig_point_text, dig_point_order, delete_flg, created_at, updated_at)
                            VALUES (:for_question_id, :dig_point_text, :dig_point_order, 0, NOW(), NOW())
                        ");
                        $stmt->bindValue(':for_question_id', $questionId, PDO::PARAM_INT);
                        $stmt->bindValue(':dig_point_text', $question[$digPointKey], PDO::PARAM_STR);
                        $stmt->bindValue(':dig_point_order', $dig_point_order++, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
            }
        }
    }

    // トランザクションをコミット
    $pdo->commit();
} catch (Exception $e) {
    // エラーが発生した場合はロールバック
    $pdo->rollBack();
    die("データ登録エラー: " . $e->getMessage());
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
    header("Location: interviewtool_question2.php");
    exit();
}

?>