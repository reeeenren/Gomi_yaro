<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>担任管理簿 - 管理者メニュー</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>管理者メニュー</h1>
        <div class="menu-nav">
            <form action="regist.php" method="POST">
                <input type="submit" value="登録">
            </form>
            <form action="modify.php" method="POST">
                <input type="submit" value="変更">
            </form>
            <form action="delete.php" method="POST">
                <input type="submit" value="消去">
            </form>
        </div>

        <section class="error-message">
            <h3>IDまたはパスワードが異なります。</h3>
            <p><a href="login.php">ログインへ戻る</a></p>
        </section>
    </main>
</body>
</html>