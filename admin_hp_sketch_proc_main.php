<?php
include('inc/header.php');

extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="ADMIN") { 
	//未登入返回index
    header("Location:index.php");
}
include("inc/header.php");
include('admin_.php');

    $item_content = <<<HTML
<div id="main_content"></div>
<script src="js/menu_categories/menu_ADMIN.js"></script>
HTML;
    $content = $slide_menu . $item_content;
	echo $content;
	
include('hp_sketch_proc_main.php');
include('inc/footer.php');
?>