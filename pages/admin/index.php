<?php
session_start();
$admin = $_SESSION["name"];

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
	<header class="header">
		<p>ようこそ<?= htmlspecialchars($admin, ENT_QUOTES, 'UTF-8') ?></p>
		<a href="../admin/index.php" class="nav-link">管理者ページ</a>
	</header>
	<div class="wrap">
		<div class="form inner" style="align-items: flex-start;">
			<h2 class="title" data-heading="registran">ユーザ一覧</h2>
			<ul class="user-list">
				<?php foreach ($values as $value) { ?>
				<li class="user-item flex">
					<p><?= h($value["number"]) ?></p>
					<a href="../registration2/index.php?token=<?= h($value["token"])?>">
						<p><?= h($value["name"]) ?></p>
					</a>
					<a href="./delete.php?token=<?= h($value["token"])?>">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="width: 20px; height: 20px; opacity: 1;" xml:space="preserve">
							<g>
								<path d="M88.594,464.731C90.958,491.486,113.368,512,140.234,512h231.523c26.858,0,49.276-20.514,51.641-47.269
									l25.642-335.928H62.952L88.594,464.731z M329.183,221.836c0.357-5.876,5.4-10.349,11.277-9.992
									c5.877,0.357,10.342,5.409,9.993,11.277l-10.129,202.234c-0.357,5.876-5.4,10.342-11.278,9.984
									c-5.876-0.349-10.349-5.4-9.992-11.269L329.183,221.836z M245.344,222.474c0-5.885,4.772-10.648,10.657-10.648
									c5.885,0,10.656,4.763,10.656,10.648v202.242c0,5.885-4.771,10.648-10.656,10.648c-5.885,0-10.657-4.763-10.657-10.648V222.474z
									M171.531,211.844c5.876-0.357,10.92,4.116,11.278,9.992l10.137,202.234c0.357,5.869-4.116,10.92-9.992,11.269
									c-5.869,0.357-10.921-4.108-11.278-9.984l-10.137-202.234C161.182,217.253,165.654,212.201,171.531,211.844z" style="fill: rgb(180, 214, 205);"></path>
								<path d="M439.115,64.517c0,0-34.078-5.664-43.34-8.479c-8.301-2.526-80.795-13.566-80.795-13.566l-2.722-19.297
									C310.388,9.857,299.484,0,286.642,0h-30.651H225.34c-12.825,0-23.728,9.857-25.616,23.175l-2.721,19.297
									c0,0-72.469,11.039-80.778,13.566c-9.261,2.815-43.357,8.479-43.357,8.479C62.544,67.365,55.332,77.172,55.332,88.38v21.926h200.66
									h200.676V88.38C456.668,77.172,449.456,67.365,439.115,64.517z M276.318,38.824h-40.636c-3.606,0-6.532-2.925-6.532-6.532
									s2.926-6.532,6.532-6.532h40.636c3.606,0,6.532,2.925,6.532,6.532S279.924,38.824,276.318,38.824z" style="fill: rgb(180, 214, 205);"></path>
							</g>
						</svg>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</body>
</html>