維護需要注意:
1.測試 mail[自己的學校帳號@ccu.edu.tw比較好，gmail可能沒辦法收到]-> 正式用要改成 mail[人事室的帳號person@ccu.edu.tw](hp_sketch_proc_mail.php line 28) 
2.測試時，各個人員帳號方便驗證可將false改成true即可，正式再改回來就好(checklogin.php line 74)
3.測試時的註解拿掉 mail(...)函式 以免寄給測試帳號人員(update.php line 106)
4.資料庫使用測試用IP為140.123.30.13(inc/conn.php)
5.人員身分的php程式檔案皆以前綴字分別，以利個別維護，如:tea_***.php、off_***.php、umi_***.php、wor_***.php、admin_***.php
6.登入頁面(index.php)->密碼驗證(checklogin.php)->個別身分頁面導引(lookin_ok.php)
7.維護時 中文編碼 請使用 utf-8
8.1、2、a、photo目錄下為人員相片可能會用到的檔案
9.css/img為系統版面會用到的圖檔，css、js目錄名稱與原意無異
10.inc目錄下為基本系統header、footer、資料庫連線及郵件收發
11.詳細程式檔案說明請見 人事系統程式清單.doc