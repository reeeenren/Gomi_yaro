<?php
// 安全なHTML出力用の共通関数
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// POSTデータの取得
$year  = $_POST['year'] ?? '';
$tname = $_POST['tname'] ?? '';
$subj  = $_POST['subj'] ?? '';

// データベース接続情報
$dsn    = 'mysql:host=localhost;dbname=db2026;charset=utf8';
$dbid   = 'db2026';
$dbpass = 'pass-db202';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $year !== '' && $tname !== '') {
    try {
        $pdo = new PDO($dsn, $dbid, $dbpass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        /* 
         * =========================================================================
         * Teacherテーブルへの挿入処理（プレースホルダによるSQLインジェクション対策）
         * =========================================================================
         * 
         * 【プレースホルダ（:year, :tname, :subj など）とは】
         * SQL文の中に直接変数を埋め込まず、仮の目印（名前付きプレースホルダ）を置いておき、
         * 後から値を安全にバインド（関連付け）する仕組みです。
         * データベース側で「SQL構文の解析」と「データの処理」が分離されるため、
         * 悪意ある文字が含まれていても単なるデータとして扱われ、SQLインジェクション攻撃を防止できます。
         * 
         * 【bindValue() によるデータ型（PDO::PARAM_*）の明示】
         * 第3引数に型を指定することで、PHPとデータベース間での厳密な型安全性を確保します。
         * 
         *  - PDO::PARAM_STR : 文字列型（CHAR, VARCHAR, TEXT など）。
         *                     文字列としてエスケープ処理や安全な型変換が行われます。
         *  - PDO::PARAM_INT : 整数型（INT, BIGINT など）。
         *                     数値のみを想定する列（IDや年齢など）に使用し、不適切な文字の混入を防ぎます。
         *  - PDO::PARAM_BOOL: 論理値型（BOOLEAN）。
         *  - PDO::PARAM_NULL: NULL値。
         * =========================================================================
         */
        $sql = "INSERT INTO Teacher36(Tid, Name, Sub) VALUES (:year, :tname, :subj)";
        $stmt = $pdo->prepare($sql);

        // 各パラメータに値をバインド（Tid, Name, Sub はすべて文字列型のため PDO::PARAM_STR を指定）
        $stmt->bindValue(':year', $year, PDO::PARAM_STR);   // Tid: char(3)
        $stmt->bindValue(':tname', $tname, PDO::PARAM_STR); // Name: varchar(32)
        $stmt->bindValue(':subj', $subj, PDO::PARAM_STR);   // Sub: char(1)
        
        $stmt->execute();
        $message = "登録が完了しました。";
        $success = true;

    } catch (PDOException $e) {
        $message = "データベースエラーのため登録できませんでした: " . h($e->getMessage());
    }
} else {
    $message = "不正なアクセス、または入力データが不足しています。";
}

// 所属表示用の変換
$subj_name = ($subj === 'I') ? '情報' : (($subj === 'G') ? '総合' : $subj);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>担任管理簿 - 登録完了</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>先生の登録(完了)</h1>
        
        <p><?= h($message) ?></p>

        <?php if ($success): ?>
            <div class="confirm-info">
                <p>先生ID：<?= h($year) ?></p> 
                <p>名前：<?= h($tname) ?></p>
                <p>所属：<?= h($subj_name) ?></p>
            </div>
        <?php endif; ?>

        <div class="button-group">
            <a href="regist.php">続けて登録する</a> | 
            <a href="list.php">先生一覧を見る</a> | 
            <a href="top.html">トップへ戻る</a>
        </div>
    </main>
</body>
</html>