<?php
session_start();

// CSRFトークンの検証関数
function validate_csrf_token() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("ブラウザの戻るボタンは使用できません。");
    }
}

// POSTリクエストの検証
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validate_csrf_token(); // CSRFトークンの検証
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../assets/styles/reset.css">
	<link rel="stylesheet" href="../../assets/styles/styles.css">
	<title>登録完了</title>
</head>
<body class="wrap">
    <div class="form inner">
        <form action="./insert.php" method="post">
            <input type="hidden" name="token_id" value="<?=$row["token_id"]?>">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <h1 class="title" data-heading="registran">メンバーを登録しました</h1>
			<p>メンバーアカウントで再ログインしてください。</p>
            <a href="../login/index.php" class="submit-button">ログイン</a>
        </form>
    </div>

<?php include("../../assets/components/footer.php"); ?>