<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
include("inc/conn.php");
include ("inc/func.php");

$title_type = $_GET['title_type'];
$g_unit_cd = $_GET['g_unit_cd'];
$g_unit = $_GET['g_unit'];

$presentTime = new newDate();			
$ls_datetime = $presentTime->present;

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
<html>
<head>
<title>中正大學各單位</title>
<script language="JavaScript">
	// 將視窗開到最大化
	self.moveTo(0,0);
	self.resizeTo(screen.availWidth,screen.availHeight);
</script>
</head>
<p align="center"><font color="#0033CC" size="5"><strong>教職員照片瀏覽
<?php  if ($title_type =='TEA'){echo "( 專任教師 )";}else if($title_type =='OFF'){echo "( 職員 )";} else if($title_type =='WOR'){echo "( 技工友 )";} else if($title_type =='UMI'){echo "( 專案工作人員 )";} ?></strong></font></p>
<li><font color="#FF0000" size="4">下列資料依職稱及中文姓名自左而右，自上而下排列</font></li>
<body>
<?php 
if($title_type =='TEA'){
	$sql="SELECT h0btbasic_per.c_name,
	             h0btbasic_per.d_join, 
                 h0etoffer.unit_cd,
		         h0rtunit_.unit_name,
	             h0rttilte_.title_cd,
		         h0rttilte_.title_fname,
		         h0etoffer.d_start,
         	     h0etoffer.d_end,
		         COALESCE(h0btbasic_per.path,'') as path,
		         h0btbasic_per.is_in,
		         LTRIM(RTRIM(CAST(h0rttilte_.in_order AS CHAR(10)))) as in_order  
	        FROM h0btbasic_per,
	             h0rttilte_,
	             h0rtunit_,
	             h0etoffer 
	       WHERE ( h0etoffer.staff_cd = h0btbasic_per.staff_cd ) and 
	       	     ( h0rtunit_.unit_cd = h0etoffer.unit_cd) and 
	       	     ( h0rttilte_.title_cd = h0etoffer.title_cd) and
	       	     ( ( h0btbasic_per.is_current='1') AND 
	       	     ( h0etoffer.is_current in ('Y','y')) and
	       	     ( h0btbasic_per.dist_cd  in ('TEA','PRO'))) and
	       	     ( h0etoffer.unit_cd = '$g_unit_cd') and
	       	     ( h0etoffer.d_start <= '$ls_datetime') and
         	     ( h0etoffer.d_end >= '$ls_datetime') and
         	     ( h0etoffer.off_continue in ('Y','y'))  
             UNION
             SELECT h0btbasic_per.c_name,
	                h0btbasic_per.d_join, 
		            h0etnew_prof.unit_cd,
		            h0rtunit_.unit_name,
                    h0rttilte_.title_cd,
		            h0rttilte_.title_fname,
	                h0etnew_prof.d_start,
         	        h0etnew_prof.d_end,
		            COALESCE(h0btbasic_per.path,'') as path,
	                h0btbasic_per.is_in,
		            LTRIM(RTRIM(CAST(h0rttilte_.in_order AS CHAR(10)))) as in_order  
	           FROM h0btbasic_per,
	                h0rttilte_,
	                h0rtunit_,
	                h0etnew_prof
	          WHERE ( h0etnew_prof.staff_cd = h0btbasic_per.staff_cd ) and 
	    	        ( h0rtunit_.unit_cd = h0etnew_prof.unit_cd ) and 
	       	        ( h0rttilte_.title_cd = h0etnew_prof.title_cd ) and
	       	        ( ( h0btbasic_per.is_current = '1' ) AND 
	       	        ( h0btbasic_per.dist_cd  in ('TEA','PRO'))) and
	       	        ( h0etnew_prof.unit_cd = '$g_unit_cd') and
	       	        ( h0etnew_prof.d_start <= '$ls_datetime' ) and
         	        ( h0etnew_prof.d_end >= '$ls_datetime') and
         	        ( h0etnew_prof.if_come in ('Y','y') )      
              ORDER BY in_order, title_cd, c_name";  
              }
         	    
else if($title_type =='OFF'){
	$sql="SELECT h0btbasic_per.c_name,
	             h0btbasic_per.d_join, 
		     h0rtunit_.unit_cd,
		     h0rtunit_.unit_name,
		     h0rttilte_.title_fname,
		     h0etchange.d_start,
         	     h0etchange.d_end,
		    COALESCE(h0btbasic_per.path,'') as path,
		     h0btbasic_per.is_in 
	        FROM h0btbasic_per,
	             h0etchange,
	             h0rttilte_,
	             h0rtunit_ 
	       WHERE ( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and 
	       	     ( h0rtunit_.unit_cd = h0etchange.unit_cd ) and 
	       	     ( h0rttilte_.title_cd = h0etchange.title_cd ) and
	       	     ( h0rttilte_.title_cd not in('O40','O42','T01','T02','T03','T05') )and 
	       	     ( ( h0btbasic_per.is_current = '1' ) AND 
	       	     ( h0etchange.is_current in ('Y','y') ) and
	       	     ( h0btbasic_per.dist_cd = '$title_type'  ) ) and
	       	     ( h0rtunit_.unit_cd = '$g_unit_cd') and
	       	     ( h0etchange.d_start <= '$ls_datetime' ) and
         	        ( (h0etchange.d_end >= '$ls_datetime') OR 
         	          (h0etchange.d_end = '') or
         	          (h0etchange.d_end is null) or
         	          (h0etchange.d_end = '0') )   
	  ORDER BY  h0rttilte_.in_order ASC, h0rttilte_.title_cd ASC, h0btbasic_per.c_name ASC";}

else if(($title_type =='WOR')|| ($title_type =='UMI') ){
	$sql="SELECT h0btbasic_per.c_name,
	             h0btbasic_per.d_join, 
		     h0rtunit_.unit_cd,
		     h0rtunit_.unit_name,
		     h0rttilte_.title_fname,
		     h0etchange.d_start,
         	     h0etchange.d_end,
		     COALESCE(h0btbasic_per.path,'') as path,
		     h0btbasic_per.is_in 
	        FROM h0btbasic_per,
	             h0etchange,
	             h0rttilte_,
	             h0rtunit_ 
	       WHERE ( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and 
	       	     ( h0rtunit_.unit_cd = h0etchange.unit_cd ) and 
	       	     ( h0rttilte_.title_cd = h0etchange.title_cd ) and
	       	     ( ( h0btbasic_per.is_current = '1' ) AND 
	       	     ( h0etchange.is_current in ('Y','y') ) and
	       	     ( h0btbasic_per.dist_cd = '$title_type'  ) ) and
	       	     ( h0rtunit_.unit_cd = '$g_unit_cd') and
	       	     ( h0etchange.d_start <= '$ls_datetime' ) and
         	        ( (h0etchange.d_end >= '$ls_datetime') OR 
         	          (h0etchange.d_end = '') or
         	          (h0etchange.d_end is null) or
         	          (h0etchange.d_end = '0') )   
	  ORDER BY  h0rttilte_.in_order ASC, h0rttilte_.title_cd ASC, h0btbasic_per.c_name ASC"; }
         	  
$result =pg_query($sql) or die("error!"); 
 ?>
<table width="100%" height="75" border="1" align="center"> <br>
<tr bgcolor="yellow">
    <td align="center">單位名稱</td>
    <td width="80" align="center">職稱</td>
    <td width="80" align="center">姓名</td>
    <td width="80" align="center">到校日</td>
    <td align="center">照片</td>
    <td align="center">單位名稱</td>
    <td width="80" align="center">職稱</td>
    <td width="80" align="center">姓名</td>
    <td width="80" align="center">到校日</td>
    <td align="center">照片</td>
</tr>
<?php 
$row =pg_fetch_array($result);
while(!empty($row)){
 ?>
  <tr> 
    <td><?php  echo $row['unit_name'];  ?></td>
    <td><?php  echo $row['title_fname'];  ?></td>
    <td><?php  echo $row['c_name'];  ?></td>
    <td align="center"><?php  echo dataFormat($row['d_join']);  ?></td>
    <td ><div align="center">     
        <?php  if(trim($row['path'])==""){ ?>
        <p><font color=#000099 size=4>照片尚未上傳</font></p>
        <?php  }else{ ?>
        <img src=<?php  echo "./".$row['is_in']."/".$row['path']; ?> width="120" height="150"></div></td>
    <?php  } ?>
    <?php  $row =pg_fetch_array($result); ?>    
    <?php  if(!empty($row)){ ?>
    <td><?php  echo $row['unit_name'];  ?></td>
    <td><?php  echo $row['title_fname'];  ?></td>
    <td><?php  echo $row['c_name'];  ?></td>
    <td align="center"><?php  echo dataFormat($row['d_join']);  ?></td>
    <td><div align="center">    
    <?php  if(trim($row['path'])==""){ ?>
        <p><font color=#000099 size=4>照片尚未上傳</font></p>
        <?php  }else{ ?>
        <img src=<?php  echo "./".$row['is_in']."/".$row['path']; ?> width="120" height="150"></div></td>
    <?php  } ?>
    <?php  $row =pg_fetch_array($result);}
      else if(empty($row)){ ?>
    <td><?php  echo "&nbsp";  ?></td>
    <td><?php  echo "&nbsp";  ?></td>
    <td><?php  echo "&nbsp";  ?></td>
    <td><?php  echo "&nbsp";  ?></td>
    <td><?php  echo "&nbsp";  ?></td>
    <?php } ?>
  </tr>
  <?php  } ?>  
</table>
<br>
</body>
</html>