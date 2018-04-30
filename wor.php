<?php
include('inc/header.php');

extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="WOR") { 
	//未登入返回index
    header("Location:index.php");
}
include('wor_.php');
include('slideshow.php');
    $content = $slide_menu . $item_content;
	echo $content;

include('inc/footer.php');
?>