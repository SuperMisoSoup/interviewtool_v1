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
    <script src="config_chat.js"></script>
    <script src="interview.js"></script>
    <script>
        // インタビューマネージャーの初期化
        $(document).ready(function() {
            const interview = new InterviewManager();
        });
    </script>
</body>
</html>
