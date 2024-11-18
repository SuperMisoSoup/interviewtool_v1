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
            max-width: 600px;
            margin: 20px auto;
        }

        /* チャットボックスのスタイル */
        .chat-box {
            border: 1px solid #ddd;
            /* 枠線の色 */
            height: 400px;
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

    <!-- jQueryライブラリの読み込み -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JavaScript（バンドル版）を読み込み -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="config.php"></script>
    <script>
        const CONFIG = {
            API_ENDPOINT: 'https://api.openai.com/v1/chat/completions',
            API_KEY: '<?= htmlspecialchars(OPENAI_API_KEY, ENT_QUOTES, 'UTF-8') ?>', // PHPからAPIキーを直接埋め込み
            MODEL: 'gpt-4o-mini', // 使用するモデル名
            SYSTEM_PROMPT: 'あなたはマーケターで、デプスインタビューの専門家です。以下のテーマに基づいて、サービスの未利用者向けに日本語でインタビューを実施してください。テーマ: 動向、競合調査、認知、入会検討、同様サービスの利用頻度や利用シーン。指定の質問１０個は必ず質問して。回答に応じて具体的な深堀もして'
        };
    </script>

    <script>
        // DOMの読み込み完了後にインタビューの初期化を行う
        $(document).ready(function() {
            const interview = new InterviewManager();
        });
    </script>

    <script>
        class InterviewManager {
            constructor() {
                this.questions = <?php echo json_encode($question_texts, JSON_UNESCAPED_UNICODE); ?>;
                this.currentQuestion = 0;
                this.followUpCount = 0; // 深堀回数
                this.lastResponse = ""; // 前回の回答
                this.isInterviewStarted = false;
                this.conversationHistory = []; // json会話履歴({role:user, content:〇〇}, ...)
                this.isTransitioning = false;
                this.waitingForAnswer = false;

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

                    this.conversationHistory.push({
                        role: 'assistant',
                        content: response.choices[0].message.content
                    });
                    return response.choices[0].message.content;

                } catch (error) {
                    console.error('Error:', error);
                    this.addMessage(errorMessage, false);
                    return "申し訳ありません。エラーが発生しました。";
                }
            }

            addMessage(message, isUser) {
                const messageDiv = $('<div></div>')
                    .addClass('message')
                    .addClass(isUser ? 'user' : 'interviewer')
                    .text(message);
                $('#chat-box').append(messageDiv);
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            }

            showQuestionNumber() {
                if (this.currentQuestion < this.questions.length) {
                    this.addMessage(this.questions[this.currentQuestion], false);
                }
            }

            async handleResponse(response) {
                if (this.isTransitioning) return;

                let cleanResponse = response.trim();
                this.lastResponse = cleanResponse;

                // フォローアップ質問の場合のみ応答を表示
                if (this.followUpCount < 2) {
                    this.addMessage(cleanResponse, false);
                }

                this.followUpCount++;

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

                if (this.currentQuestion < this.questions.length) {
                    await new Promise(resolve => {
                        setTimeout(() => {
                            this.addMessage("貴重なご意見ありがとうございます。それでは次の質問に進ませていただきます。", false);
                            setTimeout(() => {
                                this.isTransitioning = false;
                                this.askNextQuestion();
                                resolve();
                            }, 1500);
                        }, 1000);
                    });
                } else {
                    this.addMessage("インタビューにご協力いただき、誠にありがとうございました。", false);
                    this.disableInput();
                    $('#start-interview').text('インタビュー終了').prop('disabled', true);
                }
            }

            askNextQuestion() {
                setTimeout(() => {
                    this.showQuestionNumber();
                    this.enableInput();
                }, 500);
            }

            startInterview() {
                if (!this.isInterviewStarted) {
                    this.isInterviewStarted = true;
                    this.addMessage("本日は、{service_name}に関するインタビューにご協力いただき、ありがとうございます。できるだけリラックスしてお答えください。", false);
                    setTimeout(() => {
                        this.askNextQuestion();
                    }, 1500);
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
                        this.addMessage(userInput, true);
                        this.disableInput();
                        $('#user-input').val('');

                        const response = await this.callGPT4(userInput);
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

</body>

</html>