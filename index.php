<?php
session_start();
include('inc/header.php');
if(isset($_SESSION["id"])){
// include('inc/index_.php');
	if($_SESSION["basic_dist_cd"]=="ADMIN"){
		header("Location:admin.php");
	}
	if($_SESSION["basic_dist_cd"]=="TEA"){
		header("Location:tea.php");
	}
	if($_SESSION["basic_dist_cd"]=="OFF"){
		header("Location:off.php");
	}
	if($_SESSION["basic_dist_cd"]=="UMI"){
		header("Location:umi.php");
	}
	if($_SESSION["basic_dist_cd"]=="WOR"){
		header("Location:wor.php");
	}
}
?>
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

<?php
include('inc/footer.php');
?>