<?php
//エラーログ取得
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//データの取得
$name = $_POST['name'];
$lid = $_POST['id'];
$lpw = password_hash($_POST['password'], PASSWORD_DEFAULT); // パスワードをハッシュ化

// tokenの生成
$tokenid = bin2hex(random_bytes(16));

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// データ登録SQL
$sql = "INSERT INTO gs_an_admin (name, lid, lpw, kanri_flag, life_flag, token)
        VALUES (:name, :lid, :lpw, 0, 0, :tokenid)";

// SQLの準備
$stmt = $pdo->prepare($sql);

// バインド変数を使ってデータを保護
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$stmt->bindValue(':tokenid', $tokenid, PDO::PARAM_STR);

// SQL実行
$status = $stmt->execute();

// SQL実行後の処理
if ($status == false) {
    $error = $stmt->errorInfo();
    echo 'SQL_ERROR:' . $error[2];
    exit();
} else {
    if ($rowsAffected > 0) {
        header("Location: ./index.php");
        exit();
    } else {
        echo 'データが更新されませんでした（既に同じ値の可能性があります）';
    }
}
?>
