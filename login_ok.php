<?php
include('inc/header.php');
/*把$_SESSION的鍵變成變數*/
extract($_SESSION);
if (!isset($id)) { 
	//未登入返回index
    header("Location:index.php");
}

//$_SESSION內容
//[call_main]***** [name]
//           ***** [id] 
//[dist_cd]  ***** [basic_dist_cd] 
//[title_cd] ***** [prefix] 

switch(true){ 
	case $basic_dist_cd=='TEA' ||$basic_dist_cd== 'PRO' ||$basic_dist_cd== 'PRT':
		header("Location:tea.php");
		break;
	case $basic_dist_cd=='OFF':
		header("Location:off.php");
		break;
	case $basic_dist_cd=='UMI':
		header("Location:umi.php");
		break;
	case $basic_dist_cd=='WOR':
		header("Location:wor.php");
		break;
	case $basic_dist_cd=='ADMIN':
		header("Location:admin.php");
		break;
	// 其他人員類別
	default:	
		header("Location:index.php");
		break;
}
include('inc/footer.php');
?>