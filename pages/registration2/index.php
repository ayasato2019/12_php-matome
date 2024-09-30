<?php
session_start();
$token = $_GET['token'];
if (!$token) {
    exit('メールアドレスが登録されていません。');
}// else if (!$tokenulr = $token) {
//    exit('ユーザーが一致しません。');
//}

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// セッションからメールアドレスを取得
$email = $_SESSION['email'];

// トークンを使ってユーザーのデータを取得
$sql = "SELECT * FROM gs_an_db WHERE token = :token";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':token', $token, PDO::PARAM_STR);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    exit('ユーザーが見つかりません。');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../assets/styles/reset.css">
	<link rel="stylesheet" href="../../assets/styles/styles.css">
	<title>新規登録</title>
</head>
<body>
	
	<div class="form inner">
		<form action="./insert.php" method="post">
			<h2 class="title" data-heading="registran">新規登録</h2>
			<div class="question-item">
                <label>
                    <span class="question-title">名前</span>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($userData['name']); ?>" required>
                </label>
                <label>
                    <span class="question-title">メールアドレス</span>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" readonly>
                </label>
                <label>
                    <span class="question-title">生年月日</span>
                    <input type="text" name="birthday" value="<?php echo htmlspecialchars($userData['birthday']); ?>" required>
                </label>
                <label>
                    <span class="question-title">電話番号</span>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($userData['phone']); ?>" required>
                </label>
            </div>
			<button type="submit" class="submit-button">登録</button>
		</form>
	</div>
</body>
</html>