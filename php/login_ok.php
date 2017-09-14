<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
if( !isset($_SESSION["id"]) ) {//還沒登入或已經登出的情況,返回index
	header("Location:index.php");
}

include("inc/pg_start.php");
include("inc/pg_conn.php");

$page=$_REQUEST["page"];
if(empty($_REQUEST["page"])){
	$page=1;
}

$pagecnt = 10;

$sql="EXEC notice_read_sp $page,".$pagecnt;
$result=pg_query($sql);
?>

<div id="maincontent">
<div style= "width: 100%; background-color: #eee; border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<?php 
/*
	$sql2="SELECT COALESCE(count(*), 0) "."row_cnt"." FROM notice";
	$result2=pg_query($sql2) or die("資料庫語法失敗!");
	$row2=pg_fetch_array($result2);
	echo "(共 ".$row2['row_cnt']." 筆) ";
?>
<select name="select" onchange="location.href=this.options[this.selectedIndex].value">
<?php 
	for($i=0;$i < $row2['row_cnt']/$pagecnt;$i++){
?>
		<option value="login_ok.php?&page=<?php echo $i+1; ?>"<?php if($i+1==$_REQUEST["page"]) echo "selected";?>>第<?php echo $i+1; ?>頁 </option>
<?php 
		include("inc/menu.php");
	}
    */ 
?>          
<!--</select>-->
<div align="center">系統公告</div>
</div>
<br />
<h1 align="center" style="font-weight: bold;">人事系統首頁</h1>
<!--<table width="100%" align="center" border="0" id="notice">
<?php while ($row =pg_fetch_row($result)){ ?>
<tr onmouseover="this.style.background='#FFFFFF';" onmouseout="this.style.background='';">
<td valign="middle" align="right"><img src="image/news_arrow.gif"></td>
<td style="word-break:break-all;" valign="middle">
<font color="#000099"><font color="red"><?php if ($row[3]==1) echo "[置頂]:"; ?></font>
<a href="javascript://"  onClick="window.open('notice_content.php?id=<?php echo $row[0]?>&class=system','','menubar=no,status=no,scrollbars=yes,top=20,left=50,toolbar=no,width=700,height=500')"><?php echo $row[1]; ?></a>
</td>
<td valign="middle">
(<?php echo $row[2]; ?>)	
</td>
<td width="35"><?php if( $_SESSION["id"]=="ADMIN" ){ ?>
<a href=editnotice.php?id=<?php echo $row[0]; ?> title="重新編輯"><img src="image/Author.gif"></a>
</td><td width="35">
<a href=delnotice.php?id=<?php echo $row[0]; ?> onClick="return(confirm('你確定要刪除嗎？'))" title="刪除公告" ><img src="image/trash.png"></a>
<?php } ?>
</td>
</tr>
<?php } ?>
</table>-->
</div>
<?php
include("inc/menu.php");
include("inc/end.php");
?>