<?php
session_start();
if( !isset($_SESSION["id"]) ) {//還沒登入或已經登出的情況,返回index
	header("Location:index.php");
}
$type="readonly";
//include("inc/conn.php");
include("inc/conn.php");
include("inc/unlogin.php");
//列出資料庫中的異動日期
$sql="SELECT DISTINCT h0etchange.d_start      
      FROM h0etchange      
      WHERE h0etchange.staff_cd ='".$_SESSION["id"]."'
      ORDER BY h0etchange.d_start";
      
      if(!$result=pg_query($sql)){
         echo "error!!";
      }
      else{
           $result1=pg_query($sql);
      }
?>
<div id="maincontent">
<form id="form_style" name="date" method="POST">
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>現職資料查詢</span>
<span class="right">任職起日<select name="d_start" onchange="document.date.submit();">
<option >請選擇</option>
<?php 
while($row=pg_fetch_array($result1)){
$year=substr($row['d_start'],0,3);
$month=substr($row['d_start'],3,2);
$day=substr($row['d_start'],5,2);
$row['d_start']=$year."/".$month."/".$day;
?>
<option value = <?php echo $row['d_start'];?> <?php if($row['d_start']==$_POST["d_start"]) echo "selected";?>> <?php echo $row['d_start'];?></option>
<?php 
} 
?>
</select>
</span>
</div>
<div class="spacer"></div>
</div>
<?php 
 
echo $row['d_start'];

if(pg_num_rows($result1)<=0){ 
?>
  <table width="100%" >
  <tr > <td colspan="2" class="ptitle"><font color='#0000FF' size='4'>資料庫無資料!</font></td></tr>
  </table>
</div>
<?php
	include("inc/menu.php");
	include("inc/end.php");
	exit;
}
?>
<?php
    $d_start1=split("/",$_POST["d_start"]);
    $d_start=$d_start1[0].$d_start1[1].$d_start1[2];   
?>
<?php
if(empty($_POST["d_start"])||trim($_POST["d_start"])==""||$_POST["d_start"]=="請選擇"){?>
<table width="100%" >
  <tr > <td colspan="2" class="ptitle"><font color='#0000FF' size='4'>請於右上方選擇日期</font></td></tr>
  </table> 
</div>
	<?php
	include("inc/menu.php");
	include("inc/end.php");
	exit();
}
include("inc/func.php");
$sql = "SELECT h0etchange.staff_cd,h0btbasic_per.id,h0etchange.title_cd,
               h0etchange.dist_cd,h0etchange.unit_cd,h0etchange.pub_cd,
               h0etchange.duty_cd,h0etchange.job_cd,h0etchange.task_cd,
               h0etchange.need_qual,h0etchange.pos,h0etchange.d_start,  
               h0etchange.doc, h0etchange.d_doc,h0etchange.d_end,
               h0etchange.in_reason,h0etchange.out_reason,
               h0etchange.is_current,h0etchange.torga_cd,h0etchange.is_partjob_cd,
               h0etchange.d_base_start, h0etchange.d_base_end,h0etchange.remark,
               h0btbasic_per.dist_cd, h0etchange.d_effect    
          FROM h0etchange,h0btbasic_per       
         WHERE(h0etchange.staff_cd='".$_SESSION["id"]."') and (h0etchange.staff_cd=h0btbasic_per.id) and (h0etchange.d_start='".$d_start."')";


if(!$result=pg_query($sql)){
echo "error!!";
echo $result;
}
$row=pg_fetch_array($result);
?>
<table width="100%" border="1" align="center">
  <tr align="center" > 
    <td colspan="2" class="ptitle">現職資料</td>
  </tr>
  <tr> 
    <td width="33%" class="title"> 身分證字號</td>
    <td width="67%" class="content"> 
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
    <td class="title">職稱</td>
    <td class="content"> 
      <?php title("title",$row['title_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">任職別</td>
    <td class="content"> 
      <?php dist("dist",$row['dist_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">單位</td>
    <td class="content"> 
      <?php unit("unit",$row['unit_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">部定官職等</td>
    <td class="content"> 
      <?php pub_cd("pub_cd",$row['pub_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">職系</td>
    <td class="content"> 
      <?php  duty("duty",$row['duty_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">工作類別</td>
    <td class="content"> 
      <?php job("job",$row['job_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">職務編號</td>
    <td class="content"> 
      <?php @input_format("task_cd",$row['task_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">銓敘別</td>
    <td class="content"> 
      <select name='need_qual' <?php if ($type=="readonly"){echo "disabled";} ?>>
        <option ></option>
        <option value="Y" <?php if($row['need_qual']=="Y"){echo "selected";} ?>>是</option>
        <option value="N" <?php if($row['need_qual']=="N"){echo "selected";} ?>>否</option>
      </select>
    </td>
  </tr>
  <tr> 
    <td class="title">調辦人事會計分</td>
    <td class="content"> 
      <select name='pos' <?php if ($type=="readonly"){echo "disabled";} ?>>
        <option ></option>
        <option value="Y" <?php if($row['pos']=="Y"){echo "selected";} ?>>是</option>
        <option value="N" <?php if($row['pos']=="N"){echo "selected";} ?>>否</option>
      </select>
    </td>
  </tr>
  <tr> 
    <td class="title">生效日期</td>
    <td class="content"> 
      <?php $year_d_start=substr($row['d_effect'],0,3);
         $month_d_start=substr($row['d_effect'],3,2);
         $day_d_start=substr($row['d_effect'],5,2);
         $date_d_start=$year_d_start."/".$month_d_start."/".$day_d_start;       
         @input_format("d_effect",$date_d_start,$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">任職文號</td>
    <td class="content"> 
      <?php 
      @input_format("doc",$row['doc'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">任職發文日期</td>
    <td class="content"> 
     <?php if(empty($row['d_doc'])||trim($row['d_doc'])==""){
	  		 $date_d_doc="&nbsp";
		 }else{
         $year_d_doc=substr($row['d_doc'],0,3);
         $month_d_doc=substr($row['d_doc'],3,2);
         $day_d_doc=substr($row['d_doc'],5,2);
         $date_d_doc=$year_d_doc."/".$month_d_doc."/".$day_d_doc;} 
		
         @input_format("d_doc",$date_d_doc,$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">任職起日</td>
    <td class="content"> 
    <?php $year_d_start=substr($row['d_start'],0,3);
       $month_d_start=substr($row['d_start'],3,2);
       $day_d_start=substr($row['d_start'],5,2);
       $date_d_start=$year_d_start."/". $month_d_start."/".$day_d_start;     
        @input_format("d_start",$date_d_start,$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">任職迄日</td>
    <td class="content"> 
   <?php  if($row['d_end']!=""){
   	$year_d_end=substr($row['d_end'],0,3);
        $month_d_end=substr($row['d_end'],3,2);
        $day_d_end=substr($row['d_end'],5,2);
        $date_d_end=$year_d_end."/".$month_d_end."/".$day_d_end; 
        }else{
        $date_d_end="&nbsp";}
        @input_format("d_end",$date_d_end,$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">任職原因</td>
    <td class="content"> 
      <?php reason("in_reason",$row['in_reason'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">離職原因</td>
    <td class="content"> 
      <?php @reason("out_reason",$row['out_reason'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">是否為現職</td>
    <td class="content"> 
      <select name='is_current' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="Y" <?php if($row['is_current']=="Y"){echo "selected";} ?>>是</option>
        <option value="N" <?php if($row['is_current']=="N"){echo "selected";} ?>>否</option>
      </select>
    </td>
  </tr>
  <tr> 
    <td class="title">機關代碼</td>
    <td class="content"> 
      <?php orga("orga",$row['torga_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">基礎訓練日期起</td>
    <td class="content"> 
    <?php    if($row['d_base_start']==""){
            $d_base_start="&nbsp";}
           else{
        $year_d_base_start=substr($row['d_base_start'],0,3);
        $month_d_base_start=substr($row['d_base_start'],3,2);
        $day_d_base_start=substr($row['d_base_start'],5,2);
        $date_d_base_start=$year_d_base_start."/".$month_d_base_start."/".$day_d_base_start;}  
    @input_format("d_base_start",$date_d_base_start,$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">基礎訓練日期迄</td>
    <td class="content"> 
    <?php  if($row['d_base_end']=="")
            $d_base_end="&nbsp";
        else{
        $year_d_base_end=substr($row['d_base_end'],0,3);
        $month_d_base_end=substr($row['d_base_end'],3,5);
        $day_d_base_end=substr($row['d_base_end'],5,2);
        $date_d_base_end=$year_d_base_end."/".$month_d_base_end."/".$day_d_base_end; }        
        @input_format("d_base_end", $date_d_base_end,$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">是否兼行政職</td>
    <td class="content"> 
      <select name='is_partjob_cd' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="Y" <?php if($row['is_partjob_cd']=="Y"){echo "selected";} ?>>是</option>
        <option value="N" <?php if($row['is_partjob_cd']=="N"){echo "selected";} ?>>否</option>
      </select>
    </td>
  </tr>
  <tr> 
    <td class="title">備註</td>
    <td class="content"> 
      <?php @input_format("remark",$row['remark'],$type); ?>
    </td>
  </tr>
</table>
<!-- 技工友資料若有問題,則出現維護者以便使用者聯絡 -->
<?php if($row['per_dist_cd'] == "WOR"){ ?>
<center><font size=2 style="color:#0000FF">
請注意:若您的現職資料有問題,請洽總務處事務組-陳忠勇先生維護</center>
<?php } ?>
</form>
</div>