<?php
//$op=isset($_REQUEST['op'])? my_filter($_REQUEST['op'],''):'';
session_start();
require_once 'inc/conn.php';
require_once 'php/smart_libs/Smarty.class.php';

$smarty = new Smarty;

if (!isset($_SESSION["id"])) { //還沒登入或已經登出的情況,返回index
    header("Location:./index.php");
}

// $page=$_REQUEST["page"];
// if(empty($_REQUEST["page"])){
// $page=1;
// }
// $pagecnt = 10;

// $sql="EXEC notice_read_sp $page,".$pagecnt;
// $result=pg_query($sql);

// $content=<<<HTML
// <div id="main_content">
// <!--div class="loading">載入中...</div-->
// <div id="content">
// </div>
// </div>
// HTML;
// echo $content;
require_once './menu.php';

$smarty->assign('content',$content);
$smarty->display('index.html');
?>