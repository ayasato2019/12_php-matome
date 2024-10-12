<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../assets/styles/reset.css">
	<link rel="stylesheet" href="../../assets/styles/styles.css">
	<title>管理者登録</title>
</head>
<body class="wrap">
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
</body>
</html>
