<?php

include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// フォームからのデータを受け取る
$number = $_POST['number'];
$token = $_POST['token'];
$name = $_POST['name'];
$birthday = $_POST['birthday'];
$phone = $_POST['phone'];
$email = $_POST['email'];

// ユーザー情報を更新するためのSQL文
$sql = "UPDATE gs_an_db SET number = :number, name = :name, birthday = :birthday, email = :email, phone = :phone WHERE token = :token";
$stmt = $pdo->prepare($sql);

// バインド変数を使用してデータを保護
$stmt->bindValue(':number', $number, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
$stmt->bindValue(':token', $token, PDO::PARAM_STR);


// SQLの実行
$status = $stmt->execute();
$rowsAffected = $stmt->rowCount();  // 更新された行数を取得

if ($status == false) {
    $error = $stmt->errorInfo();
    echo 'SQL_ERROR:' . $error[2];
    exit();
} else {
    if ($rowsAffected > 0) {
        header("Location: contactform.php");
        exit();
    } else {
        echo 'データが更新されませんでした（既に同じ値の可能性があります）';
    }
}

?>