https://tbsv.jp/~i25102/tannin/

ssh i25102@tbsv.jp
mysql -u db2026 -p
Enter password: pass-db202
show databases;
use db2026
show tables;
select * from Tannin36;
show columns from Tannin36;
select * from Teacher36;
show columns from Teacher36;

問題１ 年齢によって，未成年か成人かを判定する（同ページで結果が表示される）：
https://tbsv.jp/~i25102/php/get_age.php

問題２ 住所を選択すると郵便番号に変換して出力する（別ページで結果が表示される）：
https://tbsv.jp/~i25102/php/address.html

一般のコマンドプロンプトで、
選択して送る：scp "C:\Users\acer\Documents\データベース\tannin\ファイル名" i25102@tbsv.jp:~/public_html/tannin/

** Please change from "Teacher" to "Teacher36"