<?php
session_start();
include("inc/conn.php");

if($_SESSION["basic_dist_cd"]=="TEA" || $_SESSION["basic_dist_cd"]=="PRO" || $_SESSION["basic_dist_cd"]=="PRT"){
    
$menu=<<<HTML
<div id="menu">
<div id="login_info">{$info}</div>
<div id="counter">您是第{$count}位使用者</div>
<ul class="navmenu">
    <li><div class="slide"><a href="#">教職員工</a></div>
        <ul class="submenu">
            <li><a href="#" class="trigger" id="salary_rpt_1">每月薪資</a></li>
            <li><a href="#" class="trigger" id="salary_rpt_12">年終獎金</a></li>
            <li><a href="#" class="trigger" id="salary_rpt_13">考績獎金</a></li>
            <li><a href="#" class="trigger" id="salary_rpt_14">不休假加班費</a></li>
            <li><a href="#" class="trigger" id="salary_rpt_15">晉級差額</a></li>
        </ul>
    </li>
    <li>
        <div class="single">
        <a href="#" class="trigger" id="gen_hours_rpt">教師授課鐘點費</a>
        </div>
    </li>
    <li>
         <div class="slide">
           <a>所得稅相關查詢</a>
         </div>
         <ul class="submenu">
            <li><a href="#" class="trigger" id="tax_rpt_1">扣繳憑單</a></li>
            <li><a href="#" class="trigger" id="tax_rpt_2">保險費繳納證明單</a></li>
            <li><a href="#" class="trigger" id="tax_rpt_3">住宿費繳納證明單</a></li>
        </ul>
    </li>
    <li>
        <div class="single">
        <a href="gen_salary_tax_main.php">回主頁</a>
        </div>
    </li>
    <li>
        <div class="single">
          <a href="gen_salary_tax_logout.php">登出</a>
        </div>
    </li>
</ul>
</div>
HTML;
}
elseif(){

}

?>












<div id="sidebar"><div  id="subnav">
<dl>
<dt><font color="black"><?php echo trim($_SESSION["name"]).trim($_SESSION["prefix"]); ?>
</font></dt>
<dd><ul>
<script src="./js/menu.js"></script>
<?php
// 發現當include func.php時程式就會有問題,因此將函數寫在這邊
$date= array("year", "month", "day");
for($i=0;$i<sizeof($date);$i++)
	{
	$result3 = pg_query("Select CAST(DATE_PART('$date[$i]',NOW()) AS CHAR(10))");
	list($time) =pg_fetch_array($result3);
	pg_free_result($result3);
	$dd[$i]= $time;
}
$dd[0] = trim($dd[0]);
$dyear = strrev(substr(strrev("000".(intval($dd[0])-1911)), 0, 3));
   
$dd[1] = strval(intval($dd[1]));
if (strlen($dd[1]) < 2)
   $dd[1] = "0".$dd[1];
   
$dd[2] = strval(intval($dd[2]));   
if (strlen($dd[2]) < 2)
   $dd[2] = "0".$dd[2];

$ls_datetime = $dyear.$dd[1].$dd[2];

// 判斷登入之使用者是否符合可瀏覽教職員工照片檔之權限
		
$id = $_SESSION["id"];
// 首先有權限的為現任校長/代理校長
$sql_1 = "select staff_cd from h0etside_job where staff_cd = '$id' and title_cd = 'O00' and unit_cd = '0000' and d_start <= '$ls_datetime' and (d_end = '0' or d_end = '' or d_end is null or d_end >= '$ls_datetime')";
$result_1=pg_query($sql_1);
if (pg_num_rows($result_1) >= 1){
	// 現任校長/代理校長
	$is_seepic = "Y";
}
else{		

	// 接下來有權限的為現任人事室主任
	$sql_1 = "select staff_cd from h0etchange where staff_cd = '$id' and title_cd = 'O40' and unit_cd = 'S000' and d_start <= '$ls_datetime' and (d_end = '0' or d_end = '' or d_end is null or d_end >= '$ls_datetime')";
	$result_1=pg_query($sql_1);
	if (pg_num_rows($result_1) <= 0){
		// 非現任人事室主任
		$is_seepic = "N";
	}
	else{
		// 現任人事室主任
		$is_seepic = "Y";
	}	
}

switch (true){
case $_SESSION["basic_dist_cd"]=="TEA" || $_SESSION["basic_dist_cd"]=="PRO" || $_SESSION["basic_dist_cd"]=="PRT":  
	//專任教師(含助教),專案教師,兼任教師
?>
<br>
<dt><font style="background-color:#DB8046;color:#FFFFFF"><strong>主選單</strong></font></dt>
 <li> <a href ="php/hp020_basic.php" >基本資料修改</a><BR></li>
 <li> <a href ="php/present.php">照片上傳</a></li>
 <li> <a href ="php/hp041_change.php" >現職資料查詢</a><br></li>
 <li><a href="php/#" onMouseOver="showmenu(event,linkset[1],'1')" onMouseOut="delayhidemenu()">經歷資料查詢</a></li>
  <div id="popmenu_1" class="menuskin" onMouseOver="clearhidemenu();highlightmenu(event,'on','1')" onMouseOut="highlightmenu(event,'off','1');dynamichide(event)"></div>  
 <li> <a href ="php/hp023_edu.php" >學歷資料查詢<a><br></li>
  <li><a href="php/#" onMouseOver="showmenu(event,linkset[2],'2')" onMouseOut="delayhidemenu()">履歷資料查詢</a></li>
  <div id="popmenu_2" class="menuskin" onMouseOver="clearhidemenu();highlightmenu(event,'on','2')" onMouseOut="highlightmenu(event,'off','2');dynamichide(event)"></div>
 <li> <a href ="php/hp168_prof_upgrade.php" >年資加薪查詢</a><BR></li>
 <li> <a href ="php/hp144_reward.php">獎懲資料查詢</a><br></li>
 <li> <a href ="php/hp119_salary.php" >敘薪資料查詢</a><br></li>
 <li> <a href ="php/hp_address_book_query.php" >通訊錄查詢</a><br></li>
 <?php
 $sql="SELECT h0evside_job_parent.unit_cd,h0evside_job_parent.title_cd,h0evside_job_parent.unit_parent FROM h0evside_job_parent WHERE(h0evside_job_parent.staff_cd='".$_SESSION['id']."')";
      if(pg_query($sql))
	  {
	  $_result=pg_query($sql);
	  }
	  else
	  {
	  echo "資料庫語法失敗";
	  }
	  $data=pg_fetch_array($_result);
      if($data['title_cd']=="O00"||$data['title_cd']=="O01"){
        echo " <li> <a href='hp_work_check_president.php'>考核紀錄查詢</a><br></li>";
      }
      else{
        echo "<li> <a href='hp_work_check_manager.php'>考核紀錄查詢</a><br></li>";
      }
 
  // Lsg 96.04.11 增加若從教專系統直接連結過來,則改為關閉window,若只單純登出,則再次連結過來時會有問題(即無法連結)
   if ($_SESSION["call_main"]=="profession")
	echo "<li> <a href=\"#\" onClick=\"window.top.close()\">離開 </a></li>";
   else
 	echo "<li> <a href =\"logout.php\">登出</a></li>";
?>
<BR><BR>
<dt><font style="background-color:#DB8046;color:#FFFFFF"><strong>其他</strong></font></dt>
<?php
if ($is_seepic == "Y"){
?>
<li><A HREF="php/seepic.php">教職員照片瀏覽</a><BR></li>
<?php
}
?>

<?php
	break;	
	
case $_SESSION["basic_dist_cd"]=="OFF":   //職員or稀少性科技人員
?>
<br>
<dt><font style="background-color:#DB8046;color:#FFFFFF"><strong>主選單</strong></font></dt>
 <li> <a href ="hp020_basic.php"  >基本資料修改</a><BR></li>
 <li> <a href ="present.php">照片上傳</a></li> 
 <li> <a href ="hp041_change.php" >現職資料查詢</a></li>
  <li><a href="#" onMouseOver="showmenu(event,linkset[0],'1')" onMouseOut="delayhidemenu()">經歷資料查詢</a></li>
  <div id="popmenu_1" class="menuskin" onMouseOver="clearhidemenu();highlightmenu(event,'on','1')" onMouseOut="highlightmenu(event,'off','1');dynamichide(event)"></div>
 <li> <a href ="hp023_edu.php"  >學歷資料查詢</a><br></li>
  <li><a href="#" onMouseOver="showmenu(event,linkset[2],'2')" onMouseOut="delayhidemenu()">履歷資料查詢</a></li>
  <div id="popmenu_2" class="menuskin" onMouseOver="clearhidemenu();highlightmenu(event,'on','2')" onMouseOut="highlightmenu(event,'off','2');dynamichide(event)"></div>
 <li> <a href ="hp_167_eval.php"  >考績資料查詢</a><br></li>
 <li> <a href ="hp144_reward.php" >獎懲資料查詢</a><br></li>
 <li> <a href ="hp_address_book_query.php" >通訊錄查詢</a><br></li>
 <li> <a href="hp_work_check.php">填寫平時考核紀錄</a><br></li>
 <?php
 $sql="SELECT h0evside_job_parent.unit_cd,
              h0evside_job_parent.title_cd,
              h0evside_job_parent.unit_parent 
         FROM h0evside_job_parent WHERE(h0evside_job_parent.staff_cd='".$_SESSION['id']."')";
      if(pg_query($sql))
	  {
	  $_result=pg_query($sql);
	  }
	  else
	  {
	  echo "資料庫語法失敗";
	  }
	 
	  $data=pg_fetch_array($_result);
	  if($data['unit_parent']!=null){
	  echo "<li> <a href='hp_work_check_manager.php'>考核紀錄查詢</a><br></li>";
	  	  
	  }
	 
	  $_SESSION['dist_cd']=$_SESSION['temp_dist_cd'];
	if($_SESSION['dist_cd']=="N"){
	 	// 稀少性科技人員
		echo "<li> <a href =\"hp503_salary.php\" >敘薪資料查詢</a><br></li>";
	}
	else{
		// 一般職員
		echo "<li> <a href =\"hp113_salary.php\" >敘薪資料查詢</a><br></li>";
	}

   // Lsg 96.04.11 增加若從教專系統直接連結過來,則改為關閉window,若只單純登出,則再次連結過來時會有問題(即無法連結)
   if ($_SESSION["call_main"]=="profession")
	echo "<li> <a href=\"#\" onClick=\"window.top.close()\">離開 </a></li>";
   else
 	echo "<li> <a href =\"logout.php\">登出</a></li>";
?>
<BR><BR>
<dt><font style="background-color:#DB8046;color:#FFFFFF"><strong>其他</strong></font></dt>
<?php
if ($is_seepic == "Y"){
?>
<li><A HREF="seepic.php">教職員照片瀏覽</a><BR></li>
<?php
}
?>

<?php
	break;	
	
case $_SESSION["basic_dist_cd"]=="UMI":   //約聘雇
?>
<br>
<dt> <font style="background-color:#DB8046;color:#FFFFFF"><strong>主選單</strong></font></dt>
 <li> <a href="hp020_basic.php" >基本資料修改</a><BR></li>
 <li><A HREF="present.php">照片上傳</a></li>
<li> <a href ="hp041_change.php"  >現職資料查詢</a><br></li>
<li> <a href ="incareer.php" >校內經歷查詢</a><br></li>
 <li> <a href ="hp023_edu.php" >學歷資料查詢<a><br></li>
  <li><a href="#" onMouseOver="showmenu(event,linkset[2],'2')" onMouseOut="delayhidemenu()">履歷資料查詢</a></li>
  <div id="popmenu_2" class="menuskin" onMouseOver="clearhidemenu();highlightmenu(event,'on','2')" onMouseOut="highlightmenu(event,'off','2');dynamichide(event)"></div>
 <li> <a href ="hp104_salary.php"  >敘薪資料查詢</a><br></li>
 <li> <a href ="hp_address_book_query.php" >通訊錄查詢</a><br></li>
 <li> <a href="hp_work_check.php">填寫平時考核紀錄</a><br></li>
<?php   // Lsg 96.04.11 增加若從教專系統直接連結過來,則改為關閉window,若只單純登出,則再次連結過來時會有問題(即無法連結)
   if ($_SESSION["call_main"]=="profession")
	echo "<li> <a href=\"#\" onClick=\"window.top.close()\">離開 </a></li>";
   else
 	echo "<li> <a href =\"logout.php\">登出</a></li>";
?>
<BR><BR>
<dt><font style="background-color:#DB8046;color:#FFFFFF"><strong>其他</strong></font></dt>
<?php
if ($is_seepic == "Y"){
?>
<li><A HREF="seepic.php">教職員照片瀏覽</a><BR></li>
<?php
}
?>

<?php
	break;

case $_SESSION["basic_dist_cd"]=="WOR":    //技工友
?>
<br>
<dt> <font style="background-color:#DB8046;color:#FFFFFF"><strong>主選單</strong></font></dt>
 <li> <a href="hp020_basic.php" >基本資料修改</a><BR></li>
 <li><a href="present.php">照片上傳</a></li>
<li> <a href ="hp041_change.php"  >現職資料查詢</a><br></li>
 <li> <a href ="incareer.php" >校內經歷查詢</a><br></li>
 <li> <a href ="hp023_edu.php" >學歷資料查詢<a><br></li>
  <li><a href="#" onMouseOver="showmenu(event,linkset[2],'2')" onMouseOut="delayhidemenu()">履歷資料查詢</a></li>
  <div id="popmenu_2" class="menuskin" onMouseOver="clearhidemenu();highlightmenu(event,'on','2')" onMouseOut="highlightmenu(event,'off','2');dynamichide(event)"></div>
 <li> <a href ="hp_address_book_query.php" >通訊錄查詢</a><br></li>
 
<?php 
   // Lsg 96.04.11 增加若從教專系統直接連結過來,則改為關閉window,若只單純登出,則再次連結過來時會有問題(即無法連結)
   if ($_SESSION["call_main"]=="profession")
	echo "<li> <a href=\"#\" onClick=\"window.top.close()\">離開 </a></li>";
   else
 	echo "<li> <a href =\"logout.php\">登出</a></li>";
?>
<BR><BR>
<dt><font style="background-color:#DB8046;color:#FFFFFF"><strong>其他</strong></font></dt>
<?php
if ($is_seepic == "Y"){
?>
<li><A HREF="php/seepic.php">教職員照片瀏覽</a><BR></li>
<?php
}
?>
<?php
	break;
	
case $_SESSION["basic_dist_cd"]=="ADMIN":   
	//系統管理者
?>
<br>
<dt><font style="background-color:#DB8046;color:#FFFFFF"><strong>主選單</strong></font></dt>
<!--<li><A HREF="editnotice.php?id=0">新增公告</a><BR></li>-->
<li><A HREF="php/admin_unit.php?dist_type=OFF" target="_blank">教職員管理介面</a><BR></li>
<li><A HREF="php/admin_unit.php?dist_type=WOR" target="_blank">技工友管理介面</a><BR></li>
<li><A HREF="php/seepic.php">教職員照片瀏覽</a><BR></li>
<li><A HREF="php/ic.php" target="_blank">製作IC卡資料檔</a><BR></li>
  <li><a href="php/#" onMouseOver="showmenu(event,linkset[3],'2')" onMouseOut="delayhidemenu()">履歷資料查詢</a></li>
  <div id="popmenu_2" class="menuskin" onMouseOver="clearhidemenu();highlightmenu(event,'on','2')" onMouseOut="highlightmenu(event,'off','2');dynamichide(event)"></div>
<?php 
   // Lsg 96.04.11 增加若從教專系統直接連結過來,則改為關閉window,若只單純登出,則再次連結過來時會有問題(即無法連結)
   if ($_SESSION["call_main"]=="profession")
	echo "<li> <a href=\"#\" onClick=\"window.top.close()\">離開 </a></li>";
   else
 	echo "<li> <a href =\"php\logout.php\">登出</a></li>";
?>
<BR><BR>
<dt><font style="background-color:#DB8046;color:#FFFFFF"><strong>其他</strong></font></dt>
<?php
	break;	

default:
	// 其他人員類別
	header("Location:index.php");
	break;
}
?>

</ul></dd>
</dl>
</div></div>