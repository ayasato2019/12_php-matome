<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// メールアドレスの取得
$admin_email = $_POST['admin_email'];

// メールアドレス形式のチェック
if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
    exit('不正なメールアドレス形式です。');
}

// tokenの生成
$token_id = bin2hex(random_bytes(16));

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// データ登録SQL（最初はemailだけを登録）
$sql = "INSERT INTO app_groups (token_id, group_name, group_life, admin_email, admin_phone, indate) 
        VALUES (:token_id, NULL, 0, :admin_email, NULL, sysdate())";

// SQLの準備
$stmt = $pdo->prepare($sql);

// バインド変数を使ってデータを保護
$stmt->bindValue(':token_id', $token_id, PDO::PARAM_STR);
$stmt->bindValue(':admin_email', $admin_email, PDO::PARAM_STR);

// SQL実行
$status = $stmt->execute();

// SQL実行後の処理
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('データベースエラーが発生しました。');
}

// メールアドレスのサニタイズ
$admin_email = htmlspecialchars($admin_email);

// サーバーのメール設定
$sender = "プロダクト2事務局";
$mailFrom = "info@yourdomain.com";  // 送信元のメールアドレス（設定が必要）
$replyTo = "info@yourdomain.com";   // 返信先のメールアドレス（設定が必要）

// メールの件名と本文
$subjectUser = "ご登録ありがとうございます";
$url = "https://borderlesss.sakura.ne.jp/12_phpmatome/pages/registration/index.php?token_id=" . urlencode($token_id);
$messageUser = <<<EOD
ご登録ありがとうございます。以下のリンクをクリックして手続きを完了してください。

$url

URL使用期限は24時間です。
それより時間が経ってしまった場合は、お手数ですが最初からやり直してください。



----------------------------------------------------
アプリ名

https://hogehoge.com 
----------------------------------------------------
EOD;

// メールヘッダの設定
$headers = "From: " . mb_encode_mimeheader($sender) . " <" . $mailFrom . ">\r\n";
$headers .= "Reply-To: " . $replyTo . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// メール送信の実行
if (mail($admin_email, $subjectUser, $messageUser, $headers, '-f' . $mailFrom)) {
    // メール送信が成功した場合
    header("Location: ./pre_contactform.php");
    exit();
} else {
    // メール送信が失敗した場合
    exit("メールの送信に失敗しました。");
}
?>
