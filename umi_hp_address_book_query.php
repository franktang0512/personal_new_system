<?php
include('inc/header.php');

extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="UMI") { 
	//未登入返回index
    header("Location:index.php");
}
include('umi_.php');
$content = $slide_menu ;
echo $content;
include('hp_address_book_query.php');
include('inc/footer.php');
?>