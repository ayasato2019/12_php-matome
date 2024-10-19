<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
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
	<title>管理者ログイン</title>
</head>
<body class="wrap">
	<div class="form inner">
		<form name="form1" action="./act.php" method="post">
			<h2 class="title" data-heading="registran">管理者ログイン</h2>
			<div class="question-item">
                <label>
                    <span class="question-title">ID</span>
                    <input type="text" name="id" required>
                </label>
                <label>
                    <span class="question-title">PassWord</span>
                    <input type="text" name="password" required>
                </label>
            </div>
			<button type="submit" class="submit-button">ログイン</button>
		</form>
	</div>
</body>
</html>