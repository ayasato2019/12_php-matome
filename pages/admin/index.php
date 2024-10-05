<?php
// サーバー情報
include("../../assets/libs/functions.php");
$pdo = db_conn();

// データ登録SQL
$sql = "SELECT * FROM gs_an_db";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ表示
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ADMIN_SQL_SELECT:" . $error[2]);
}

// データを取得して $values に格納
$values = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/reset.css">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>ユーザー一覧</title>
</head>
<body>
    <div class="form inner" style="align-items: flex-start;">
        <h2 class="title" data-heading="registran">ユーザ一覧</h2>
		<?php foreach ($values as $value) { ?>
			<a class="flex" href="../registration2/index.php?token=<?= h($value["token"])?>">
				<p><?= h($value["number"]) ?></p>
				<p><?= h($value["name"]) ?></p>
				<p><?= h($value["email"]) ?></p>
				<p><?= h($value["birthday"]) ?></p>
				<p><?= h($value["phone"]) ?></p>
				<p><?= h($value["indate"]) ?></p>
			</a>
				<a href="./delete.php?number=<?=$v["number"]?>">[削除]</a>
		<?php } ?>
	</div>
</body>
</html>