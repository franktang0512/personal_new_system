<?php
session_start();
include('inc/header.php');
include ("inc/func.php");

$title_type = $_GET['title_type'];

$presentTime = new newDate();			
$ls_datetime = $presentTime->present;

if(empty($_SESSION["id"])=="1"||$_SESSION["id"]=="")
{
	header("Location:index.php");
	exit;
}

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
$item_content ='
<div id="main_content">';
$item_content .='</div>
<script src="js/menu_categories/seepic_addic.js"></script>
';

$content = $slide_menu . $item_content;
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
<?php if ($title_type =='0'){echo "( 校長、副校長 )";}else if($title_type =='1'){echo "( 一級主管 )";} else if($title_type =='2'){echo "( 二級主管 )";}  ?></strong></font></p>
<li><font color="#FF0000" size="4">下列資料依單位及中文姓名自左而右，自上而下排列</font></li>
<body>
<?php  
if ($title_type =='0'){
	$sql = " SELECT h0etside_job.staff_cd,
			h0btbasic_per.c_name,
			h0etside_job.title_cd,
			h0rttilte_.title_fname,
			h0rtunit_.unit_name,
			h0rtunit_.unit_cd, 
			h0etside_job.d_start,
			h0etside_job.d_end,
			COALESCE(h0btbasic_per.path,'') as path,
			h0btbasic_per.is_in 
		FROM 	h0etside_job,h0btbasic_per,h0rttilte_,h0rtunit_ 
		WHERE 	( h0btbasic_per.staff_cd = h0etside_job.staff_cd ) and 
			( h0etside_job.title_cd = h0rttilte_.title_cd ) and
			( h0rtunit_.unit_cd = h0etside_job.unit_cd ) and 
			( h0etside_job.title_cd in('O00','O01') )and 
			( h0etside_job.is_current in('Y','y')) and
			( h0etside_job.d_start <= '$ls_datetime' ) and 
			(( h0etside_job.d_end >= '$ls_datetime' )  OR 
         	          (h0etside_job.d_end = '') or
         	          (h0etside_job.d_end is null) or
         	          (h0etside_job.d_end = '0')) 
	       Order By h0rtunit_.unit_cd ASC ";}
else if($title_type =='1'){
	 $sql=" SELECT h0etside_job.staff_cd, 
         	        h0btbasic_per.c_name,
         		h0etside_job.unit_cd,
         		h0rtunit_.unit_name,
        		h0etside_job.title_cd,
         		h0etside_job.title_job,
         		h0rttilte_.title_fname,
         		h0etside_job.boss_level,
         		h0etside_job.d_start,
         		h0etside_job.d_end,
         		h0etside_job.doc,
         		h0etside_job.is_current,
         	COALESCE(h0btbasic_per.path,'') as path,
	       	      	h0btbasic_per.is_in
    		FROM    h0btbasic_per,
         		h0etside_job,
         		h0rttilte_,
         		h0rtunit_
   		WHERE   ( h0etside_job.staff_cd =  h0btbasic_per.staff_cd ) and
         	        ( h0rttilte_.title_cd = h0etside_job.title_cd ) and
    		        ( h0rtunit_.unit_cd = h0etside_job.unit_cd ) and   
  	 	      	( h0etside_job.title_cd not in('O00','O01') )and 
  	 	      	( h0etside_job.boss_level in ('3')) and 
  	 	      	( h0etside_job.is_current in('Y','y')) and
    		        ( h0etside_job.d_start <= '$ls_datetime' ) and
         	        (( h0etside_job.d_end >= '$ls_datetime' ) OR 
         	          (h0etside_job.d_end = '') or
         	          (h0etside_job.d_end is null) or
         	          (h0etside_job.d_end = '0')) 
  	       
         	 UNION     
         	   
	  	    SELECT  h0etchange.staff_cd,  			
                	h0btbasic_per.c_name,
   	     	      	h0etchange.unit_cd,
         	      	h0rtunit_.unit_name,
        	      	h0etchange.title_cd,
         	      	h0rtunit_.unit_name||h0rttilte_.title_fname as title_job,
         	      	h0rttilte_.title_fname,
         	      	'3' as boss_level,
         	      	h0etchange.d_start,
         	      	h0etchange.d_end,
         	      	h0etchange.doc,
         	      	h0etchange.is_current,
         	      	COALESCE(h0btbasic_per.path,'') as path,
	       	      	h0btbasic_per.is_in
   	         FROM 	h0btbasic_per,
         	      	h0etchange,
         	      	h0rtunit_,
         	      	h0rttilte_
                WHERE 	( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and
         	      	( h0rtunit_.unit_cd = h0etchange.unit_cd ) and
         	      	( h0rttilte_.title_cd = h0etchange.title_cd ) and
  	 	      	( h0rttilte_.title_cd = 'O40' ) and  
  	 	      	( h0btbasic_per.is_current = '1') and 
  	 	      	( h0etchange.is_current in ('y','Y') ) AND   
    		        ( h0etchange.d_start <= '$ls_datetime' ) and
         	        ( (h0etchange.d_end >= '$ls_datetime') OR 
         	          (h0etchange.d_end = '') or
         	          (h0etchange.d_end is null) or
         	          (h0etchange.d_end = '0') )   
         	ORDER BY unit_cd ";   }
  
else if($title_type =='2'){                    
     	 $sql=" SELECT h0etside_job.staff_cd,
         	        h0btbasic_per.c_name,
         		h0etside_job.unit_cd,
         		h0rtunit_.unit_name,
        		h0etside_job.title_cd,
         		h0etside_job.title_job,
         		h0rttilte_.title_fname,
         		h0etside_job.boss_level,
         		h0etside_job.d_start,
         		h0etside_job.d_end,
         		h0etside_job.doc,
         		h0etside_job.is_current,
         		COALESCE(h0btbasic_per.path,'') as path,
	       	      	h0btbasic_per.is_in
    		FROM    h0btbasic_per,
         		h0etside_job,
         		h0rttilte_,
         		h0rtunit_
   		WHERE   ( h0etside_job.staff_cd =  h0btbasic_per.staff_cd ) and
         	        ( h0rttilte_.title_cd = h0etside_job.title_cd ) and
    		        ( h0rtunit_.unit_cd = h0etside_job.unit_cd ) and   
  	 	      	( h0etside_job.title_cd not in('O00','O01') )and 
  	 	      	( h0etside_job.boss_level in ('4','5')) and 
  	 	      	( h0etside_job.is_current in('Y','y')) and
    		        ( h0etside_job.d_start <= '$ls_datetime' ) and
         	        ( ( h0etside_job.d_end >= '$ls_datetime' ) OR 
         	    	  ( h0etside_job.d_end = '') or
         	    	  ( h0etside_job.d_end is null) or
         	          ( h0etside_job.d_end = '0') )   
  	       
         	 UNION     
         	   
	  	SELECT  h0etchange.staff_cd,  			
                	h0btbasic_per.c_name,
       	     	      	h0etchange.unit_cd,
         	      	h0rtunit_.unit_name,
        	      	h0etchange.title_cd,
         	      	h0rtunit_.unit_name||h0rttilte_.title_fname as title_job,
         	      	h0rttilte_.title_fname,
         	      	'4' as boss_level,
         	      	h0etchange.d_start,
         	      	h0etchange.d_end,
         	      	h0etchange.doc,
         	      	h0etchange.is_current,
         	      	COALESCE(h0btbasic_per.path,'') as path,
	       	      	h0btbasic_per.is_in
   	         FROM 	h0btbasic_per,
         	      	h0etchange,
         	      	h0rtunit_,
         	      	h0rttilte_
                WHERE 	( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and
         	      	( h0rtunit_.unit_cd = h0etchange.unit_cd ) and
         	      	( h0rttilte_.title_cd = h0etchange.title_cd ) and
  	 	      	( h0rttilte_.title_cd = 'O42' ) and  
  	 	      	( h0btbasic_per.is_current = '1') and 
  	 	      	( h0etchange.is_current in ('y','Y') ) AND   
    		        ( h0etchange.d_start <= '$ls_datetime' ) and
         	        ( (h0etchange.d_end >= '$ls_datetime') OR 
         	          (h0etchange.d_end = '') or
         	          (h0etchange.d_end is null) or
         	          (h0etchange.d_end = '0') )   
         	ORDER BY unit_cd ";   }
         	  
$result =pg_query($sql) or die("error"); 

 ?>
<table width="100%" height="75" border="1" align="center"> <br>
<tr bgcolor="yellow">
    <td align="center">單位名稱</td>
    <td width="80" align="center">職稱</td>
    <td width="80" align="center">姓名</td>
    <td width="80" align="center">起聘日</td>
    <td align="center">照片</td>
    <td align="center">單位名稱</td>
    <td width="80" align="center">職稱</td>
    <td width="80" align="center">姓名</td>
    <td width="80" align="center">起聘日</td>
    <td align="center">照片</td>
</tr>
<?php
$row =pg_fetch_array($result);
while(!empty($row)){
 ?>
  <tr> 
    <td><?php echo $row['unit_name'];  ?></td>
    <td><?php echo $row['title_fname'];  ?></td>
    <td><?php echo $row['c_name'];  ?></td>
    <td align="center"><?php echo dataFormat($row['d_start']);  ?></td>
    <td ><div align="center">     
        <?php if(trim($row['path'])==""){ ?>
        <p><font color=#000099 size=4>照片尚未上傳</font></p>
        <?php }else{ ?>
        <img src=<?php echo "./".$row['is_in']."/".$row['path']; ?> width="120" height="150"></div></td>
    <?php } ?>
    <?php $row =pg_fetch_array($result); ?>    
    <?php if(!empty($row)){ ?>
    <td><?php echo $row['unit_name'];  ?></td>
    <td><?php echo $row['title_fname'];  ?></td>
    <td><?php echo $row['c_name'];  ?></td>
    <td align="center"><?php echo dataFormat($row['d_start']);  ?></td>
    <td><div align="center">    
    <?php if(trim($row['path'])==""){ ?>
        <p><font color=#000099 size=4>照片尚未上傳</font></p>
        <?php }else{ ?>
        <img src=<?php echo "./".$row['is_in']."/".$row['path']; ?> width="120" height="150"></div></td>
    <?php } ?>
    <?php $row =pg_fetch_array($result);}
    else if(empty($row)){ ?>
    <td><?php echo "&nbsp";  ?></td>
    <td><?php echo "&nbsp";  ?></td>
    <td><?php echo "&nbsp";  ?></td>
    <td><?php echo "&nbsp";  ?></td>
    <td><?php echo "&nbsp";  ?></td>
    <?php } ?>
  </tr>
  <?php } ?>
</table>
<br>
</body>
</html>
<?php
include('inc/footer.php');
?>