<?php
//1. POSTデータ取得
$number = $_GET["number"];

//2. DB接続します
include("../../assets/libs/functions.php");
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("DELETE FROM gs_an_db WHERE number=:number");
$stmt->bindValue('number', $number, PDO::PARAM_INT);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("./index.php");
}
?>