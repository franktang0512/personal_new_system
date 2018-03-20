<?php
/*查看相片的權限*/
include('seepic_.php');
    $slide_menu = '<div class="w3-bar w3-light-grey">
                        <div id="make_items_right">
                           <a href="wor_hp020_basic.php" class="w3-bar-item w3-button">基本資料修改</a>
                           <a href="wor_present.php" class="w3-bar-item w3-button">照片上傳</a>
                           <a href="wor_hp041_change.php" class="w3-bar-item w3-button">現職資料查詢</a>						   
						   <a href="wor_incareer.php" class="w3-bar-item w3-button">校內經歷查詢</a>
						   <a href="wor_hp023_edu.php" class="w3-bar-item w3-button">學歷資料查詢<a>
						   <div class="w3-dropdown-hover">
                              <button class="w3-button">履歷資料查詢</button>
                              <div class="w3-dropdown-content w3-bar-block w3-card-4">
                                 <a href="wor_hp_sketch_proc_main.php" class="w3-bar-item w3-button">履歷表填寫作業</a>
                                 <a href="wor_hp_sketch_rtp.php" class="w3-bar-item w3-button" onclick="umiResumeToPDF()">產生履歷表PDF檔</a>
                              </div>
                           </div>
						   <a href="wor_hp_address_book_query.php" class="w3-bar-item w3-button">通訊錄查詢</a>';
    if ($is_seepic == "Y") {
        $slide_menu.= '<a href="wor_seepic.php" class="w3-bar-item w3-button">教職員照片瀏覽</a>';
    }

    if ($_SESSION["call_main"] == "profession") {
        $slide_menu.= "<a href='#' class='w3-bar-item w3-button' onClick='window.top.close()'>離開 </a></div></div>";
    }
    else {
        $slide_menu.= "<a href ='logout.php' class='w3-bar-item w3-button'>登出</a></div></div>";
    }
?>