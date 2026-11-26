<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>担任管理簿 - ログイン</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>管理者メニュー</h1>
        <form action="menu.php" method="POST">
            <div class="form-group">
                <label for="uname">ユーザ名：</label>
                <input type="text" id="uname" name="uname" size="10">
            </div>
            <div class="form-group">
                <label for="pass">パスワード：</label>
                <input type="password" id="pass" name="pass" size="10">
            </div>
            <input type="submit" value="ログイン">
        </form>

        <p><a href="top.html">トップへ戻る</a></p>
    </main>
</body>
</html>