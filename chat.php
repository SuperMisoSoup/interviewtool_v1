<!-- 

・chatに流し込む質問を順番通りに取得する
A)question_tableから順番通りに質問配列を取得 -> $question_texts

B)チャットを実行

C)チャットログをDBに保存
・回答の都度保存する

-->

<?php
include("funcs.php");
session_start();
sschk(); //FIXME:配布URLとするならsschkは不要？
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
$questions = [];
foreach ($values as $value) {
    $questions[$value['question_order']] = [
        'question_id' => $value['question_id'],
        'question_text' => $value['question_text']
    ];
}

// // 確認用
// echo '<pre>';
// var_dump($questions);
// echo '</pre>';

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>デプスインタビュー</title>

    <!-- Bootstrap CSSの読み込み -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* メインコンテナのスタイル。全体の幅を設定し、中央に配置 */
        .chat-container {
            width: 100%;
            max-width: 40%;
            margin: 20px auto;
        }

        /* チャットボックスのスタイル */
        .chat-box {
            border: 1px solid #ddd;
            /* 枠線の色 */
            height: 700px;
            /* 高さ */
            overflow-y: auto;
            /* 縦スクロールを有効化 */
            padding: 15px;
            /* 内側の余白 */
            border-radius: 8px;
            /* 角を丸める */
            margin-bottom: 15px;
            /* 下の余白 */
            background-color: #f8f9fa;
            /* 背景色 */
        }

        /* チャットメッセージの共通スタイル */
        .message {
            padding: 10px;
            /* 内側の余白 */
            border-radius: 8px;
            /* 角を丸める */
            margin: 5px 0;
            /* 上下の余白 */
            max-width: 80%;
            /* 最大幅を80%に設定 */
        }

        /* インタビュアーのメッセージのスタイル */
        .interviewer {
            background-color: #f0f0f0;
            /* 背景色 */
            margin-right: auto;
            /* 左寄せ */
        }

        /* ユーザーのメッセージのスタイル */
        .user {
            background-color: #e3f2fd;
            /* 背景色 */
            margin-left: auto;
            /* 右寄せ */
        }

        /* 入力エリアのグループスタイル */
        .input-group {
            margin-top: 10px;
            /* 上の余白 */
        }

        /* 入力ボックスのサイズを大きく調整 */
        #user-input {
            height: 48px;
            /* 高さを48pxに設定 */
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <!-- チャットメッセージが表示される領域 -->
        <div class="chat-box" id="chat-box"></div>

        <!-- インタビュー開始ボタン -->
        <button id="start-interview" class="btn btn-primary w-100 mb-2">インタビュー開始</button>

        <!-- 入力エリア（回答入力ボックスと送信ボタン） -->
        <div class="input-group">
            <input type="text" id="user-input" class="form-control" placeholder="回答を入力してください" disabled> <!-- 入力ボックス、デフォルトで無効化 -->
            <button id="send" class="btn btn-success" disabled>送信</button> <!-- 送信ボタン、デフォルトで無効化 -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="config.php"></script>
    <script>
        const CONFIG = {
            API_ENDPOINT: 'https://api.openai.com/v1/chat/completions',
            API_KEY: '<?= htmlspecialchars(OPENAI_API_KEY, ENT_QUOTES, 'UTF-8') ?>',
            MODEL: 'gpt-4o-mini',
            SYSTEM_PROMPT: 'あなたはマーケターで、デプスインタビューの専門家です。以下のテーマに基づいて、サービスの未利用者向けに日本語でインタビューを実施してください。テーマ: 動向、競合調査、認知、入会検討、同様サービスの利用頻度や利用シーン。指定の質問は必ず質問して。回答に応じて具体的な深堀もして'
        };
    </script>

    <script>
        // DOMの読み込み完了後にインタビューの初期化を行う
        $(document).ready(function() {
            const interview = new InterviewManager();
        });
    </script>

    <script>
        // B)チャットを実行
        class InterviewManager {
            constructor() {
                this.questions = <?php echo json_encode($questions); ?>;
                this.currentQuestion = 0; // 質問のindex
                this.followUpCount = 0; // 深堀回数
                this.lastResponse = ""; // 前回の回答
                this.isInterviewStarted = false; //インタビュー開始かどうか
                this.conversationHistory = []; // json会話履歴({role:user, content:〇〇}, ...)
                this.chatLogOrder = 1; // 各チャットログごとにインクリメント

                this.initializeEventListeners();
            }

            async callGPT4(userInput) {
                try {
                    if (this.followUpCount > 2) {
                        return;
                    }

                    this.conversationHistory.push({
                        role: 'user',
                        content: userInput
                    });

                    const systemPrompt = `あなたは熟練したインタビュアーです。これは${this.followUpCount}回目のフォローアップです。
                        ${this.followUpCount === 1 || this.followUpCount === 2 ? 
                        '回答の具体性を評価し、より詳しい情報を引き出すための質問を1つだけ簡潔に行ってください。' : 
                        '初回の質問です。回答を確認してください。'}
                        前回の回答：「${this.lastResponse}」`;

                    const response = await $.ajax({
                        url: CONFIG.API_ENDPOINT,
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${CONFIG.API_KEY}`
                        },
                        data: JSON.stringify({
                            model: CONFIG.MODEL,
                            messages: [{
                                    role: 'system',
                                    content: systemPrompt
                                },
                                ...this.conversationHistory
                            ],
                            max_tokens: 200,
                            temperature: 0.7
                        })
                    });

                    const assistantReply = response.choices[0].message.content;
                    this.conversationHistory.push({
                        role: 'assistant',
                        content: assistantReply
                    });

                    return assistantReply;

                } catch (error) {
                    console.error('Error:', error);
                    this.addMessage(errorMessage, false);
                    return "申し訳ありません。エラーが発生しました。";
                }
            }

            addMessage(message, isUser, saveToDB = true) {
                const messageDiv = $('<div></div>')
                    .addClass('message')
                    .addClass(isUser ? 'user' : 'interviewer')
                    .text(message);
                $('#chat-box').append(messageDiv);
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

                // DBにメッセージを保存
                if (saveToDB) {
                    const chatBy = isUser ? 'user' : 'assistant';
                    const questionId = this.questions[this.currentQuestion + 1].question_id;
                    const digCount = this.followUpCount;

                    this.saveAnswerToDB(chatBy, message, questionId, digCount);
                }
            }

            async handleResponse(userInput) {
                this.lastResponse = userInput; // userの入力を保持
                this.addMessage(userInput, true); // `user`の回答を表示し、DBに保存

                const assistantResponse = await this.callGPT4(userInput);

                this.followUpCount++;

                // フォローアップ質問の場合のみ応答を表示
                if (assistantResponse && this.followUpCount < 3) {
                    this.addMessage(assistantResponse, false);
                }

                if (this.followUpCount < 2) {
                    this.enableInput();
                } else if (this.followUpCount === 2) {
                    this.waitingForAnswer = true;
                    this.enableInput();
                } else if (this.waitingForAnswer) {
                    this.waitingForAnswer = false;
                    await this.transitionToNextQuestion();
                }
            }

            async transitionToNextQuestion() {
                this.isTransitioning = true;
                this.followUpCount = 0;
                this.currentQuestion++;
                this.conversationHistory = [];

                if (this.currentQuestion < Object.keys(this.questions).length) {
                    await new Promise(resolve => {
                        setTimeout(() => {
                            this.addMessage("貴重なご意見ありがとうございます。それでは次の質問に進ませていただきます。", false, false);
                            setTimeout(() => {
                                this.isTransitioning = false;
                                this.askNextQuestion();
                                resolve();
                            }, 1500);
                        }, 1000);
                    });
                } else {
                    this.addMessage("インタビューにご協力いただき、誠にありがとうございました。画面を閉じてください。", false, false);
                    this.disableInput();
                    $('#start-interview').text('インタビュー終了').prop('disabled', true);
                }
            }

            async askNextQuestion() {
                if (this.currentQuestion < Object.keys(this.questions).length) {
                    const questionIndex = this.currentQuestion + 1;
                    const question = this.questions[questionIndex];
                    this.addMessage(question.question_text, false); // 質問も保存
                    this.enableInput();
                }
            }

            startInterview() {
                if (!this.isInterviewStarted) {
                    this.isInterviewStarted = true;
                    this.addMessage("本日は、{service_name}に関するインタビューにご協力いただき、ありがとうございます。できるだけリラックスしてお答えください。", false, false);
                    setTimeout(() => {
                        this.askNextQuestion();
                    }, 1500);
                }
            }

            // C)チャットログを保存
            async saveAnswerToDB(chatBy, chatText, questionId, digCount) {
                try {
                    await $.ajax({
                        url: 'chat_save_log.php',
                        method: 'POST',
                        data: {
                            chat_log_order: this.chatLogOrder,
                            chat_by: chatBy,
                            chat_text: chatText,
                            for_question_id: questionId,
                            dig_count: digCount
                        }
                    });
                    this.chatLogOrder++; // 次のチャットログのためにインクリメント
                } catch (error) {
                    console.error("Error saving answer:", error);
                }
            }

            enableInput() {
                $('#user-input').prop('disabled', false).focus();
                $('#send').prop('disabled', false);
            }

            disableInput() {
                $('#user-input').prop('disabled', true);
                $('#send').prop('disabled', true);
            }

            initializeEventListeners() {
                $('#start-interview').click(() => {
                    $('#start-interview').prop('disabled', true);
                    this.startInterview();
                });

                $('#send').click(async () => {
                    const userInput = $('#user-input').val().trim();
                    if (userInput && !this.isTransitioning) {
                        this.disableInput();
                        $('#user-input').val('');
                        await this.handleResponse(userInput);
                    }
                });

                $('#user-input').keypress((e) => {
                    if (e.which == 13 && !$('#send').prop('disabled')) {
                        $('#send').click();
                    }
                });
            }
        }
    </script>

</body>

</html>