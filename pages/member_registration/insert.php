<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

// 最大数の取得
$list_count = $_POST['member_count'];

// フォームからのデータを受け取る
$group_id = mb_convert_encoding($_POST["token_id"], 'UTF-8', 'auto');
$user_names = $_POST["user_name"] ?? [];
$parents = $_POST["parent"] ?? [];

// 現在のインデックスからユーザー名と親を取得
for ($index = 0; $index < $list_count; $index++) {
    $user_name = $user_names[$index] ?? null; // 指定のインデックスの値を取得
    $parent = mb_convert_encoding($parents[$index] ?? '', 'UTF-8', 'auto');

    // ユーザー名が空でない場合に登録
    if (!empty($user_name)) {
        $user_name = mb_substr($user_name, 0, 256); // 256文字まで

        // SQL文の準備
        $sql = "INSERT INTO app_users (id, group_id, user_name, brithday, parent) VALUES (NULL, :group_id, :user_name, NULL, :parent)";
        $stmt = $pdo->prepare($sql);

        // バインド変数を使ってデータを保護
        $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindValue(':parent', $parent, PDO::PARAM_STR);

        // SQL実行
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();
            exit('データベースエラーが発生しました。' . $error[2]);
        }
    }
}

// 完了後の処理
header("Location: ./complet.php");
exit();
?>
