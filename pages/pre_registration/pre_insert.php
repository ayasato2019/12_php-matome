<?php
$email = $_POST['email'];

// サーバーのメール設定（sendmail などの設定が必要）
$sender = "プロダクト事務局";
$mailFrom = "info@yourdomain.com";  // 送信元のメールアドレス（後で設定）
$replyTo = "info@yourdomain.com";   // 返信先（後で設定）

// メールの件名と本文
$subjectUser = "ご登録ありがとうございます";
$messageUser = <<<EOD
ご登録ありがとうございます。以下のリンクをクリックして手続きを完了してください。

----------------------------------------------------
https://borderlesss.sakura.ne.jp/09_database/pages/registration/
----------------------------------------------------

ご質問がございましたら、info@yourdomain.com までお問い合わせください。
EOD;

// メールヘッダの設定
$headers = "From: " . mb_encode_mimeheader($sender) . " <" . $mailFrom . ">\r\n";
$headers .= "Reply-To: " . $replyTo . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// メール送信の実行
if (mail($email, $subjectUser, $messageUser, $headers)) {
	header("Location: ./pre_contactform.php");
	exit();
} else {
    header("Location: ./index.php");
	exit();
}
?>
