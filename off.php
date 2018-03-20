<?php
include('inc/header.php');

extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="OFF") { 
	//未登入返回index
    header("Location:index.php");
}
include('off_.php');
    $item_content = <<<HTML
<div id="main_content"></div>
<script src="js/menu_categories/menu_OFF.js"></script>
HTML;
    $content = $slide_menu;
	echo $content;

include('inc/footer.php');
?>