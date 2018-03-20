<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
include("inc/conn.php");

$title_type = $_GET['title_type'];

if(empty($_SESSION["id"])=="1"||$_SESSION["id"]=="")
{
	header("Location:index.php");
	exit;
}
include('inc/header.php');
if($_SESSION["basic_dist_cd"]=="ADMIN"){
	include('admin_.php');
}
if($_SESSION["basic_dist_cd"]=="TEA"){
	include('tea_.php');
}
if($_SESSION["basic_dist_cd"]=="OFF"){
	include('off_.php');
}
if($_SESSION["basic_dist_cd"]=="UMI"){
	include('umi_.php');
}
if($_SESSION["basic_dist_cd"]=="WOR"){
	include('wor_.php');
}
$content = $slide_menu ;
echo $content;


?>
<div id="maincontent">
<div style= "background-color: #eee; border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<?php echo "主選單>教職員照片瀏覽>依職稱瀏覽>"; if($title_type == 'TEA'){echo "專任教師";}else if($title_type=='OFF') {echo "職員";} else if($title_type=='WOR'){echo "技工友";} else{echo "專案工作人員";} ?></div>
                                               
<?php 
if($title_type=='TEA'){
	$sql="SELECT DISTINCT h0rtunit_.unit_cd,
		     h0rtunit_.unit_name 
	        FROM h0btbasic_per,
	             h0etchange,
	             h0rtunit_ 
	       WHERE ( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and 
	       	     ( h0rtunit_.unit_cd = h0etchange.unit_cd ) and 
	       	     ( ( h0btbasic_per.is_current = '1' ) AND 
	       	     ( h0etchange.is_current in ('Y','y') ) and
	       	     ( ( h0btbasic_per.dist_cd = 'TEA' ) OR ( h0btbasic_per.dist_cd = 'PRO' ) )  )
	    ORDER BY h0rtunit_.unit_cd, h0rtunit_.unit_name ";}

else{
	$sql="SELECT DISTINCT h0rtunit_.unit_cd,
		     h0rtunit_.unit_name 
	        FROM h0btbasic_per,
	             h0etchange,
	             h0rtunit_ 
	       WHERE ( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and 
	       	     ( h0rtunit_.unit_cd = h0etchange.unit_cd ) and 
	       	     ( ( h0btbasic_per.is_current = '1' ) AND 
	       	     ( h0etchange.is_current in ('Y','y') ) and
	       	     ( h0btbasic_per.dist_cd = '$title_type'  ) ) 
	    ORDER BY h0rtunit_.unit_cd, h0rtunit_.unit_name ";}
     
$result =pg_query($sql);
?>
<html>
<body>
<table width="100%" border="1" align="center"><br>
  <tr>
    <td width="67"><div align="center">單位代碼</div></td>
    <td width="174"><div align="center">單位名稱</div></td>
    <td width="67"><div align="center">單位代碼</div></td>
    <td width="174"><div align="center">單位名稱</div></td>
  </tr>
 <?php $row =pg_fetch_array($result);
 while(!empty($row)){ ?> 
  <tr>
    <td><a href="pic_title_other_view.php?title_type=<?php echo $title_type; ?>&g_unit_cd=<?php echo trim($row['unit_cd']);?>&g_unit=<?php echo trim($row['unit_name']);?>" ><?php echo $row['unit_cd'];?></a></td>
    <td><a href="pic_title_other_view.php?title_type=<?php echo $title_type; ?>&g_unit_cd=<?php echo trim($row['unit_cd']);?>&g_unit=<?php echo trim($row['unit_name']);?>" ><?php echo $row['unit_name'];?></a></td>
  <?php $row =pg_fetch_array($result);?>
	<?php if(!empty($row)){?>
	<td><a href="pic_title_other_view.php?title_type=<?php echo $title_type; ?>&g_unit_cd=<?php echo trim($row['unit_cd']);?>&g_unit=<?php echo trim($row['unit_name']);?>" ><?php echo $row['unit_cd'];?></a></td>
	<td><a href="pic_title_other_view.php?title_type=<?php echo $title_type; ?>&g_unit_cd=<?php echo trim($row['unit_cd']);?>&g_unit=<?php echo trim($row['unit_name']);?>" ><?php echo $row['unit_name'];?></a></td>
       <?php $row =pg_fetch_array($result);} 
       else if(empty($row)){?>
       	<td><?php echo  "&nbsp";?></td>
       	<td><?php echo  "&nbsp";?></td>
       	<?php }?>
        </tr>
  <?php } ?>
</table><BR>
<div align="center">
  <input onclick="history.go(-1)" type="button" value="回上一頁" name="回上一頁" style="color:rgb(0,0,0);
background-color:rgb(238,238,238); border-color:rgb(0,0,0); border-width:1; ">
  </p>
  </div>
</div>
</body>
</html>

