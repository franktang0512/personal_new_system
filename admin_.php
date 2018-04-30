<?php
	include('prifix_title.php');
    $slide_menu .='
	<div class="w3-bar w3-light-grey">
                        <div id="make_items_right">
                           <a href="admin_unit.php?dist_type=OFF" class="w3-bar-item w3-button">教職員管理頁面</a>
                           <a href="admin_unit.php?dist_type=WOR" class="w3-bar-item w3-button">技工友管理介面</a>
                           <a href="admin_seepic.php" class="w3-bar-item w3-button">教職員照片瀏覽</a>
                           <a href="admin_ic.php" class="w3-bar-item w3-button">製作IC卡資料檔</a>
                           <div class="w3-dropdown-hover">
                              <button class="w3-button">履歷資料查詢</button>
                              <div class="w3-dropdown-content w3-bar-block w3-card-4">
								 <a href="admin_hp_sketch_rtp.php?func=proc"  class="w3-bar-item w3-button">履歷表填寫作業</a>
                                 <a href="admin_hp_sketch_rtp.php"  class="w3-bar-item w3-button">產生履歷表PDF檔</a>
                              </div>
                           </div>';
    if ($_SESSION["call_main"] == "profession") {
        $slide_menu.= "<a href='#' class='w3-bar-item w3-button' onClick='window.top.close()'>離開 </a></div></div>";
    }
    else {
        $slide_menu.= "<a href ='logout.php' class='w3-bar-item w3-button'>登出</a></div></div>";
    }

?>