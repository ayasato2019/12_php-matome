<?php
// サーバー情報
include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// データ登録SQL
$sql = "SELECT * FROM gs_an_db";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ表示
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL_SELECT:" . $error[2]);
}

// データを取得して $values に格納
$values = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <h2 class="title" data-heading="registran">ユーザ一覧</h2>
		<?php foreach ($values as $value) { ?>
			<div class="flex">
				<p><?= htmlspecialchars($value["name"]) ?></p>
				<p><?= htmlspecialchars($value["email"]) ?></p>
			</div>
		<?php } ?>
	</div>
</body>
</html>