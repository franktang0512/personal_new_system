<?php 
session_start();
$type="readonly";
include("inc/conn.php");
include("inc/unlogin.php"); 

$sql = "SELECT h0bthistory.d_start	FROM h0bthistory	WHERE   h0bthistory.staff_cd ='".$_SESSION["id"]."'";
$result1=pg_query($sql);
?>
<div id="maincontent">
<form id="form_style" name="date" >
<div style= "width: 100%; background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="row">
<span class="left">主選單>經歷資料查詢>到校前經歷資料查詢</span>
</div></div>
<?php

if (pg_num_rows($result1)<=0) {?>
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
$sql = "SELECT   h0bthistory.torga_cd,h0bthistory.pub_title_cd,h0bthistory.pub_cd,h0bthistory.duty_cd,h0bthistory.d_start,
		 h0bthistory.d_end,h0bthistory.out_reason
          FROM   h0bthistory       
	 WHERE  h0bthistory.staff_cd = '".$_SESSION["id"]."'
	 ORDER BY h0bthistory.d_start ASC";
	 if(!$result=pg_query($sql)){
echo "error!!";
echo $result;
}

$num = pg_num_rows($result);
 ?>
<table width="100%" border="1" align="center">
  <tr align="center" class="ptitle"> 

        <td>項次</td>
        <td>機關</td>
        <td>職稱</td>
        <td>官職等</td>
        <td>職系</td>
        <td>任職起迄</td>
        <td>離職原因</td>
    </tr>
	<?php for($i=0;$i<$num;$i++):
$row[$i]=pg_fetch_array($result);
$a = $i +1; ?>
	
      <tr>
        <td><?php echo  $a; ?></td>
        <td><?php pre_torga("pre_torga",$row[$i]['torga_cd'],$type); ?></td>
        <td><?php pre_pub_title_cd("pre_pub_title_cd",$row[$i]['pub_title_cd'],$type);?></td>
        <td><?php pre_pub_cd("pre_pub_cd", $row[$i]['pub_cd'],$type);?></td>
        <td><?php pre_duty_cd("pre_duty_cd",$row[$i]['duty_cd'],$type);?></td>
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
        <td><?php pre_out_reason("pre_out_reason", $row[$i]['out_reason'],$type);?></td>
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