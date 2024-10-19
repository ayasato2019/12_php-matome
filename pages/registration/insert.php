<?php
session_start();

// CSRFトークンの検証関数
function validate_csrf_token() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("ブラウザの戻るボタンは使用できません。");
    }
}

// POSTリクエストの検証
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validate_csrf_token(); // CSRFトークンの検証
}

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// フォームからのデータを受け取る
$token_id = $_POST['token_id'];
$group_name = $_POST['group_name'];
$admin_email = $_POST['admin_email'];
$admin_phone = $_POST['admin_phone'];

// ユーザー情報を更新するためのSQL文
$sql = "UPDATE app_groups SET group_name = :group_name, admin_email = :admin_email, admin_phone = :admin_phone WHERE token_id = :token_id";
$stmt = $pdo->prepare($sql);

// バインド変数を使用してデータを保護
$stmt->bindValue(':token_id', $token_id, PDO::PARAM_STR);
$stmt->bindValue(':group_name', $group_name, PDO::PARAM_STR);
$stmt->bindValue(':admin_email', $admin_email, PDO::PARAM_STR);
$stmt->bindValue(':admin_phone', $admin_phone, PDO::PARAM_STR);


// SQLの実行
$status = $stmt->execute();
$rowsAffected = $stmt->rowCount();  // 更新された行数を取得

if ($status == false) {
    $error = $stmt->errorInfo();
    echo 'SQL_ERROR:' . $error[2];
    exit();
} else {
    header("Location: ../member_registration/index.php?token_id=" . urlencode($token_id));
    exit();
}

?>