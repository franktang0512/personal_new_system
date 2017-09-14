<?php
$content='';/*整體頁面*/
/*css樣板網址: https://www.w3schools.com/w3css/4/w3.css */
$slide_menu=
'<link rel="stylesheet" href="css/w3.css">
<div class="w3-bar w3-light-grey">
<div id="make_items_right">
   <a href="php/hp020_basic.php" class="w3-bar-item w3-button">基本資料修改</a>
   <a href="php/present.php" class="w3-bar-item w3-button">照片上傳</a>
   <a href="php/hp041_change.php" class="w3-bar-item w3-button">現職資料查詢</a>
   <div class="w3-dropdown-hover">
      <button class="w3-button">經歷資料查詢</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
         <a href="php/pre_work.php" class="w3-bar-item w3-button">到校前經歷資料查詢</a>
         <a href="php/incareer.php" class="w3-bar-item w3-button">校內經歷查詢</a>
         <a href="php/tea_plural.php" class="w3-bar-item w3-button">教師兼行政職查詢</a>
      </div>
   </div>
   <a href="php/hp023_edu.php" class="w3-bar-item w3-button">學歷資料查詢</a>
   <div class="w3-dropdown-hover">
      <button class="w3-button">履歷資料查詢</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
         <a href="php/hp_sketch_proc_main.php" class="w3-bar-item w3-button">履歷表填寫作業</a>
         <a href="php/hp_sketch_rtp.php" class="w3-bar-item w3-button">產生履歷表PDF檔</a>
      </div>
   </div>
   <a href="php/hp168_prof_upgrade.php" class="w3-bar-item w3-button">年資加薪查詢</a>
   <a href="php/hp144_reward.php" class="w3-bar-item w3-button">獎懲資料查詢</a>
   <a href="php/hp119_salary.php" class="w3-bar-item w3-button">敘薪資料查詢</a>
   <a href="php/hp_address_book_query.php" class="w3-bar-item w3-button">通訊錄查詢</a>
   <a href="php/hp_work_check_president.php" class="w3-bar-item w3-button">考核紀錄查詢</a>';

// $slide_menu=<<<HTML
// <div id="sidebar">
   // <div  id="subnav">
      // <div id="a0">
		// 主選單
	  // </div>
      // <li><a href ="hp020_basic.php">基本資料修改</a><BR></li>
      // <li><a href ="present.php">照片上傳</a></li>
      // <li><a href ="hp041_change.php">現職資料查詢</a><br></li>
      // <li><a href="#" onMouseOver="showmenu(event,linkset[1],'1')" onMouseOut="delayhidemenu()">經歷資料查詢</a></li>
      // <div id="popmenu_1" class="menuskin"  onMouseOver="clearhidemenu();highlightmenu(event,'on','1')" onMouseOut="highlightmenu(event,'off','1');dynamichide(event)"></div>
      // <li><a href ="hp023_edu.php">學歷資料查詢</a><br></li>
      // <li><a href="#" onMouseOver="showmenu(event,linkset[2],'2')" onMouseOut="delayhidemenu()">履歷資料查詢</a></li>
      // <div id="popmenu_2" class="menuskin" onMouseOver="clearhidemenu();highlightmenu(event,'on','2')" onMouseOut="highlightmenu(event,'off','2');dynamichide(event)"></div>
      // <li><a href ="hp168_prof_upgrade.php" >年資加薪查詢</a><BR></li>
      // <li><a href ="hp144_reward.php">獎懲資料查詢</a><br></li>
      // <li><a href ="hp119_salary.php" >敘薪資料查詢</a><br></li>
      // <li><a href ="hp_address_book_query.php" >通訊錄查詢</a><br></li>
   // </div>
// </div>
// HTML;


$seepic='';
$is_seepic = false;/*特定人員可以看更多資訊*/
$item_content='';/*點選項目內容*/

$date= array("year", "month", "day");
for($i=0;$i<sizeof($date);$i++){
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
	$is_seepic = true;
}
else{		

	// 接下來有權限的為現任人事室主任
	$sql_1 = "select staff_cd from h0etchange where staff_cd = '$id' and title_cd = 'O40' and unit_cd = 'S000' and d_start <= '$ls_datetime' and (d_end = '0' or d_end = '' or d_end is null or d_end >= '$ls_datetime')";
	$result_1=pg_query($sql_1);
	if (pg_num_rows($result_1) <= 0){
		// 非現任人事室主任
		$is_seepic = false;
	}
	else{
		// 現任人事室主任
		$is_seepic = true;
	}	
}


//給使用者點選的項目(左)
if(is_seepic){ 
$slide_menu.='<a href="#" class="w3-bar-item w3-button">教職員照片瀏覽</a>';
}
$slide_menu.='<a href="php/logout.php" class="w3-bar-item w3-button">登出</a></div></div>';
$slide_menu.=$seepic;
//點選項目後的結果內容(右)
$item_content=<<<HTML
<div id="main_content"></div>
HTML;
$content=$slide_menu.$item_content;
?>
