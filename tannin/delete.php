<?php
// 安全なHTML出力用の共通関数
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// データベース接続情報
$dsn    = 'mysql:host=localhost;dbname=db2026;charset=utf8';
$dbid   = 'db2026';
$dbpass = 'pass-db202';

$message = '';
$error_msg = '';
$selected_teacher = null;
$teachers = [];

try {
    $pdo = new PDO($dsn, $dbid, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // 削除処理の実行 (POST送信時)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $tid = $_POST['tid'] ?? '';

        if ($tid !== '') {
            // プレースホルダを使用した安全なDELETE文の準備
            $sql = "DELETE FROM Teacher36 WHERE Tid = :tid";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':tid', $tid, PDO::PARAM_STR);
            $stmt->execute();

            $message = "先生ID: " . h($tid) . " の情報を削除しました。";
        } else {
            $error_msg = "削除対象の先生IDが指定されていません。";
        }
    }

    // 削除確認対象データの取得 (GETパラメータでtidが渡された場合)
    $delete_tid = $_GET['tid'] ?? '';
    if ($delete_tid !== '' && !isset($_POST['delete'])) {
        $sql = "SELECT Tid, Name, Sub FROM Teacher36 WHERE Tid = :tid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':tid', $delete_tid, PDO::PARAM_STR);
        $stmt->execute();
        $selected_teacher = $stmt->fetch();
    }

    // 一覧表示用データの取得
    $sql = "SELECT Tid, Name, Sub FROM Teacher36 ORDER BY Tid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $teachers = $stmt->fetchAll();

} catch (PDOException $e) {
    $error_msg = 'データベースエラー: ' . h($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>担任管理簿 - 先生情報の削除</title>
    </head>
    <body>
        <div style="text-align: center;">
            <h1>先生情報の削除</h1>

            <?php if ($message !== ''): ?>
                <p style="color: green;"><?= $message ?></p>
            <?php endif; ?>

            <?php if ($error_msg !== ''): ?>
                <p style="color: red;"><?= $error_msg ?></p>
            <?php endif; ?>

            <!-- 削除確認エリア (一覧で削除が選択された場合に表示) -->
            <?php if ($selected_teacher): ?>
                <?php
                    $subj_name_selected = ($selected_teacher['Sub'] === 'I') ? '情報' : (($selected_teacher['Sub'] === 'G') ? '総合' : $selected_teacher['Sub']);
                ?>
                <div style="border: 1px solid #ff4d4d; display: inline-block; padding: 15px 30px; margin-bottom: 20px; background-color: #fff0f0;">
                    <h2 style="color: #cc0000; margin-top: 0;">以下の先生情報を削除しますか？</h2>
                    <p>先生ID：<strong><?= h($selected_teacher['Tid']) ?></strong></p>
                    <p>名前：<strong><?= h($selected_teacher['Name']) ?></strong></p>
                    <p>所属：<strong><?= h($subj_name_selected) ?></strong></p>
                    <form action="delete.php" method="POST">
                        <input type="hidden" name="tid" value="<?= h($selected_teacher['Tid']) ?>">
                        <input type="submit" name="delete" value="削　　除">
                        <a href="delete.php" style="margin-left: 10px;">キャンセル</a>
                    </form>
                </div>
                <hr style="width: 80%; margin: 20px auto;">
            <?php endif; ?>

            <!-- 登録済み先生一覧（削除選択用） -->
            <h2>先生一覧（削除する先生を選択してください）</h2>
            <?php if (empty($teachers)): ?>
                <p>現在、登録されている先生はいません。</p>
            <?php else: ?>
                <table border="1" style="margin: 0 auto; border-collapse: collapse; width: 80%; max-width: 500px;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th>先生ID (Tid)</th>
                            <th>名前 (Name)</th>
                            <th>所属 (Sub)</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teachers as $teacher): ?>
                            <?php
                                $subj_name = ($teacher['Sub'] === 'I') ? '情報' : (($teacher['Sub'] === 'G') ? '総合' : $teacher['Sub']);
                            ?>
                            <tr>
                                <td><?= h($teacher['Tid']) ?></td>
                                <td><?= h($teacher['Name']) ?></td>
                                <td><?= h($subj_name) ?></td>
                                <td>
                                    <a href="delete.php?tid=<?= h($teacher['Tid']) ?>">削除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <br>
            <a href="top.html">トップへ戻る</a>
        </div>
    </body>
</html>