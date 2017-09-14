<?php
include("inc/conn.php");
require_once 'php/smart_libs/Smarty.class.php';

$smarty = new Smarty;

$content='';

$content=<<<HTML
<div id="index_outer">
   <div id="formwrap">
      <div class="system_login">
         <form name="form1" class="form-container" action="checklogin.php" method="post">
            <div class="form-title">
               <h2>系統登入</h2>
            </div>
            <div class="form-title">帳號</div>
            <input class="form-field" type="text" name="id"/><br />
            <div class="form-title">密碼</div>
            <input class="form-field" type="password" name="pass"/><br />
            <a href="https://miswww1.ccu.edu.tw/account/common/query_pwd.php">密碼查詢</a><br />
            <div class="submit-container">
               <input class="clear-button" type="reset" value="重填"/>
               <input class="submit-button" type="submit" value="確定" />
            </div>
         </form>
      </div>
      <div id="usage">
         <div id="Layer1">
            <p class="style3"></p>
            <p class="style2">
               <span class="style4">
                  <span class="style5">
            <center>使用說明</center>
            </span>
            </span>
            </p>
            <p class="style1">帳號請輸入您的身份證字號，密碼與校務行政自動化系統相同，若有帳號及密碼的問題，請 E-Mail 至
               <a href="mailto:hicstd@ccu.edw.tw"> hicstd@ccu.edw.tw</a>或點選上方&lt;密碼查詢&gt;按鈕，可自行查詢密碼				
            </p>
         </div>
      </div>
      <!--script src="/Scripts/AssetsBS3/ie10-viewport-bug-workaround.js"></script-->
   </div>
</div>
HTML;
//引入smarty樣板使php中沒有html身影，意指html的結果從php運算而得，但檔案彼此分立
$smarty->assign('content',$content);
$smarty->display('index.html');
?>