<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// CSRFトークンの検証関数
function validate_csrf_token() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("不正なリクエストです。");
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

// POSTデータの取得（liの数だけデータが送信される）
$li_count = max(count($_POST['user_name']), (int)1);

// 最大8ユーザーの情報を繰り返し取得・登録
function addSql($list_count) {
    global $pdo; // グローバル変数の使用
    $group_id = mb_convert_encoding($_POST["token_id"], 'UTF-8', 'auto');
    $user_name = $_POST["user_name"] ?? null; // 存在しない場合は null
    $parent = $_POST["parent"] ?? null; // 存在しない場合は null

    // ユーザー名が空の場合は終了
    if (empty($user_name)) {
        return; // ユーザー名が空なら何もしない
    }

    // 入力データの処理
    $user_name = mb_substr($user_name, 0, 256);
    $parent = mb_convert_encoding($parent, 'UTF-8', 'auto');

    // SQL文の修正
    $sql = "INSERT INTO app_users (id, group_id, user_name, brithday, parent) VALUES (NULL, :group_id, :user_name, NULL, :parent)";

    // SQLの準備
    $stmt = $pdo->prepare($sql);

    // バインド変数を使ってデータを保護
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindValue(':parent', $parent, PDO::PARAM_STR);

    // SQL実行
    $status = $stmt->execute();

    // SQL実行後の処理
    if ($status === false) {
        $error = $stmt->errorInfo();
        exit('データベースエラーが発生しました。' . $error[2]);
    }

    // 次のユーザーの登録
    if ($list_count != 0) { // 最大8回の登録を制限
        addSql($list_count - 1); // ここで再帰的に次のユーザーを登録
    }
}

// 最初の登録処理を開始
addSql($list_count);

// 完了後の処理
header("Location: ./complet.php");
exit();
?>
