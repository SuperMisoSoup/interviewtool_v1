<!--
インタビュー企画者がシナリオ生成に必要な情報を入力

A)項目の入力と各情報の送信
B)AIチャットボットと会話して入力のヒントを得る

-->


<?php
include("funcs.php");
session_start();
sschk();

//GETデータ取得
$category_type_id = $_GET["category_type_id"];

//データ参照SQL
$pdo = db_conn();
$sql_category_type = "SELECT * FROM category_type_table WHERE category_type_id=:category_type_id;";
$sql_age = "SELECT target_age_id AS id, target_age FROM target_age_table";
$sql_gender = "SELECT target_gender_id AS id, target_gender FROM target_gender_table";

$stmt = $pdo->prepare($sql_category_type);
$stmt->bindValue(":category_type_id", $category_type_id, PDO::PARAM_INT);
$status = $stmt->execute();

$stmt_age = $pdo->prepare($sql_age);
$status_age = $stmt_age->execute();

$stmt_gender = $pdo->prepare($sql_gender);
$status_gender = $stmt_gender->execute();

//SQLエラー確認
if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}

// 全データ取得
$result_age =  $stmt_age->fetchAll(PDO::FETCH_ASSOC);
$result_gender =  $stmt_gender->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>カテゴリ選択</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
        }

        .accordion {
            padding-top: 50px;
        }

        .accordion-collapse.show {
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
</head>

<!-- ナビゲーションバー -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">カテゴリ選択</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</header>


<body class="bg-light">
    <div class="container">
        <div class="row row justify-content-center">
            <!-- A)項目の入力と各情報の送信 -->
            <div class="col-md-7">
                <form method="post" action="interviewtool_create.php" id="InterviewForm">
                    <div class="container px-4 py-5" id="hanging-icons">
                        <h2 class="pb-2 border-bottom">
                            <?php
                            echo $row["category_type"];
                            ?>
                        </h2>
                        <input type="hidden" name="category_type_id" value="<?= $category_type_id ?>">
                        <!-- <h3>サービス情報</h3> -->
                        <div class="mb-3">
                            <label for="service_name" class="form-label">サービス名</label>
                            <input type="text" class="form-control" id="service_name" name="service_name">
                        </div>

                        <div class="mb-3">
                            <label for="service_url" class="form-label">サービスURL</label>
                            <input type="text" class="form-control" id="service_url" name="service_url">
                            <!-- <div class="form-text" id="basic-addon4">任意</div> -->
                        </div>

                        <div class="mb-3">
                            <label for="service_feature" class="form-label">サービスの特徴</label>
                            <textarea class="form-control" id="service_feature" name="service_feature" placeholder="ポイントサービスとして多数の加盟店を保有しており、経済圏を構築できている" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="competition" class="form-label">競合サービス</label>
                            <textarea class="form-control" id="competition" name="competition" placeholder="インタビューポイント、AIポイント" rows="2"></textarea>
                        </div>

                        <!-- <h3>インタビュー内容</h3> -->
                        <div class="mb-3">
                            <label for="core_purpose" class="form-label">インタビューの目的</label>
                            <textarea class="form-control" id="core_purpose" name="core_purpose" placeholder="ユーザーの普段のサービス利用方法と使い方の解像度を上げたい" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="core_issue" class="form-label">明確にしたい課題</label>
                            <textarea class="form-control" id="core_issue" name="core_issue" placeholder="ポイントサービスのアクティブユーザーを増やしたい" rows="2"></textarea>
                        </div>

                        <!-- <h3>インタビューターゲット</h3> -->
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">ターゲットとなるユーザ</label>
                            <div id="target-checkboxes">
                                <div id="gender-checkboxes" name="target_gender"></div>
                                <div id="age-checkboxes" name="target_age"></div>
                            </div>
                            <div class="text-danger" id="error-message"></div>
                        </div>

                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0">
                                <input type="submit" value="インタビューを生成" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- B)AIチャットボットと会話して入力のヒントを得る -->
            <div class="col-md-5">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                AIに相談
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="chat-box" style="padding-bottom: 50px; height: calc(80vh - 120px); overflow-y: auto;" id="chat-box"></div>
                                <div class="input-group" style="position: sticky; bottom: 0; background: white;">
                                    <input type="text" class="form-control" id="chat-input" placeholder="メッセージを入力">
                                    <button class="btn btn-primary" onclick="sendMessage()">送信</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // ターゲットユーザのチェックボックスの生成
            function createCheckboxes(targetElementId, data, name, labelKey) {
                const targetElement = document.getElementById(targetElementId);

                data.forEach(item => {
                    const checkboxDiv = document.createElement('div');
                    checkboxDiv.classList.add('form-check', 'form-check-inline');

                    const input = document.createElement('input');
                    input.classList.add('form-check-input');
                    input.type = 'checkbox';
                    input.id = `${targetElementId}-${item.id}`;
                    input.name = `${name}_${item.id}`;
                    input.value = item.id;

                    const label = document.createElement('label');
                    label.classList.add('form-check-label');
                    label.htmlFor = input.id;
                    label.textContent = item[labelKey];

                    checkboxDiv.appendChild(input);
                    checkboxDiv.appendChild(label);
                    targetElement.appendChild(checkboxDiv);
                });
            }

            const ages = <?php echo json_encode($result_age); ?>;
            const genders = <?php echo json_encode($result_gender); ?>;

            createCheckboxes('age-checkboxes', ages, 'target_age', 'target_age');
            createCheckboxes('gender-checkboxes', genders, 'target_gender', 'target_gender');

            // チェックボックスが一つも選択されていないときにアラート
            const myForm = document.getElementById('InterviewForm');
            const errorMessage = document.getElementById('error-message');

            // namePrefixのnameを持ちチェックが入ったチェックボックスの数を数える
            function getCheckedValues(namePrefix) {
                const checkboxes = document.querySelectorAll(`input[name^="${namePrefix}"]`);
                const checkedValues = [];

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        checkedValues.push(checkbox.value);
                    }
                });
                return checkedValues;
            }
            myForm.addEventListener('submit', (event) => {
                const checkedGenders = getCheckedValues('target_gender_');
                const checkedAges = getCheckedValues('target_age_');

                // 性別と年齢のいずれか一つも選択されていない場合、送信を阻止し、エラーメッセージを表示
                if (checkedGenders.length === 0 || checkedAges.length === 0) {
                    event.preventDefault();
                    errorMessage.textContent = '性別と年齢のいずれか一つ以上を選択してください。';
                } else {
                    errorMessage.textContent = ''; // エラーメッセージをクリア
                }
            });
        </script>

        <script src="config.php"></script>
        <script>
            const CONFIG = {
                API_ENDPOINT: 'https://api.openai.com/v1/chat/completions',
                API_KEY: '<?= htmlspecialchars(OPENAI_API_KEY, ENT_QUOTES, 'UTF-8') ?>',
                MODEL: 'gpt-4o-mini',
                SYSTEM_PROMPT: `あなたは相談役としてユーザが情報を入力するのを手伝ってください。ユーザはインタビューを生成するのに必要な情報を整理できずに困ってあなたに相談します。
                                項目は「サービスの特徴」「インタビューの目的」「明確にしたい課題」です。それぞれの項目でユーザの意図をくみ取り、以下のような入力値をユーザに提示してください。それ以外の質問に関しては丁寧に回答を断ってください。

                                サービスの特徴：ポイントサービスとして多数の加盟店を保有しており、経済圏を構築できている
                                インタビューの目的：ユーザの普段のサービス利用方法と使い方の解像度を上げたい
                                明確にしたい課題：ポイントサービスのアクティブユーザを増やしたい`
            };
        </script>

        <script>
            // B)AIチャットボットと会話して入力のヒントを得る
            async function sendMessage() {
                const chatInput = document.getElementById("chat-input");
                const chatBox = document.getElementById("chat-box");
                const userMessage = chatInput.value.trim();

                if (userMessage === "") return; // 空メッセージの送信を防止

                // ユーザーのメッセージをチャットボックスに表示
                const userMessageDiv = document.createElement("div");
                userMessageDiv.className = "alert alert-primary text-end";
                userMessageDiv.style.marginLeft = "auto";
                userMessageDiv.style.maxWidth = "80%";
                userMessageDiv.textContent = "あなた: " + userMessage;
                chatBox.appendChild(userMessageDiv);
                chatBox.scrollTop = chatBox.scrollHeight;

                // メッセージをクリア
                chatInput.value = "";

                // 「AIが入力中…」メッセージを左側に表示
                const typingIndicator = document.createElement("div");
                typingIndicator.className = "alert alert-secondary text-start";
                typingIndicator.style.marginRight = "auto";
                typingIndicator.style.maxWidth = "80%";
                typingIndicator.textContent = "AIが入力中...";
                chatBox.appendChild(typingIndicator);
                chatBox.scrollTop = chatBox.scrollHeight;

                const data = {
                    model: CONFIG.MODEL,
                    messages: [{
                            role: "system",
                            content: CONFIG.SYSTEM_PROMPT
                        },
                        {
                            role: "user",
                            content: userMessage
                        }
                    ]
                };

                // APIリクエストの実行
                try {
                    const response = await fetch(CONFIG.API_ENDPOINT, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": `Bearer ${CONFIG.API_KEY}`
                        },
                        body: JSON.stringify(data)
                    });
                    const result = await response.json();

                    // AIの「入力中…」メッセージを削除
                    chatBox.removeChild(typingIndicator);

                    // AIの返信メッセージを左側に表示
                    const aiMessage = result.choices[0].message.content;
                    const aiMessageDiv = document.createElement("div");
                    aiMessageDiv.className = "alert alert-secondary text-start";
                    aiMessageDiv.style.marginRight = "auto"; // 左側に表示
                    aiMessageDiv.style.maxWidth = "80%"; // 横幅制限
                    aiMessageDiv.textContent = "AI: " + aiMessage;
                    chatBox.appendChild(aiMessageDiv);
                    chatBox.scrollTop = chatBox.scrollHeight;

                } catch (error) {
                    // 「入力中…」メッセージを削除
                    chatBox.removeChild(typingIndicator);

                    // エラーメッセージの表示
                    console.error("Error:", error);
                    const errorMessageDiv = document.createElement("div");
                    errorMessageDiv.className = "alert alert-danger text-start";
                    errorMessageDiv.style.marginRight = "auto"; // 左側に表示
                    errorMessageDiv.style.maxWidth = "80%";
                    errorMessageDiv.textContent = "エラーが発生しました。もう一度お試しください。";
                    chatBox.appendChild(errorMessageDiv);
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            }

            // Enterキーでメッセージを送信
            document.getElementById("chat-input").addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault(); // デフォルトのEnterの動作を防止
                    sendMessage();
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>