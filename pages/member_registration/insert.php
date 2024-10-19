<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// 最大数の取得
$list_count = $_POST['member_count'];

// 最大数まで情報を繰り返し取得・登録
function addSql($list_count) {
    global $pdo; // グローバル変数の使用
    $group_id = mb_convert_encoding($_POST["token_id"], 'UTF-8', 'auto');

    // user_nameとparentを取得
    $user_names = $_POST["user_name"] ?? []; // 配列で取得
    $parents = $_POST["parent"] ?? []; // 配列で取得

    // ユーザー名が空の場合の処理
    if ($list_count <= 0) {
        return; // カウントが0になったら終了
    }

    // 現在のインデックスからユーザー名と親を取得
    $user_name = $user_names[$list_count - 1] ?? null; // 指定のインデックスの値を取得
    $parent = mb_convert_encoding($parents[$list_count - 1] ?? '', 'UTF-8', 'auto');

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
    } else {
        // ユーザー名が空の場合の処理
        error_log("ユーザー名が空です。ユーザーインデックス: " . ($list_count - 1));
    }

    // 次のユーザーの登録
    addSql($list_count - 1); // リストカウントを1減らして再帰呼び出し
}

// フォームの送信時に呼び出す
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_count = $_POST["member_count"] ?? 0; // hiddenフィールドから取得
    addSql((int)$member_count); // 数値に変換して再帰関数を呼び出す
}


// 最初の登録処理を開始
addSql($member_count);

// 完了後の処理
header("Location: ./complet.php");
exit();
?>
