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

// ヘッダーこれを使え
function create_header($admin_flg)
{
?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <a class="navbar-brand" href="interviewtool_category.php">AI InterView</a>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="interviewtool_scenario_view.php">インタビューシナリオ</a>
                        </li>
                        <?php if ($admin_flg == 1) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">ユーザ管理</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="user_add.php">ユーザ追加</a></li>
                                    <li><a class="dropdown-item" href="user_select.php">ユーザ一覧</a></li>
                                    <!-- <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<?php
}

include("config.php");
function generate_question_v1($category_type, $core_purpose, $core_issue, $service_feature, $competition, $service_url)
{
    $api_key =  OPENAI_API_KEY; // `config.php` から API キーを読み込み
    $api_url = 'https://api.openai.com/v1/chat/completions';

    // 入力値作成
    $user_content = '入力は以下です。#カテゴリ：' . $category_type;
    if ($service_feature !== "") {
        $user_content .= ' #サービスの特徴：' . $service_feature;
    }
    if ($core_issue !== "") {
        $user_content .= ' #サービスの解決したい課題：' . $core_issue;
    }
    if ($core_purpose !== "") {
        $user_content .= ' #インタビューの目的：' . $core_purpose;
    }
    if ($competition !== "") {
        $user_content .= ' #サービスの競合：' . $competition;
    }
    if ($service_url !== "") {
        $user_content .= ' #サービスのURL：' . $service_url;
    }
    // TODO:ターゲット情報も組み込む
    // TODO:マーケ目的→マーケ課題→インタビュー目的→インタビューターゲットの流れを理解させる
    // TODO:過去と現在の事実だけを聞くような質問にする

    $data = [
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'system', 'content' => 'あなたはマーケターで、デプスインタビューの専門家です。
                                                サービスの利用者向けにインタビューを実施するために質問フローを作成してください。
                                                ユーザ入力を考慮し、目的に沿って、具体的なインサイトが得られる質問シナリオになるようにしてください。
                                                質問では過去や現在のことの内容にし、未来に関して言及しないでください。
                                                必須出力はsection_text、question_text、question_purposeであり、任意出力はdig_pointです。
                                                出力は次のようなjson形式としてください。
                                                {
                                                    "scenario":[
                                                        "section":[
                                                            "section_text":"",
                                                            "questions":[
                                                                {
                                                                    "question_text":"",
                                                                    "question_purpose":"",
                                                                    "dig_point_1":"",
                                                                    "dig_point_2":""
                                                                }
                                                                ]
                                                            ] 
                                                        ]
                                                }
                                                '],
            ['role' => 'user', 'content' => $user_content],
        ],
        'max_tokens' => 5000,
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
