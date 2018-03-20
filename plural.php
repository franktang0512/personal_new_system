<?php 
session_start();
$type="readonly";
include("inc/conn.php");
include("inc/unlogin.php"); 

$sql = "SELECT h0etside_job.d_start	FROM h0etside_job WHERE h0etside_job.staff_cd ='".$_SESSION["id"]."'";
$result1=pg_query($sql);
?>
<div id="maincontent">
<form id="form_style" name="date" >
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="row">
<span class="left">主選單>經歷資料查詢>教師兼行政職查詢</span>
</div></div>
<?php if (pg_num_rows($result1)<=0) { ?>
  <table width="100%" >
  <tr > <td colspan="2" class="ptitle"><font color='#0000FF' size='4'>資料庫無資料! </font></td></tr>
  </table> 
</div>
<?php
include("inc/menu.php");
	include("inc/end.php");
	exit();
} 

$a =pg_num_rows($result1);
$row =pg_fetch_array($result1);

include("inc/func.php");
$sql = "SELECT h0etside_job.unit_cd,h0etside_job.job_type,h0etside_job.title_cd,h0etside_job.d_start,h0etside_job.d_end
          FROM h0etside_job       
	 WHERE h0etside_job.staff_cd = '".$_SESSION["id"]."'
	 ORDER BY h0etside_job.d_start ASC";
	
	 if(!$result=pg_query($sql)){
echo "error!!";
echo $result;
}

$num =pg_num_rows($result);
 ?>
<table width="100%" border="1" align="center">
  <tr align="center" class="ptitle">
    <td>項次</td>
    <td>兼任單位</td>
    <td>兼任別</td>
    <td>兼任職務</td>
    <td>聘期起迄</td>
  </tr>
  <?php for($i=0;$i<$num;$i++):
$row[$i]=pg_fetch_array($result);
$a = $i +1; ?>
  <tr>
    <td><?php echo  $a; ?></td>
    <td><?php plural_unit("plural_unit",$row[$i]['unit_cd'],$type); ?></td>
    <td><?php
           if($row[$i]['job_type']=='1'){echo "兼任";}
    	   else if($row[$i]['job_type']=='2'){echo "兼代";}
    	   else if($row[$i]['job_type']=='3'){echo "代理";}
    	   else if($row[$i]['job_type']=='4'){echo "暫代";}
           else{ echo "&nbsp";}
    ?></td>
    <td><?php plural_title_cd("plural_title_cd", $row[$i]['title_cd'],$type);?></td>
    <td><?php $year_d_start=substr($row[$i]['d_start'],0,3);
               $month_d_start=substr($row[$i]['d_start'],3,2);
               $date_d_start = substr($row[$i]['d_start'],5,2);
               $time_d_start=$year_d_start."/".$month_d_start."/".$date_d_start;
        
              $year_d_end=substr($row[$i]['d_end'],0,3);
              $month_d_end=substr($row[$i]['d_end'],3,2);
              $date_d_end = substr($row[$i]['d_end'],5,2);             
              $time_d_end=$year_d_end."/".$month_d_end."/".$date_d_end;
      	
      	 	if($row[$i]['d_start']=""){echo "&nbsp";}
      	 	else	{echo $time_d_start ."~". $time_d_end ;} ?></td>
  
  </tr>
  <?php
		endfor;
	?>
</table>
</form> 
	</div>

<?php 
include("inc/menu.php");
include("inc/end.php"); ?>