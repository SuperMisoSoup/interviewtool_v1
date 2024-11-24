<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$category_id                = $_SESSION["category_id"];
$_SESSION["category_id"]    = $category_id;
$generated_question         = $_SESSION["generated_question"];
$generated_questions = json_decode($generated_question, true);
var_dump($generated_questions);

// カテゴリタイプtableの参照
$sql_select_category = "SELECT * FROM category_table c INNER JOIN category_type_table ct ON c.category_type_id = ct.category_type_id WHERE c.category_id =" . $category_id . ";";
$stmt_category = $pdo->prepare($sql_select_category);
$status_category = $stmt_category->execute();
// SQLエラー確認
if ($status_category == false) {
    sql_error($stmt_category);
}
// 全データ取得
$values_category =  $stmt_category->fetch(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>インタビュー設計</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <style>
        body {
            padding-top: 50px;
        }
    </style>
</head>

<!-- ナビゲーションバー -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">インタビュー管理システム</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</header>

<body class="bg-light">
    <form id="questionForm" method="post" action="interviewtool_question_insert.php">
        <div class="container mt-4">

            <!-- 作成済み質問の表示 -->
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0">質問リスト</h2>
                </div>
                <div class="card-body">
                    <p><span class="font-weight-bold">カテゴリ</span>：<?= h($values_category["category_type"]) ?></p>
                    <p><span class="font-weight-bold">詳細目的</span>：<?= h($values_category["core_purpose"]) ?></p>
                    <p><span class="font-weight-bold">URL</span>：<?= h($values_category["service_url"]) ?></p>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>質問</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                <?php foreach ($generated_questions as $question) : ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="questions[]" value="<?= htmlspecialchars($question, ENT_QUOTES, 'UTF-8'); ?>">
                                            <span class="question-text"><?= htmlspecialchars($question, ENT_QUOTES, 'UTF-8'); ?></span>
                                        </td>
                                        <td>
                                            <!-- 編集ボタン -->
                                            <button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-index="<?= $index; ?>">編集</button>

                                            <!-- 削除ボタン -->
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-index="<?= $index; ?>">削除</button>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button type="submit" id="saveOrderBtn" class="btn btn-primary">チャットを開始</button>
        </div>
    </form>

    <script>
        $(function() {
            $("#sortable").sortable();
        });

        $(document).ready(function() {
            // 編集ボタンのクリックイベント
            $('.edit-btn').click(function(event) {
                event.preventDefault(); // デフォルトのフォーム送信を防止

                let questionTextElem = $(this).closest('tr').find('.question-text');
                let inputHiddenElem = $(this).closest('tr').find('input[type="hidden"]');
                let currentText = questionTextElem.text();

                // 編集用のウィンドウを表示し、新しい質問内容を取得
                let newQuestion = prompt("質問内容を編集してください:", currentText);
                if (newQuestion !== null && newQuestion !== "") {
                    questionTextElem.text(newQuestion); // 表示テキストを更新
                    inputHiddenElem.val(newQuestion); // 隠しフィールドの値も更新
                }
            });

            // 削除ボタンのクリックイベント
            $('.delete-btn').click(function(event) {
                event.preventDefault(); // デフォルトのフォーム送信を防止

                if (confirm("この質問を削除しますか？")) {
                    $(this).closest('tr').remove();
                }
            });
        });
    </script>
</body>

</html>