<?php

include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// フォームからのデータを受け取る
$name = $_POST['name'];
$birthday = $_POST['birthday'];
$phone = $_POST['phone'];
$email = $_POST['email'];

// ユーザー情報を更新するためのSQL文
// $sql = "UPDATE gs_an_db SET number = :number, name = :name, email = :email, birthday = :birthday, phone = :phone, token = :token";
$sql = "UPDATE gs_an_db SET name = :name, birthday = :birthday, phone = :phone WHERE token = :token";
$stmt = $pdo->prepare($sql);

// バインド変数を使用してデータを保護
// $stmt->bindValue(':number', $number, PDO::PARAM_STR);
// $stmt->bindValue(':name', $name, PDO::PARAM_STR);
// $stmt->bindValue(':email', $email, PDO::PARAM_STR);
// $stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
// $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
// $stmt->bindValue(':token', $token, PDO::PARAM_STR);

$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
$stmt->bindValue(':token', $token, PDO::PARAM_STR);


// SQLの実行
$status = $stmt->execute();
// var_dump($number, $email, $name, $birthday, $phone, $token);
// exit();

// データ更新の結果をチェック
if ($status == false) {
    $error = $stmt->errorInfo();
    exit('SQL_ERROR:' . $error[2]);
} else {
	header("Location: contactform.php");
	exit();
}
?>