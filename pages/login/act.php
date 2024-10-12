<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// セッションからのユーザー情報取得
if (!isset($_SESSION["id"]) || !isset($_SESSION["password"])) {
    // セッション情報がない場合、エラーメッセージを表示
    exit("セッション情報が存在しません。");
}

$lid = $_SESSION["id"];
$lpw = $_SESSION["password"];

// サーバー情報
include("../../assets/libs/functions.php");
$pdo = db_conn();

$sql = "SELECT * FROM gs_an_admin WHERE lid = :lid"; // life_flag=0 をコメントアウト
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$res = $stmt->execute();

// SQL実行時にエラーがある場合
if ($res == false) {
    $error = $stmt->errorInfo();
    exit("QueryError:" . $error[2]);
}

// 1レコードだけ取得する方法
$val = $stmt->fetch(PDO::FETCH_ASSOC); // FETCH_ASSOCで連想配列として取得

if ($val) {
    // パスワード確認
    $pw_judge = password_verify($lpw, $val["lpw"]);
    if ($pw_judge) {
        // ログイン成功
        $_SESSION["chk_ssid"]  = session_id();
        $_SESSION["kanri_flg"] = $val['kanri_flg'];
        $_SESSION["name"]      = $val['name'];
        header("Location: ../admin/index.php");
        exit();
    } else {
        // ログイン失敗
        header("Location: ./notfound_account.php");
        exit();
    }
} else {
    // ユーザーが見つからなかった場合の処理
    header("Location: ./notfound_account.php");
    exit();
}

// パスワードをハッシュ化して表示（デバッグ用）
echo "ハッシュ化されたパスワード: " . htmlspecialchars($lpw, ENT_QUOTES, 'UTF-8');
exit();
