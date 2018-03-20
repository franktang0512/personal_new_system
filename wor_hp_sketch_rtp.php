<?php
include('inc/header.php');

extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="WOR") { 
	//未登入返回index
    header("Location:index.php");
}
include('wor_.php');
$content = $slide_menu ;
echo $content;
include('hp_sketch_rtp.php');
include('inc/footer.php');
?>