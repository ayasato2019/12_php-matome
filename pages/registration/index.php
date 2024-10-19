<?php
session_start();

// CSRFトークンの生成
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// URLからトークンを取得
$token_id = $_GET['token_id'];

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();

// トークンを使ってユーザーのデータを取得
$stmt = $pdo->prepare("SELECT * FROM app_groups WHERE token_id=:token_id");
$stmt->bindValue(':token_id', $token_id, PDO::PARAM_STR);
$status = $stmt->execute();

// セッションからメールアドレスを取得
$admin_email = $_SESSION['admin_email'];

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
	<title>新規登録</title>
</head>
<body class="wrap">
	<div class="form inner">
		<form action="./insert.php" method="post">
            <input type="hidden" name="token_id" value="<?=$row["token_id"]?>">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
			<h1 class="title" data-heading="registran">新規登録</h1>
			<div class="question-item">
                <label>
                    <span class="question-title">グループ名</span>
                    <input type="text" name="group_name" placeholder="マネー家" required>
                </label>
                <label>
                    <span class="question-title">メールアドレス</span>
                    <input type="email" name="admin_email" value="<?php  echo htmlspecialchars($row["admin_email"], ENT_QUOTES, 'UTF-8'); ?>"readonly>
                </label>
                <label>
                    <span class="question-title">電話番号</span>
                    <input type="text" name="admin_phone" placeholder="ハイフンなし" pattern="\d{10,11}" inputmode="numeric" title="電話番号は10桁または11桁の数字である必要があります。" required>
                </label>
            </div>
			<button type="submit" class="submit-button">登録</button>
		</form>
	</div>
</body>
</html>