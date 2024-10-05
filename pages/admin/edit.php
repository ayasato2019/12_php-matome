<?php
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
	
	<div class="form inner">
		<form action="../registration2/insert.php" method="post">
        <input type="hidden" name="number" value="<?=$row["number"]?>">
        <input type="hidden" name="token" value="<?=$row["token"]?>">
			<h2 class="title" data-heading="registran">新規登録</h2>
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
</body>
</html>