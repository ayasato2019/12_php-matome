<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// $lid = $_SESSION["id"];
// $lpw = $_SESSION["password"];

//これでもいけるけど
// $lid = $_POST["id"];
// $lpw = $_POST["password"];

// フォームから送信されたIDとパスワードを取得
$lid = isset($_POST['id']) ? $_POST['id'] : null; // POSTデータから取得
$lpw = isset($_POST['password']) ? $_POST['password'] : null; // POSTデータから取得


// echo "ユーザーID: " . htmlspecialchars($lid, ENT_QUOTES, 'UTF-8') . "<br>";
// echo "パスワード: " . htmlspecialchars($lpw, ENT_QUOTES, 'UTF-8') . "<br>";
// exit();

// サーバー情報
include("../../assets/libs/functions.php");
$pdo = db_conn();

$sql = "SELECT * FROM gs_an_admin WHERE lid=:lid AND life_flag=0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$res = $stmt->execute();


//SQL実行時にエラーがある場合
if($res==false){
	$error = $stmt->errorInfo();
	exit("QueryError:".$error[2]);
}

//３．抽出データ数を取得
//$count = $stmt->fetchColumn(); //いくつヒットレコードがあるか調べる。便利そうだから残しておく
$val = $stmt->fetch(); //1レコードだけ取得する方法

//４. 該当レコードがあればSESSIONに値を代入
$pw_judge = password_verify($lpw, $val["lpw"]);
if( $pw_judge ){
	$_SESSION["chk_ssid"]  = session_id();
	$_SESSION["kanri_flg"] = $val['kanri_flg'];
	$_SESSION["name"]      = $val['name'];
	header("Location: ../admin/index.php");
}else{
  //Login処理NGの場合login.phpへ遷移
  header("Location: ./notfound_account");
}
//処理終了
exit();

// INSERT INTO gs_an_admin (name, lid, lpw, kanri_flag, life_flag) VALUES
// ('管理者A', 'kanriA', SHA2('kanriadminA', 256), 1, 1),
// ('管理者B', 'kanriB', SHA2('kanriadminB', 256), 0, 1);
// ('管理者C', 'kanriC', SHA2('kanriadminC', 256), 1, 0),
// ('管理者D', 'kanriD', SHA2('kanriadminD', 256), 0, 0);