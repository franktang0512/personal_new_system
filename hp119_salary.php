<?php
session_start();
$type="readonly";
include("inc/conn.php");
$sql="SELECT h0ptsalary.d_effect      
      FROM h0ptsalary     
      WHERE h0ptsalary.staff_cd ='".$_SESSION["id"]."'
      ORDER BY h0ptsalary.d_effect ASC";   
$result1=pg_query($sql);
?>
<div id="maincontent">
<form id="form_style" name="date" method="POST">
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>敘薪資料查詢</span>
<span class="right">敘薪日期<select name="d_effect" onchange="document.date.submit();">
<option >請選擇</option>
<?php while($row=pg_fetch_array($result1)){
$year=substr($row['d_effect'],0,3);
$month=substr($row['d_effect'],3,2);
$day=substr($row['d_effect'],5,2);
$row['d_effect']=$year."/".$month."/".$day;?>
<option value="<?php echo $row['d_effect'];?>"<?php if($row['d_effect']==$_POST["d_effect"]) echo "selected";?>><?php echo $row['d_effect'];?></option>
<?php }?>
</select>
</span>
</div>
<div class="spacer"></div>
</div>
<?php if(pg_num_rows($result1)<=0){?>
  <table width="100%">
  <tr><td colspan="2" class="ptitle"><font color='#0000FF' size='4'>資料庫無資料!</font></td></tr>
  </table> 
</div>
<?php 
include("inc/menu.php");
include("inc/end.php");
exit;
}?>
<?php
    $d_effect1=split("/",$_POST["d_effect"]);
    $d_effect=$d_effect1[0].$d_effect1[1].$d_effect1[2];       
?>
<?php
if(empty($_POST["d_effect"])||trim($_POST["d_effect"])==""||$_POST["d_effect"]=="請選擇"){?>
<table width="100%">
  <tr><td colspan="2" class="ptitle"><font color='#0000FF' size='4'>請於右上方選擇日期</font></td></tr>
  </table> 
</div>
<?php 
include("inc/menu.php");
include("inc/end.php");
exit();
}
include("inc/func.php");
$sql=" SELECT h0ptsalary.staff_cd, h0btbasic_per.id, h0ptsalary.dist_cd, h0ptsalary.type, h0ptsalary.pub_rank,    
              h0ptsalary.d_data, h0ptsalary.pub_lev, h0ptsalary.is_serior, h0ptsalary.pub_level, h0ptsalary.point_base,    
	          h0ptsalary.point_add, h0ptsalary.point_sum, h0ptsalary.d_effect, h0ptsalary.reason_cd, h0ptsalary.remark,    
	          h0etchange.unit_cd, h0ptsalary.base_pay 
         FROM h0ptsalary,h0btbasic_per,h0etchange   
        WHERE (h0ptsalary.staff_cd=h0etchange.staff_cd) and ((h0ptsalary.staff_cd='".$_SESSION["id"]."')AND  
	          (h0ptsalary.staff_cd=h0btbasic_per.id) AND (h0etchange.is_current in ('Y','y')) AND (h0ptsalary.type='2')and 
	          (h0ptsalary.d_effect='".$d_effect."'))";
if(!$result=pg_query($sql)){
echo "error!!";
echo $result;}
$row=pg_fetch_array($result);

$sql1="SELECT h0etoffer.title_cd";    
$sql1=$sql1."FROM h0etoffer ";    
$sql1=$sql1."WHERE ( h0etoffer.staff_cd ='".$_SESSION['id']."') AND";  
$sql1=$sql1."( h0etoffer.d_start <= '".$d_effect."') and ";
$sql1=$sql1."( h0etoffer.d_end >= '".$d_effect."')";
$result2=pg_query($sql1);
$row1=pg_fetch_array($result2);
?>
<table width="100%" border="1" align="center">
  <tr align="center"> 
    <td colspan="2" class="ptitle">敘薪資料</td>
  </tr>
  <tr> 
    <td width="33%"  class="title">身分證字號</td>
    <td width="67%"  class="content"> 
      <?php echo $row['id']; ?>
    </td>
  </tr>
  <tr> 
    <td class="title">中文姓名</td>
    <td class="content"> 
      <?php echo $_SESSION["name"]; ?>
    </td>
  </tr>
  <tr> 
    <td class="title">起支日期</td>
    <td class="content"> 
     <?php $year_d_effect=substr($row['d_effect'],0,3);
       $month_d_effect=substr($row['d_effect'],3,2);
      $day_d_effect=substr($row['d_effect'],5,2);
      $date_d_effect=$year_d_effect."/".$month_d_effect."/".$day_d_effect;          
      @input_format("d_effect",$date_d_effect,$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">俸點</td>
    <td class="content"> 
      <?php @input_format("point_sum",$row['point_sum'],$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">等級</td>
    <td class="content"> 
      <?php @input_format("pub_lev",$row['pub_lev'],$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">薪點</td>
    <td class="content"> 
        <?php @input_format("pub_level",$row['pub_level'],$type);
        if(empty($row['pub_level'])||trim($row['pub_level'])=="") echo"&nbsp";
        else echo "級";?>
      <select name='is_serior' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="1" <?php if($row['is_serior']=="1"){echo "selected";} ?>>本俸</option>
        <option value="2" <?php if($row['is_serior']=="2"){echo "selected";} ?>>年功俸</option>
      </select>
    </td>
  </tr>
    <tr> 
    <td class="title">俸額</td>
    <td class="content"> 
      <?php echo salary($row['d_effect'],$row['point_sum'],2);?>
    </td>
  </tr>
  <tr> 
    <td class="title">學術研究費</td>
    <td class="content"> 
      <?php echo duty_pay($row['d_effect'],$row1['title_cd']);?>
    </td>
  </tr>
  <tr> 
    <td class="title">敘薪原因</td>
    <td class="content"> 
      <?php reason("reason",$row['reason_cd'],$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">備註</td>
    <td class="content"> 
      <?php @input_format("remark",$row['remark'],$type);?>
    </td>
  </tr>
</table>
</form>
</div>