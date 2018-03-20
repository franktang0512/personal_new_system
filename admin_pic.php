<?php
header("Content-Type:text/html; charset=utf-8");
include('inc/header.php');
session_start();
$dist_type = $_GET['dist_type'];
$g_unit_cd = $_GET['g_unit_cd'];
$g_unit = $_GET['g_unit'];
if(empty($_SESSION["id"])=="1"||$_SESSION["id"]=="" || $_SESSION["basic_dist_cd"]!="ADMIN")
{
	header("Location:index.php");
	exit;
}
include('admin_.php');


if ($dist_type == "WOR")
	$sql = " SELECT h0btbasic_per.staff_cd,h0btbasic_per.c_name,COALESCE(h0btbasic_per.path,'') as path,h0btbasic_per.is_in FROM h0btbasic_per,h0etchange WHERE ((h0etchange.staff_cd = h0btbasic_per.staff_cd ) and (  h0etchange.is_current in ('Y','y') ) AND ( h0btbasic_per.is_current = '1' ) AND ( h0etchange.unit_cd = '$g_unit_cd' ) and ( h0etchange.dist_cd = '8') ) ";
else	
	$sql = " SELECT h0btbasic_per.staff_cd,h0btbasic_per.c_name,COALESCE(h0btbasic_per.path,'') as path,h0btbasic_per.is_in FROM h0btbasic_per,h0etchange WHERE ((h0etchange.staff_cd = h0btbasic_per.staff_cd ) and (  h0etchange.is_current in ('Y','y') ) AND ( h0btbasic_per.is_current = '1' ) AND ( h0etchange.unit_cd = '$g_unit_cd' )and ( h0etchange.dist_cd not in( '8','2')  ) ) ";
	
$result =pg_query($sql);

$slide_menu.='
<p align="center">
	<font color="#0033CC" size="5">
		<strong>'.$g_unit.'</strong>
	</font>
</p>
<p align="center">
	<strong>
		<font color="#0000FF" size="3">
			<a href="admin_unit.php?dist_type='.$dist_type.'">回單位列表</a>
		</font>
	</strong>
</p>
';
echo $slide_menu;
?>
<!--html>
<head>
<title><?php echo $g_unit; if($dist_type == "WOR"){echo "技工友";} else {echo "教職員";} ?>相片</title>
</head-->
<body>
<table width="100%" border="1" align="center">
<?php
$row =pg_fetch_array($result);
while(!empty($row)){
?>
  <tr> 
    <td width="20%"><div align="center">     
        <?php if(trim($row['path'])==""){?>
        <p><font color=#000099 size=4>照片尚未上傳</font></p>
        <?php }else{?>
        <img src=<?php echo "./".$row['is_in']."/".$row['path']; ?> width="120" height="150"></div></td>
    <?php } ?>
    <td width="30%"><?php echo $row['is_in']." ".$row['staff_cd']."  ".$row['c_name']; ?> </td>
    <?php $row =pg_fetch_array($result); ?>    
    <?php if(!empty($row)){ ?>
    <td width="20%"><div align="center">    
    	<?php if(trim($row['path'])==""){?>
        <p><font color=#000099 size=4>照片尚未上傳</font></p>
        <?php }else{?>
        <img src=<?php echo "./".$row['is_in']."/".$row['path'];?> width="120" height="150"></div></td>
    <?php }?>
    <td width="30%"><?php echo $row['is_in']." ".$row['staff_cd']."  ".$row['c_name']; ?> </td>
    <?php $row =pg_fetch_array($result);}?>
  </tr>
  <?php } ?>
</table>
<p>&nbsp;</p>
</body>
<!--/html-->