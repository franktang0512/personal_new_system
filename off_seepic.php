<?php
include('inc/header.php');

extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="OFF") { 
	//未登入返回index
    header("Location:index.php");
}
include('off_.php');
$item_content ='
<div id="main_content">';
include('seepic.php');
$item_content .='</div>
<script src="js/menu_categories/seepic_addic.js"></script>
';
    $content = $slide_menu . $item_content;
	echo $content;

include('inc/footer.php');
?>