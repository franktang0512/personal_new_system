<?php
session_start();
if( !isset($_SESSION["id"]) ) {//還沒登入或已經登出的情況,返回index
	header("Location:index.php");
}
$type="readonly";
include("inc/conn.php");
$sql=  "SELECT  DISTINCT h0pttemp_wage.d_effect  
          FROM  h0pttemp_wage    
         WHERE  h0pttemp_wage.staff_cd ='".$_SESSION["id"]."'";   
$result1=pg_query($sql);
?>
<div id="maincontent">
<form id ="form_style" name="date" method="POST">
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>敘薪資料查詢</span>
<span class="right">敘薪日期<select name="d_effect" onchange="document.date.submit();">
<option >請選擇</option>
<?php while ($row=pg_fetch_array($result1)){
$year=substr($row['d_effect'],0,3);
$month=substr($row['d_effect'],3,2);
$day=substr($row['d_effect'],5,2);
$row['d_effect']=$year."/".$month."/".$day;?>
<option value = <?php echo $row['d_effect'];?> <?php if($row['d_effect']==$_POST["d_effect"]) echo "selected";?>> <?php echo $row['d_effect'];?></option>
<?php }?>
</select>
</span>
</div>
<div class="spacer"></div>
</div>
<?php if (pg_num_rows($result1)<=0) {?>
  <table width="100%" >
  <tr > <td colspan="2" class="ptitle"><font color='#0000FF' size='4'>資料庫無資料! </font></td></tr>
  </table> 
</div>
<?php include("inc/menu.php");
	include("inc/end.php");
   exit;
}?>
<?php
    $d_effect1=split("/",$_POST["d_effect"]);
    $d_effect=$d_effect1[0].$d_effect1[1].$d_effect1[2];   
?>
<?php
if(empty($_POST["d_effect"])||trim($_POST["d_effect"])==""||$_POST["d_effect"]=="請選擇"){?>
<table width="100%" >
  <tr > <td colspan="2" class="ptitle"><font color='#0000FF' size='4'>請於右上方選擇日期</font></td></tr>
  </table> 
</div>
<?php include("inc/menu.php");
	include("inc/end.php");
	exit();
}
include("inc/func.php");
$sql="SELECT   h0pttemp_wage.staff_cd, h0btbasic_per.id, h0pttemp_wage.d_effect, h0pttemp_wage.cd, h0pttemp_wage.rank, 
               h0pttemp_wage.p_level, h0pttemp_wage.point_edu, h0pttemp_wage.point_exe, h0pttemp_wage.wage, 
               h0pttemp_wage.extra, h0pttemp_wage.standard, h0pttemp_wage.is_save, h0pttemp_wage.remark 
       FROM    h0pttemp_wage,h0btbasic_per 
      WHERE    ( h0pttemp_wage.staff_cd = '".$_SESSION["id"]."' ) AND ( h0pttemp_wage.staff_cd =h0btbasic_per.id)and  
               ( h0pttemp_wage.d_effect = '".$d_effect."' )";
            
if(!$result=pg_query($sql)){
echo "error!!";
echo $result;
}
$row=pg_fetch_array($result);
?>

<table width="100%" border="1" align="center">
  <tr align="center" > 
    <td colspan="2" class="ptitle">敘薪資料</td>
  </tr>
    <tr> 
    <td width="33%" class="title">身分證字號</td>
    <td width="67%" class="content"> 
      <?php echo $row['id']; ?>
    </td>
  </tr>
  <tr> 
    <td class="title" >中文姓名</td>
    <td class="content" > 
      <?php echo $_SESSION["name"]; ?>
    </td>
  </tr>
   <tr> 
    <td width="35%" class="title">生效日期</td>
    <td width="35%" class="content"> 
     <?php $year_d_effect=substr($row['d_effect'],0,3);
         $month_d_effect=substr($row['d_effect'],3,2);
         $day_d_effect=substr($row['d_effect'],5,2);
         $date_d_effect=$year_d_effect."/".$month_d_effect."/".$day_d_effect;       
         ?>  
    <?php echo $date_d_effect; ?>
    </td>
  </tr>
  <tr> 
    <td class="title">職等</td>
    <td class="content"> 
      <?php @input_format("rank",$row['rank'],$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">薪級</td>
    <td class="content"> 
      <?php @input_format("p_level",$row['p_level'],$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">俸點</td>
    <td class="content"> 
      <?php @input_format("point",$row['point_edu'],$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">加給</td>
    <td class="content"> 
      <?php  $extra=number_format($row['extra']);
         @input_format("extra",$extra,$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">月支酬勞</td>
    <td class="content"> 
      <?php $wage=number_format($row['wage']);
      @input_format("wage",$wage,$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">行政院報酬薪點</td>
    <td class="content"> 
      <?php @input_format("point_exe",$row['point_exe'],$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">預算科目</td>
    <td class="content"> 
      <?php subj_cd("cd",$row['cd'],$type);?>
    </td>
  </tr>
  <tr> 
    <td class="title">是否加入離職酬金</td>
    <td class="content"> 
      <select name='is_save' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="Y" <?php if($row['is_save']=="Y"){echo "selected";} ?>>是</option>
        <option value="N" <?php if($row['is_save']=="N"){echo "selected";} ?>>否</option>
      </select>
    </td>
  </tr>
   <tr> 
    <td class="title">支薪比照標準</td>
    <td class="content"> 
      <?php @input_format("standard",$row['standard'],$type);?>
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