<?php
session_start();

// CSRFトークンの生成
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // トークン生成
}

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

// セッションからtoken_idを取得
$token_id = $_GET['token_id'];


if (!$token_id) {
    var_dump($token_id); 
    // header("Location: ../group_login/index.php");
    exit(); // リダイレクト後に処理を終了
}

// DB接続
include("../../assets/libs/functions.php");
$pdo = db_conn();

// トークンを使ってユーザーのデータを取得
$stmt = $pdo->prepare("SELECT * FROM app_groups WHERE token_id=:token_id");
$stmt->bindValue(':token_id', $token_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status === false) {
    // エラーハンドリング
    $error = $stmt->errorInfo();
    echo 'SQL_ERROR: ' . htmlspecialchars($error[2], ENT_QUOTES, 'UTF-8');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/reset.css">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <title>登録完了</title>
</head>
<body class="wrap">
    <div class="form inner">
        <form action="./insert.php" method="post" accept-charset="UTF-8">
            <input type="hidden" name="token_id" value="<?php echo htmlspecialchars($token_id, ENT_QUOTES, 'UTF-8'); ?>" required>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <h1 class="title" data-heading="registran">グループを登録しました</h1>
            <p class="text-center">続けてメンバーアカウントを作成します。</p>
            <ul id="member_registration" class="question-list">
                <li class="question-item mt-20 flex justify-between" data-user="1">
                    <label class="w-70">
                        <input type="text" name="user_name[]" placeholder="例）ニックネーム" required>
                    </label>
                    <label class="w-30" for="role">
                        <select name="parent[]" id="parent">
                            <option value="0" selected>管理者</option>
                            <option value="1">メンバー</option>
                        </select>
                    </label>
                </li>
            </ul>
            <button type="button" class="text-link-add">メンバーを追加する</button>
            <button type="submit" class="submit-button">登録</button>
        </form>
    </div>
<script>
    const memberList = document.getElementById('member_registration');

    memberList.addEventListener('click', (event) => {
        const li = event.target.closest('.question-item'); // クリックされたliを取得
        if (li) {
            const userId = li.getAttribute('data-user'); // data-userを取得
            console.log(userId); // 取得した値を表示
        }
    });
</script>
<?php include("../../assets/components/footer.php"); ?>
