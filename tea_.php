<?php
/*查看相片的權限*/
include('seepic_.php');
include('prifix_title.php');
$slide_menu .= '<div class="w3-bar w3-light-grey">
                        <div id="make_items_right">
                           <a href="tea_hp020_basic.php" class="w3-bar-item w3-button">基本資料修改</a>
                           <a href="tea_present.php" class="w3-bar-item w3-button">照片上傳</a>
                           <a href="tea_hp041_change.php" class="w3-bar-item w3-button">現職資料查詢</a>
                           <div class="w3-dropdown-hover">
                              <button class="w3-button">經歷資料查詢</button>
                              <div class="w3-dropdown-content w3-bar-block w3-card-4">
                                 <a href="tea_pre_work.php" class="w3-bar-item w3-button">到校前經歷資料查詢</a>
                                 <a href="tea_incareer.php" class="w3-bar-item w3-button">校內經歷查詢</a>
                                 <a href="tea_plural.php" class="w3-bar-item w3-button">教師兼行政職查詢</a>
                              </div>
                           </div>
                           <a href="tea_hp023_edu.php" class="w3-bar-item w3-button">學歷資料查詢</a>
                           <div class="w3-dropdown-hover">
                              <button class="w3-button">履歷資料查詢</button>
                              <div class="w3-dropdown-content w3-bar-block w3-card-4">
                                 <a href="tea_hp_sketch_proc_main.php" class="w3-bar-item w3-button">履歷表填寫作業</a>
                                 <a href="tea_hp_sketch_rtp.php" class="w3-bar-item w3-button">產生履歷表PDF檔</a>
                              </div>
                           </div>
                           <a href="tea_hp168_prof_upgrade.php" class="w3-bar-item w3-button">年資加薪查詢</a>
                           <a href="tea_hp144_reward.php" class="w3-bar-item w3-button">獎懲資料查詢</a>
                           <a href="tea_hp119_salary.php" class="w3-bar-item w3-button">敘薪資料查詢</a>
                           <a href="tea_hp_address_book_query.php" class="w3-bar-item w3-button">通訊錄查詢</a>';
    $sql = "SELECT h0evside_job_parent.unit_cd,h0evside_job_parent.title_cd,h0evside_job_parent.unit_parent FROM h0evside_job_parent WHERE(h0evside_job_parent.staff_cd='" . $id . "')";
    $_result = null;
    if (pg_query($sql)) {
        $_result = pg_query($sql);
    }
    else {
        echo "資料庫語法失敗";
    }

    $data = pg_fetch_array($_result);
    if ($data['title_cd'] == "O00" || $data['title_cd'] == "O01") {
        $slide_menu.= "<a href='tea_hp_work_check_president.php' class='w3-bar-item w3-button'>考核紀錄查詢</a>";
    }
    else {
        $slide_menu.= "<a href='tea_hp_work_check_manager.php' class='w3-bar-item w3-button'>考核紀錄查詢</a>";
    }

    if ($_SESSION["call_main"] == "profession") $slide_menu.= "<a href='#' onClick='window.top.close()' class='w3-bar-item w3-button'>離開</a>";
    if ($is_seepic == "Y") {
        $slide_menu.= '<a href="tea_seepic.php" class="w3-bar-item w3-button">教職員照片瀏覽</a>';
    }

    if ($_SESSION["call_main"] == "profession") {
        $slide_menu.= "<a href='#' class='w3-bar-item w3-button' onClick='window.top.close()'>離開</a></div></div>";
    }
    else {
        $slide_menu.= "<a href ='logout.php' class='w3-bar-item w3-button'>登出</a></div></div>";
    }
?>