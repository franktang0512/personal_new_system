<?php
/*查看相片的權限*/
include('seepic_.php');
include('prifix_title.php');
    $slide_menu .= '<div class="w3-bar w3-light-grey">
                        <div id="make_items_right">
                           <a href="off_hp020_basic.php" class="w3-bar-item w3-button">基本資料修改</a>
                           <a href="off_present.php" class="w3-bar-item w3-button">照片上傳</a>
						   
                           <a href="off_hp041_change.php" class="w3-bar-item w3-button">現職資料查詢</a>
                           <div class="w3-dropdown-hover">
                              <button class="w3-button">經歷資料查詢</button>
                              <div class="w3-dropdown-content w3-bar-block w3-card-4">
                                 <a href="off_pre_work.php" class="w3-bar-item w3-button">到校前經歷資料查詢</a>
                                 <a href="off_incareer.php" class="w3-bar-item w3-button">校內經歷查詢</a>
                              </div>
                           </div>
                           <a href="off_hp023_edu.php" class="w3-bar-item w3-button">學歷資料查詢</a>
                           <div class="w3-dropdown-hover">
                              <button class="w3-button">履歷資料查詢</button>
                              <div class="w3-dropdown-content w3-bar-block w3-card-4">
                                 <a href="off_hp_sketch_proc_main.php" class="w3-bar-item w3-button">履歷表填寫作業</a>
                                 <a href="off_hp_sketch_rtp.php" class="w3-bar-item w3-button">產生履歷表PDF檔</a>
                              </div>
                           </div>
                           <a href="off_hp_167_eval.php" class="w3-bar-item w3-button">考績資料查詢</a>
                           <a href="off_hp144_reward.php" class="w3-bar-item w3-button">獎懲資料查詢</a>
                           <a href="off_hp_address_book_query.php" class="w3-bar-item w3-button">通訊錄查詢</a>
                           <a href="off_hp_work_check.php" class="w3-bar-item w3-button">填寫平時考核紀錄</a>';

    $sql = "SELECT h0evside_job_parent.unit_cd,h0evside_job_parent.title_cd,h0evside_job_parent.unit_parent FROM h0evside_job_parent WHERE(h0evside_job_parent.staff_cd='" . $id . "')";
    if (pg_query($sql)) {
        $_result = pg_query($sql);
    }
    else {
        echo "資料庫語法失敗";
    }

    $data = pg_fetch_array($_result);
	//主管權限限制
	if($data !=null){
	    $slide_menu.= "<a href='off_hp_work_check_manager.php' class='w3-bar-item w3-button'>考核紀錄查詢</a>";
	
	}
    // if ($data['unit_parent'] != null) {
        // $slide_menu.= "<a href='off_hp_work_check_manager.php' class='w3-bar-item w3-button'>考核紀錄查詢</a>";
    // }

    $_SESSION['dist_cd'] = $_SESSION['temp_dist_cd'];
    if ($_SESSION['dist_cd'] == "N") {

        // 稀少性科技人員
        $slide_menu.= "<a href='off_hp503_salary.php' class='w3-bar-item w3-button'>敘薪資料查詢</a>";
    }
    else {

        // 一般職員
        $slide_menu.= "<a href='off_hp113_salary.php' class='w3-bar-item w3-button' onclick='offNarSalary()'>敘薪資料查詢</a>";
    }

    if ($is_seepic== "Y") {
        $slide_menu.= '<a href="off_seepic.php" class="w3-bar-item w3-button">教職員照片瀏覽</a>';
    }

    // Lsg 96.04.11 增加若從教專系統直接連結過來,則改為關閉window,若只單純登出,則再次連結過來時會有問題(即無法連結)
    if ($_SESSION["call_main"] == "profession") {
        $slide_menu.= "<a href='#' class='w3-bar-item w3-button' onClick='window.top.close()'>離開 </a></div></div>";
    }
    else {
        $slide_menu.= "<a href ='logout.php' class='w3-bar-item w3-button'>登出</a></div></div>";
    }

?>