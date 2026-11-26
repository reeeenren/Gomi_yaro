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

    // 更新処理の実行 (POST送信時)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $tid   = $_POST['tid'] ?? '';
        $name  = $_POST['name'] ?? '';
        $sub   = $_POST['sub'] ?? '';

        if ($tid !== '' && $name !== '') {
            // プレースホルダを使用した安全なUPDATE文の準備
            $sql = "UPDATE Teacher36 SET Name = :name, Sub = :sub WHERE Tid = :tid";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':sub', $sub, PDO::PARAM_STR);
            $stmt->bindValue(':tid', $tid, PDO::PARAM_STR);
            $stmt->execute();

            $message = "先生ID: " . h($tid) . " の情報を更新しました。";
        } else {
            $error_msg = "必要な入力項目が不足しています。";
        }
    }

    // 編集対象データの取得 (GETパラメータでtidが渡された場合)
    $edit_tid = $_GET['tid'] ?? ($_POST['tid'] ?? '');
    if ($edit_tid !== '') {
        $sql = "SELECT Tid, Name, Sub FROM Teacher36 WHERE Tid = :tid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':tid', $edit_tid, PDO::PARAM_STR);
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
        <title>担任管理簿 - 先生情報の変更</title>
    </head>
    <body>
        <div style="text-align: center;">
            <h1>先生情報の変更</h1>

            <?php if ($message !== ''): ?>
                <p style="color: green;"><?= $message ?></p>
            <?php endif; ?>

            <?php if ($error_msg !== ''): ?>
                <p style="color: red;"><?= $error_msg ?></p>
            <?php endif; ?>

            <!-- 編集用フォーム (編集対象が選択されている場合に表示) -->
            <?php if ($selected_teacher): ?>
                <h2>選択中の先生情報の編集</h2>
                <form action="modify.php" method="POST">
                    <input type="hidden" name="tid" value="<?= h($selected_teacher['Tid']) ?>">
                    <p>
                        先生ID：<strong><?= h($selected_teacher['Tid']) ?></strong>
                    </p>
                    <p>
                        <label for="name">名前：</label>
                        <input type="text" id="name" name="name" size="10" value="<?= h($selected_teacher['Name']) ?>" required>
                    </p>
                    <p>
                        <label for="sub">所属：</label>
                        <select id="sub" name="sub">
                            <option value="I" <?= $selected_teacher['Sub'] === 'I' ? 'selected' : '' ?>>情報</option>
                            <option value="G" <?= $selected_teacher['Sub'] === 'G' ? 'selected' : '' ?>>総合</option>
                        </select>
                    </p>
                    <p>
                        <input type="submit" name="update" value="更　　新">
                        <a href="modify.php">キャンセル</a>
                    </p>
                </form>
                <hr style="width: 80%; margin: 30px auto;">
            <?php endif; ?>

            <!-- 登録済み先生一覧（編集選択用） -->
            <h2>先生一覧（編集する先生を選択してください）</h2>
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
                                    <a href="modify.php?tid=<?= h($teacher['Tid']) ?>">編集</a>
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
