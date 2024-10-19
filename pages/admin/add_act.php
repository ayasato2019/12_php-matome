<?php
// エラーログ取得
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$admin = $_SESSION["name"];
if (!isset($_SESSION['name'])) {
    // 'name' が設定されていない場合はログインページへリダイレクト
    header("Location: ../login/index.php");
    exit();  // スクリプトの実行を停止
}

// データの取得
$name = $_POST['name'];
$lid = $_POST['id'];
$lpw = password_hash($_POST['password'], PASSWORD_DEFAULT); // パスワードをハッシュ化

// tokenの生成
$tokenid = bin2hex(random_bytes(16));

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// データ登録SQL
$sql = "INSERT INTO gs_an_admin (name, lid, lpw, kanri_flag, life_flag, token)
        VALUES (:name, :lid, :lpw, 0, 0, :tokenid)";

// SQLの準備
$stmt = $pdo->prepare($sql);

// バインド変数を使ってデータを保護
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$stmt->bindValue(':tokenid', $tokenid, PDO::PARAM_STR);

try {
    // SQL実行
    $stmt->execute();
    
    // 影響を受けた行数を取得
    $rowsAffected = $stmt->rowCount();

    // SQL実行後の処理
    if ($rowsAffected > 0) {
        // データが正常に登録された場合
        header("Location: ./index.php");
        exit();
    } else {
        // データが登録されなかった場合
        echo "データの登録に失敗しました。";
    }
} catch (PDOException $e) {
    // SQL実行時にエラーが発生した場合
    echo 'SQL_ERROR:' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit();
}
?>
