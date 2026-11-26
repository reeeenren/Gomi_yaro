<?php
// 安全なHTML出力用の共通関数
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// POSTデータの取得
$year  = $_POST['year'] ?? '';
$tname = $_POST['tname'] ?? '';
$subj  = $_POST['subj'] ?? '';

// 所属コードの表示用変換
$subj_name = ($subj === 'I') ? '情報' : (($subj === 'G') ? '総合' : $subj);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>担任管理簿 - 登録確認</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>先生の登録(確認)</h1>
        <p>次の登録内容でよければ登録ボタンを押してください。</p>

        <div class="confirm-info">
            <p>先生ID：<?= h($year) ?></p> 
            <p>名前：<?= h($tname) ?></p>
            <p>所属：<?= h($subj_name) ?></p>
        </div>

        <div class="button-group">
            <!-- 再入力ボタン（入力画面へ戻る） -->
            <form action="regist.php" method="POST">
                <input type="hidden" name="year" value="<?= h($year) ?>">
                <input type="hidden" name="tname" value="<?= h($tname) ?>">
                <input type="hidden" name="subj" value="<?= h($subj) ?>">
                <input type="submit" value="再入力">
            </form>

            <!-- 登録ボタン（データベース登録処理画面へ） -->
            <form action="kanryo.php" method="POST">
                <input type="hidden" name="year" value="<?= h($year) ?>">
                <input type="hidden" name="tname" value="<?= h($tname) ?>">
                <input type="hidden" name="subj" value="<?= h($subj) ?>">
                <input type="submit" value="登録">
            </form>
        </div>
    </main>
</body>
</html>