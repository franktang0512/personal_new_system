<?php 
session_start();
$type="readonly";
include("inc/conn.php");
$sql=  " SELECT h0vtreward.d_rew  
           FROM h0vtreward  
	  WHERE h0vtreward.staff_cd ='".$_SESSION["id"]."'";   
$result1=pg_query($sql);
 ?>


<div id="maincontent">
<form name="date" method="POST">
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>獎懲資料查詢</span>
<span class="right">獎懲日期<select name="d_effect" onchange="document.date.submit();">
<option>請選擇</option>
<?php  while ($row=pg_fetch_array($result1)){
$year=substr($row['d_rew'],0,3);
$month=substr($row['d_rew'],3,2);
$day=substr($row['d_rew'],5,2);
$row['d_rew']=$year."/".$month."/".$day; ?> ?>
<option value = <?php  echo $row['d_rew']; ?> <?php if($row['d_rew']==$_POST["d_effect"]) echo "selected"; ?>> <?php  echo $row['d_rew']; ?></option>
<?php } ?>
</select>
</span>
</div>
<div class="spacer"></div>
</div>
<?php  if (pg_num_rows($result1)<=0) { ?>
  <table width="100%" >
  <tr > <td colspan="2" class="ptitle"><font color='#0000FF' size='4'>資料庫無資料! </font></td></tr>
  </table> 
</div>
<?php
   exit;
} ?>
<?php 
    $d_effect1=split("/",$_POST["d_effect"]);
    $d_effect=$d_effect1[0].$d_effect1[1].$d_effect1[2];   
 ?>
<?php 
if(empty($_POST["d_effect"])||trim($_POST["d_effect"])==""||$_POST["d_effect"]=="請選擇"){ ?>
<table width="100%" >
  <tr > <td colspan="2" class="ptitle"><font color='#0000FF' size='4'>請於右上方選擇日期</font></td></tr>
  </table> 
</div>
	<?php
	exit();
}
include("inc/func.php");
$sql="  SELECT h0vtreward.staff_cd, h0btbasic_per.id, h0vtreward.d_rew, h0vtreward.dist, h0vtreward.cd, h0vtreward.result_cd,
               h0vtreward.result_times, h0vtreward.doc, h0vtreward.content, h0vtreward.other_item    
	  FROM h0vtreward ,h0btbasic_per   
         WHERE h0vtreward.staff_cd ='".$_SESSION["id"]."'  and  (  h0vtreward.staff_cd =h0btbasic_per.id)and  
               ( h0vtreward.d_rew = '".$d_effect."'  )  "; 
if(!$result=pg_query($sql)){
echo "error!!";
echo $result;
}
$row=pg_fetch_array($result);
 ?>
<table width="100%" border="1" align="center">
  <tr align="center" >
    <td colspan="2" class="ptitle">獎懲資料</td>
  </tr>
  <tr> 
    <td width="33%" class="title">身分證字號</td>
    <td width="67%" class="content"> 
    <?php echo $row['id'];  ?>
    </td>
  </tr>
  <tr> 
    <td class="title">中文姓名</td>
    <td class="content"> 
      <?php echo $_SESSION["name"];?>
    </td>
  </tr>
    <tr> 
    <td width="35%" class="title">獎懲日期</td>
    <td width="35%" class="content"> 
     <?php   $year_d_rew=substr($row['d_rew'],0,3);
         $month_d_rew=substr($row['d_rew'],3,2);
         $day_d_rew=substr($row['d_rew'],5,2);
         $date_d_rew=$year_d_rew."/".$month_d_rew."/".$day_d_rew; 
         echo $date_d_rew;    ?>
    </td>
  </tr>
  <tr> 
    <td class="title">獎懲區分</td>
    <td class="content"> 
      <select name='dist' <?php  if ($type=="readonly"){echo "disabled";} ?>>
        <option ></option>
        <option value="1" <?php  if($row['dist']=="1"){echo "selected";}  ?>>平時</option>
        <option value="2" <?php  if($row['dist']=="2"){echo "selected";}  ?>>專案</option>
      </select>
    </td>
  </tr>
  <tr> 
    <td class="title">獎懲類別</td>
    <td class="content"> 
      <?php  rew_class("cd",$row['cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">事由內容</td>
    <td class="content"> 
      <?php @input_format("content",$row['content'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">獎懲結果</td>
    <td class="content"> 
      <?php rew_result("result_cd",$row['result_cd'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">獎懲結果次數</td>
    <td class="content"> 
      <?php  @input_format("result_times",$row['result_times'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">獎懲文號</td>
    <td class="content"> 
      <?php @input_format("doc",$row['doc'],$type); ?>
    </td>
  </tr>
  <tr> 
    <td class="title">備註</td>
    <td class="content"> 
      <?php @input_format("other_item",$row['other_item'],$type); ?>
    </td>
  </tr>
</table>
</form>
</div>