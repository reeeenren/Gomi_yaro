<?php
// 安全なHTML出力用の共通関数
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>担任管理簿</title>
    </head>
    <body>
        <div style="text-align: center;">
            <h1>先生の登録</h1>
            <form action="kakunin.php" method="POST">
                <p>
                    <label for="year">先生ID：</label>
                    <input type="text" id="year" size="10" name="year" required>
                </p> 
                <p>
                    <label for="tname">名前：</label>
                    <input type="text" id="tname" size="10" name="tname" required>
                </p>
                <p>
                    <label for="subj">所属：</label>
                    <select id="subj" name="subj">
                        <option value="I">情報</option>
                        <option value="G">総合</option>
                    </select>
                </p>
                <p>
                    <input type="submit" value="登　　録">
                </p>
            </form>

            <a href="top.html">トップへ戻る</a>
        </div>
    </body>
</html>