<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

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


include("config.php");
function generate_question_v1($category_type, $core_purpose, $core_issue, $service_feature, $competition, $service_url)
{
    $api_key =  OPENAI_API_KEY; // `config.php` から API キーを読み込み
    $api_url = 'https://api.openai.com/v1/chat/completions';

    // 入力値作成
    $user_content = '#カテゴリ：' .$category_type;
    if ($core_purpose !== "") {
        $user_content .= ' #インタビューの目的：' . $core_purpose;
    }
    if ($core_issue !== "") {
        $user_content .= ' #サービスの解決したい課題：' . $core_issue;
    }
    if ($service_feature !== "") {
        $user_content .= ' #サービスの特徴：'. $service_feature;
    }
    if ($competition !== "") {
        $user_content .= ' #サービスの競合：' . $competition;
    }
    if ($service_url !== "") {
        $user_content .= ' #サービスのURL：' . $service_url; // FIXME:URLの中身も見てもらうプロンプトに改修
    }
    // TODO:ターゲット情報も組み込む

    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'system', 'content' => 'As a marketer and depth interview expert, please create a user interview scenario consisting of 10 questions in Japanese aligned with the input objective and detailed objective. Please generate question scenarios that take into account the input conditions and align with the objective, enabling specific and actionable insights to be obtained. Please output only the questions in an array format.'],
            ['role' => 'user', 'content' => $user_content],
        ],
        'max_tokens' => 500,
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n" .
                "Authorization: Bearer $api_key\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
            // 'content' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($api_url, false, $context); //string
    $result = json_decode($response, true); // array
    return $result['choices'][0]['message']['content'] ?? 'エラー: 質問を生成できませんでした。';
}