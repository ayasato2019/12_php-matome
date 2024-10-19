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

$token = $_GET['token'];

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();

// セッションからメールアドレスを取得
$email = $_SESSION['email'];

// トークンを使ってユーザーのデータを取得
$stmt = $pdo->prepare("SELECT * FROM gs_an_db WHERE token=:token");
$stmt->bindValue(':token', $token, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false) {
    sql_error($stmt);
}else{
    $row = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../assets/styles/reset.css">
	<link rel="stylesheet" href="../../assets/styles/styles.css">
	<title>ユーザー情報編集</title>
</head>
<body>
	<header class="header">
		<p class="wellcome-message">ようこそ<span class="admin-name"><?= htmlspecialchars($admin, ENT_QUOTES, 'UTF-8') ?></span>さん</p>
		<a href="../admin/index.php" class="nav-link">管理者ページ</a>
	</header>
	<main class="wrap">
		<div class="form inner">
			<form action="../registration2/insert.php" method="post">
			<input type="hidden" name="number" value="<?=$row["number"]?>">
			<input type="hidden" name="token" value="<?=$row["token"]?>">
				<h2 class="title" data-heading="registran">ユーザー情報編集</h2>
				<div class="question-item">
					<label>
						<span class="question-title">名前</span>
						<input type="text" name="name" value="<?=$row["name"]?>" required>
					</label>
					<label>
						<span class="question-title">メールアドレス</span>
						<input type="email" name="email" value="<?=$row["email"]?>" readonly>
					</label>
					<label>
						<span class="question-title">生年月日</span>
						<input type="text" name="birthday" value="<?=$row["birthday"]?>" required>
					</label>
					<label>
						<span class="question-title">電話番号</span>
						<input type="text" name="phone" value="<?=$row["phone"]?>" required>
					</label>
				</div>
				<button type="submit" class="submit-button">登録</button>
			</form>
		</div>
	</main>
</body>
</html>