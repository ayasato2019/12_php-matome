<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./assets/styles/reset.css">
	<link rel="stylesheet" href="./assets/styles/styles.css">
	<title>新規登録</title>
</head>
<body class="wrap">
    <div class="form inner">
        <form action="./pages/pre_registration/pre_insert.php" method="post">
            <h1 class="title" data-heading="registran">新規登録</h1>
            <div class="question-item">
                <label>
                    <span class="question-title">メールアドレス</span>
                    <input type="admin_email" name="admin_email" placeholder="example@mail.com" required>
                </label>
            </div>
            <button type="submit" class="submit-button">登録</button>
        </form>
    </div>
</body>
</html>
