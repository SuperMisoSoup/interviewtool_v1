<!-- 

・chatに流し込む質問を順番通りに取得する
A)question_tableから順番通りに質問配列を取得 -> $question_texts

・OpenAIと正しく連携

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
    <script src="config.chat.js"></script>
    <script>
        class InterviewManager {
            constructor() {
                // ｛service_name｝にサービス名を
                this.questions = <?php echo json_encode($question_texts, JSON_UNESCAPED_UNICODE); ?>;
                this.currentQuestion = 0;
                this.followUpCount = 0;
                this.lastResponse = "";
                this.isInterviewStarted = false;
                this.conversationHistory = [];
                this.transitionMessages = [
                    "なるほど、理解できました。それでは次の質問に移らせていただきます。",
                    "とても参考になりました。では、次の質問をさせていただきます。",
                    "貴重なご意見ありがとうございます。それでは次の質問に進ませていただきます。"
                ];
                this.isTransitioning = false;
                this.waitingForAnswer = false;

                // ユーザー操作のイベントリスナーを初期化
                this.initializeEventListeners();
            }

            // ユーザーの入力メッセージをGPT-4に送信し、応答を生成
            async callGPT4(userInput) {
                try {
                    this.conversationHistory.push({
                        role: 'user',
                        content: userInput
                    });
                    const systemPrompt = this.followUpCount > 0 ?
                        `あなたは熟練したインタビュアーです。回答の具体性を評価し、必要に応じて追加の質問を行ってください。前回の回答：「${this.lastResponse}」` :
                        "あなたは熟練したインタビュアーです。回答の具体性を評価し、必要に応じて追加の質問を行ってください。";

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

                    // アシスタントの応答を会話履歴に追加
                    this.conversationHistory.push({
                        role: 'assistant',
                        content: response.choices[0].message.content
                    });
                    return response.choices[0].message.content;
                } catch (error) {
                    console.error('Error:', error);
                    return "申し訳ありません。エラーが発生しました。";
                }
            }

            // チャット表示にメッセージを追加し、ユーザーかアシスタントかを区別
            addMessage(message, isUser) {
                const messageDiv = $('<div></div>')
                    .addClass('message')
                    .addClass(isUser ? 'user' : 'interviewer')
                    .text(message);
                $('#chat-box').append(messageDiv);
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            }

            // 現在の質問をユーザーに表示
            showQuestionNumber() {
                if (this.currentQuestion < this.questions.length) {
                    this.addMessage(this.questions[this.currentQuestion], false);
                }
            }

            // 応答を処理し、フォローアップ質問が必要か判断
            async handleResponse(response) {
                if (this.isTransitioning) return;

                let cleanResponse = response;
                let shouldFollowUp = true;
                let isWaitingForAnswer = false;

                // 応答内の特別なタグを処理
                if (response.includes('[NO_FOLLOWUP]')) {
                    cleanResponse = response.replace('[NO_FOLLOWUP]', '').trim();
                    shouldFollowUp = false;
                }
                if (response.includes('[WAITING_ANSWER]')) {
                    cleanResponse = response.replace('[WAITING_ANSWER]', '').trim();
                    isWaitingForAnswer = true;
                }

                this.lastResponse = cleanResponse;
                this.addMessage(cleanResponse, false);

                if (isWaitingForAnswer) {
                    this.waitingForAnswer = true;
                    this.enableInput();
                } else if (shouldFollowUp && this.followUpCount < 2) {
                    this.followUpCount++;
                    this.enableInput();
                } else {
                    await this.transitionToNextQuestion();
                }
            }

            // 次の質問に移行
            async transitionToNextQuestion() {
                if (this.waitingForAnswer) return;

                this.isTransitioning = true;
                this.followUpCount = 0;
                this.currentQuestion++;
                this.conversationHistory = [];
                this.waitingForAnswer = false;

                if (this.currentQuestion < this.questions.length) {
                    const transitionMessage = this.transitionMessages[Math.floor(Math.random() * this.transitionMessages.length)];
                    await new Promise(resolve => {
                        setTimeout(() => {
                            this.addMessage(transitionMessage, false);
                            setTimeout(() => {
                                this.isTransitioning = false;
                                this.askNextQuestion();
                                resolve();
                            }, 1500);
                        }, 1000);
                    });
                } else {
                    this.addMessage("インタビューにご協力いただき、誠にありがとうございました。貴重なご意見をお聞かせいただき、大変参考になりました。", false);
                    this.disableInput();
                    $('#start-interview').text('インタビュー終了').prop('disabled', true);
                }
            }

            // 次の質問を表示
            askNextQuestion() {
                setTimeout(() => {
                    this.showQuestionNumber();
                    this.enableInput();
                }, 500);
            }

            // インタビューセッションを開始
            startInterview() {
                if (!this.isInterviewStarted) {
                    this.isInterviewStarted = true;
                    this.addMessage("本日は、{service_name}に関するインタビューにご協力いただき、ありがとうございます。できるだけリラックスしてお答えください。", false);
                    setTimeout(() => {
                        this.askNextQuestion();
                    }, 1500);
                }
            }

            // ユーザーの入力を有効化（質問に答えられる状態にする）
            enableInput() {
                $('#user-input').prop('disabled', false).focus();
                $('#send').prop('disabled', false);
            }

            // ユーザーの入力を無効化（応答待機状態など）
            disableInput() {
                $('#user-input').prop('disabled', true);
                $('#send').prop('disabled', true);
            }

            // ユーザー操作のイベントリスナーを初期化
            initializeEventListeners() {
                $('#start-interview').click(() => {
                    $('#start-interview').prop('disabled', true);
                    this.startInterview();
                });

                $('#send').click(async () => {
                    const userInput = $('#user-input').val().trim();
                    if (userInput && !this.isTransitioning) {
                        this.addMessage(userInput, true);
                        this.disableInput();
                        $('#user-input').val('');
                        const response = await this.callGPT4(userInput);

                        if (this.waitingForAnswer) {
                            this.waitingForAnswer = false;
                        }

                        await this.handleResponse(response);
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
    <script>
        // インタビューマネージャーの初期化
        $(document).ready(function() {
            const interview = new InterviewManager();
        });
    </script>
</body>

</html>