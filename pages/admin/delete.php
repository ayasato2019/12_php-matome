<?php
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