<?php
// 安全なHTML出力用の共通関数
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=db2026;charset=utf8';
$dbid = 'db2026';
$dbpass = 'pass-db202';

// データベース接続
try {
    $pdo = new PDO($dsn, $dbid, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $sql = "SELECT * FROM Tannin  NATURAL JOIN Teacher36 ORDER BY Nendo, Gaku";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $rows = $statement->fetchAll();
} catch (PDOException $e) {
    // 開発環境用のエラー表示（本番環境ではエラーログに出力し一般的なメッセージを表示することを推奨）
    exit('データベース接続エラー: ' . h($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>担任管理簿 - 全データ表示</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>全データの表示</h1>
        
        <table>
            <thead>
                <tr>
                    <th>年度</th>
                    <th>学年</th>
                    <th>先生</th>
                    <th>所属</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= h($row['Nendo'])?></td>
                    <td><?= h($row['Gaku'])?></td>
                    <td><?= h($row['Name'])?></td>
                    <td><?= h($sub) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href="top.html">トップへ戻る</a></p>
    </main>
</body>
</html>