<?php
include('inc/header.php');

extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="OFF") { 
	//未登入返回index
    header("Location:index.php");
}
include('off_.php');
$content = $slide_menu ;
echo $content;
include('hp503_salary.php');
include('inc/footer.php');
?>