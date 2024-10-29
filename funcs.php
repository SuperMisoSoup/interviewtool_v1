<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

// DB接続関数：db_conn()
// function db_conn(){
//     try {
//         $db_name = "docomo-tech-tkn_unit1";    //データベース名
//         $db_host = "mysql57.docomo-tech-tkn.sakura.ne.jp"; //DBホスト
//         $db_id   = "docomo-tech-tkn";      //アカウント名
//         $db_pw   = "Gohantaberu4";          //パスワード：XAMPPはパスワード無し or MAMPはパスワード”root”に修正してください。
//         return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
//     } catch (PDOException $e) {
//         exit('DB Connection Error:'.$e->getMessage());
//     }
// }

function db_conn()
{
    try {
        $db_name = "interviewtool_v1";    //データベース名
        $db_host = "localhost"; //DBホスト
        $db_id   = "root";      //アカウント名
        $db_pw   = "";          //パスワード：XAMPPはパスワード無し or MAMPはパスワード”root”に修正してください。
        return new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt)
{
    $error = $stmt->errorInfo();
    exit("SQLError:" . $error[2]);
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name)
{
    header("Location: " . $file_name);
    exit();
}


//SessionCheck
function sschk()
{
    if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
        exit("Login Error");
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}


// 新しい関数: OpenAI APIを使用して質問を生成する
include("config.php");
function generate_question($purpose)
{
    $api_key =  OPENAI_API_KEY; // `config.php` から API キーを読み込み
    $api_url = 'https://api.openai.com/v1/chat/completions';

    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'system', 'content' => 'As a marketer and depth interview specialist, create a user interview scenario consisting of approximately 10 questions, tailored to the given purpose. Please output only the questions in array format.'],
            ['role' => 'user', 'content' => $purpose]
        ],
        // 'language' => 'jp',
        'max_tokens' => 500,
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n" .
                "Authorization: Bearer $api_key\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($api_url, false, $context);
    $result = json_decode($response, true);

    return $result['choices'][0]['message']['content'] ?? 'エラー: 質問を生成できませんでした。';
}

// TODO:チャットタイプにする(API)
// TODO:質問を一つずつチャット形式で投げかけるようにする(GPT)

// TODO:出力をDBに保存する(SQL)
// TODO:サマリを出力させる(GPT)
