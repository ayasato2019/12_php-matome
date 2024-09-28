<?php
// サーバー情報
$host = "mysql3101.db.sakura.ne.jp";
$dbName = "borderlesss_gspractice";
$user = "borderlesss_gspractice";
$password = "ADLYWIK8pVU8_";
$dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";

// フォーム登録内容
$name   = $_POST["name"];
$email  = $_POST["email"];
$age    = $_POST["age"];
$naiyou = $_POST["naiyou"];

try {
	$pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	exit('DB_CONECT:' .$e->getMessage());
}

// データ登録SQL
// :nameでバインド変数を使ってクリーニングにする。変数を使うとハッキングされる
$sql = "INSERT INTO gs_an_table(id, name, email, age, naiyou, indate) VALUES(NULL, :name, :email, :age, :naiyou, sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR); // 修正箇所
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_INT);
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
$status = $stmt->execute();

// データ表示
if($status == false) {
	$error = $stmt->errorInfo();
	exit('SQL_ERROR:'.$error[2]);
} else {
	header("Location: contactform.php");
	exit();
}
?>