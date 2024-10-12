<?php
// メールアドレスの取得とバリデーション
$email = $_POST['email'];

// メールアドレス形式のチェック
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('不正なメールアドレス形式です。');
}

// tokenの生成
$tokenid = bin2hex(random_bytes(16));

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    exit('データベースエラーが発生しました。');
}

// メールアドレスのサニタイズ
$email = htmlspecialchars($email);

// サーバーのメール設定
$sender = "プロダクト2事務局";
$mailFrom = "info@yourdomain.com";  // 送信元のメールアドレス（設定が必要）
$replyTo = "info@yourdomain.com";   // 返信先のメールアドレス（設定が必要）

// メールの件名と本文
$subjectUser = "ご登録ありがとうございます";
$url = "https://borderlesss.sakura.ne.jp/11_login/pages/registration2/index.php?token=" . urlencode($tokenid);
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
if (mail($email, $subjectUser, $messageUser, $headers, '-f' . $mailFrom)) {
    // メール送信が成功した場合
    header("Location: ./pre_contactform.php");
    exit();
} else {
    // メール送信が失敗した場合
    exit("メールの送信に失敗しました。");
}
?>
