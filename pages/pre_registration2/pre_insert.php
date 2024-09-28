<?php
$email = $_POST['email'];
$tokenid = bin2hex(random_bytes(16));

// サーバー情報

$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";  // ここで charset のスペルを修正

try {
	$pdo = new PDO($dsn, $user, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // エラーモードを例外に設定
} catch (PDOException $e) {
	exit('DB_CONNECT_ERROR: ' . $e->getMessage());
}

// データ登録SQL（最初はemailだけを登録）
$sql = "INSERT INTO gs_an_db(number, name, email, birthday, phone, indate, token) 
        VALUES (NULL, NULL, :email, NULL, NULL, sysdate(), :tokenid)";

// SQLの準備
$stmt = $pdo->prepare($sql);

// バインド変数を使ってデータを保護
$stmt->bindValue(':tokenid', $tokenid, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);

// SQL実行
$status = $stmt->execute();

// SQL実行後の処理
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQL_ERROR:' . $error[2]);
}

// サーバーのメール設定（sendmail などの設定が必要）
$sender = "プロダクト事務局";
$mailFrom = "info@yourdomain.com";  // 送信元のメールアドレス（後で設定）
$replyTo = "info@yourdomain.com";   // 返信先（後で設定）

// メールの件名と本文
$subjectUser = "ご登録ありがとうございます";
$url = "https://borderlesss.sakura.ne.jp/09_database/pages/registration2/index.php?token=" . urlencode($tokenid);
$messageUser = <<<EOD
ご登録ありがとうございます。以下のリンクをクリックして手続きを完了してください。

----------------------------------------------------
$url
----------------------------------------------------

ご質問がございましたら、info@yourdomain.com までお問い合わせください。
EOD;


// メールヘッダの設定
$headers = "From: " . mb_encode_mimeheader($sender) . " <" . $mailFrom . ">\r\n";
$headers .= "Reply-To: " . $replyTo . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// メール送信の実行
if (mail($email, $subjectUser, $messageUser, $headers)) {
    // メール送信が成功した場合
	header("Location: ./pre_contactform.php");
	exit();
} else {
    // メール送信が失敗した場合
	exit("メールの送信に失敗しました。");
}
?>
