<?php

// サーバー情報
$dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";

// フォームからのデータを受け取る
$token = $_GET['token'];
$name = $_POST['name'];
$birthday = $_POST['birthday'];
$phone = $_POST['phone'];

// DB接続
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('DB_CONNECT_ERROR: ' . $e->getMessage());
}

// ユーザー情報を更新するためのSQL文
$sql = "UPDATE gs_an_db SET name = :name, birthday = :birthday, phone = :phone WHERE token = :token";
$stmt = $pdo->prepare($sql);

// バインド変数を使用してデータを保護
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
$stmt->bindValue(':token', $token, PDO::PARAM_STR);

// SQLの実行
$status = $stmt->execute();

// データ更新の結果をチェック
if ($status == false) {
    $error = $stmt->errorInfo();
    exit('SQL_ERROR:' . $error[2]);
} else {
	header("Location: contactform.php");
	exit();
}
?>