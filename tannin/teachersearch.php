<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>担任管理簿 - 先生別検索</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>先生毎の検索</h1>
        
        <table>
            <thead>
                <tr><th>先生ID</th><th>名前</th><th>所属</th></tr>
            </thead>
            <tbody>
                <!-- 登録済みの先生一覧を表示 -->
            </tbody>
        </table>
        <p>登録されている先生が出力</p>

        <form action="#" method="POST">
            <label for="tid">先生ID：</label>
            <input type="text" id="tid" name="tid" size="10">
            <input type="submit" value="表示">
        </form>

        <p>対象の先生が何年度に担任をしたか出力</p>
        <table>
            <thead>
                <tr><th>年度</th><th>学年</th><th>先生</th><th>所属</th></tr>
            </thead>
            <tbody>
                <!-- 検索結果を表示 -->
            </tbody>
        </table>

        <p><a href="top.html">トップへ戻る</a></p>
    </main>
</body>
</html>