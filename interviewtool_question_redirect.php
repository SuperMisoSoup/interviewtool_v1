<?php
// interviewtool_questionのGUIで入れ替えた順番をinterviewtool_scenario_addに送るための処理
// window.location.hrefで遷移するとPOSTデータが引き継がれないためこのphpをはさんでリダイレクト

session_start();
$_SESSION['question_order'] = $_POST['order'];

?>