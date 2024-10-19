<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$admin = $_SESSION["name"];
if (!isset($_SESSION['name'])) {
    // 'name' が設定されていない場合はログインページへリダイレクト
    header("Location: ../login/index.php");
    exit();  // スクリプトの実行を停止
}
$token = $_GET["token"];

//2. DB接続します
include("../../assets/libs/functions.php");
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("DELETE FROM gs_an_db WHERE token = :token");
$stmt->bindValue(':token', $token, PDO::PARAM_STR);
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    echo 'SQL_ERROR:' . $error[2];
    exit();
} else {
        header("Location: ./index.php");
        exit();
}

?>