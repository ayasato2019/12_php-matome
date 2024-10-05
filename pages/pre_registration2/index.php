<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../assets/styles/reset.css">
	<link rel="stylesheet" href="../../assets/styles/styles.css">
	<title><?php echo $title; ?></title>
</head>
<body class="wrap">
    <div class="form inner">
        <form action="./pre_insert.php" method="post">
            <h2 class="title" data-heading="registran">新規登録</h2>
            <div class="question-item">
                <label>
                    <span class="question-title">メールアドレス</span>
                    <input type="email" name="email" required>
                </label>
            </div>
            <button type="submit" class="submit-button">登録</button>
        </form>
    </div>
</body>
</html>
