<?php
// サーバー情報
$host = "mysql3101.db.sakura.ne.jp";
$dbName = "borderlesss_gspractice";
$user = "borderlesss_gspractice";
$password = "ADLYWIK8pVU8_";
$dsn = "mysql:host={$host};dbname={$dbName};charser=utf8";

// サーバーのデータベースに接続
try {
	$pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	exit('DB_CONECT:' .$e->getMessage());
}

// データ登録SQL
$sql = "SELECT * FROM gs_an_table";
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
				<p><?= htmlspecialchars($value["id"]) ?></p>
				<p><?= htmlspecialchars($value["name"]) ?></p>
				<p><?= htmlspecialchars($value["email"]) ?></p>
			</div>
		<?php } ?>
	</div>
</body>
</html>