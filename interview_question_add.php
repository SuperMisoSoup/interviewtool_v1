<!-- 
・質問を手動で追加
A)入力画面
-->


<?php
include("funcs.php");
session_start();
sschk();
$pdo = db_conn();

$category_id               = $_SESSION["category_id"];
$_SESSION["category_id"]   = $category_id;


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>インタビュー設計 - 質問追加</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px;
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

<!-- A)入力画面 -->

<body class="bg-light">
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h2 class="h4 mb-0">質問追加</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="interview_question_insert.php">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="question_text" name="question_text" style="height: 100px" placeholder="質問"></textarea>
                        <label for="question_text">質問</label>
                    </div>
                    <button type="submit" class="btn btn-primary">追加</button>
                    <a href="interviewtool_question.php" class="btn btn-secondary">戻る</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 入力がNullのときにエラー表示
        document.querySelector("form").addEventListener("submit", function(event) {
            const questionText = document.getElementById("question_text").value.trim();
            if (questionText === "") {
                event.preventDefault();
                alert("質問を入力してください。");
            }
        });
    </script>
</body>

</html>