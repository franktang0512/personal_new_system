<?php
session_start();
extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="ADMIN") {
    //未登入返回index
    header("Location:index.php");
}
include('inc/header.php');
include('admin_.php');
// $item_content = '
// <div id="main_content">';
// $item_content .= '
// </div>
// ';
$content = $slide_menu . $item_content;
echo $content;
include('hp_sketch_rtp.php');
include('inc/footer.php');
?>