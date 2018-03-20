<?php
session_start();
extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="TEA") { 
	//未登入返回index
    header("Location:index.php");
}
include('hp_sketch_proc_main.php');
?>