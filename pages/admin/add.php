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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../assets/styles/reset.css">
	<link rel="stylesheet" href="../../assets/styles/styles.css">
	<title>管理者登録</title>
</head>
<body>
	<header class="header">
		<p class="wellcome-message">ようこそ<span class="admin-name"><?= htmlspecialchars($admin, ENT_QUOTES, 'UTF-8') ?></span>さん</p>
		<a href="../admin/index.php" class="nav-link">管理者ページ</a>
	</header>
	<main class="wrap">
		<div class="form inner">
			<form action="./add_act.php" method="post">
				<h2 class="title" data-heading="registran">管理者登録</h2>
				<div class="question-item">
					<label>
						<span class="question-title">名前</span>
						<input type="text" name="name" required>
					</label>
					<label>
						<span class="question-title">id</span>
						<input type="text" name="id" required>
					</label>
					<label>
						<span class="question-title">password</span>
						<input type="text" name="password" required>
					</label>
				</div>
				<button type="submit" class="submit-button">登録</button>
			</form>
		</div>
	</main>
</body>
</html>
