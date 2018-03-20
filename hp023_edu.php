<?php   
session_start();
$type="readonly";
include("inc/conn.php");
$sql="SELECT h0btedu_bg.edu_bg_d_start ";
$sql=$sql." FROM h0btedu_bg";
$sql=$sql." WHERE h0btedu_bg.staff_cd ='".$_SESSION["id"]."'";
$result1=pg_query($sql);
  ?>
<div id="maincontent">
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
	<form id="form_style" name="date" method="POST">
		
		<div class="spacer"></div>
		<div class="row">
			<span class="left">主選單>學歷資料查詢</span>
			<span class="right">修業期間(起)
				<select name="d_effect" onchange="document.date.submit();">
					<option >請選擇</option>
					<?php    
					while ($row=pg_fetch_array($result1)){
					$year=substr($row['edu_bg_d_start'],0,3);
					$month=substr($row['edu_bg_d_start'],3,2);
					$row['edu_bg_d_start']=$year."/".$month;
					  ?>
					<option value = <?php    echo $row['edu_bg_d_start'];  ?> <?php    if($row['edu_bg_d_start']==$_POST["d_effect"]) echo "selected";   ?>> <?php    echo $row['edu_bg_d_start'];   ?></option>
					<?php   }  ?>
				</select>
			</span>
		</div>
		
	</form> 
</div>	
 <div class="spacer">

<?php
if (pg_num_rows($result1)<=0) {  

	echo '<table width="100%" >
			  <tr>
				<td colspan="2" class="ptitle">
					<font color="#0000FF" size="4">資料庫無資料! </font>
				</td>
			  </tr>
		  </table> 
</div>';
	   
	include("inc/menu.php");
	include("inc/end.php");
	exit;
}   
$d_effect1=split("/",$_POST["d_effect"]);
$d_effect2=$d_effect1[0].$d_effect1[1] ;  
   
if(empty($_POST["d_effect"])||trim($_POST["d_effect"])==""||$_POST["d_effect"]=="請選擇"){ 
	echo'<table width="100%">
			<tr > 
				<td colspan="2" class="ptitle">
					<font color="#0000FF" size="4">請於右上方選擇日期</font>
				</td>
			</tr>
		 </table> 
	</div>';
	exit();
}
include("inc/func.php");

$sql="SELECT h0btedu_bg.staff_cd,  ";   
$sql= $sql."h0btbasic_per.id, ";  
$sql= $sql."h0btedu_bg.edu_deg_cd,    ";  
$sql= $sql."h0btedu_bg.edu_dept,    ";  
$sql= $sql."h0btedu_bg.edu_status,    ";  
$sql= $sql."h0btedu_bg.edu_nation,    "; 
$sql= $sql."h0btedu_bg.edu_school,    ";  
$sql= $sql."h0btedu_bg.edu_bg_d_end,    ";  
$sql= $sql."h0btedu_bg.edu_bg_d_start,    ";  
$sql= $sql."h0btedu_bg.edu_grp_cd,    ";  
$sql= $sql."h0btedu_bg.specialty_cd,    ";  
$sql= $sql."h0btedu_bg.specialty_cd1,    ";  
$sql= $sql."h0btedu_bg.specialty_cd2,    ";  
$sql= $sql."h0btedu_bg.edu_nation,    ";  
$sql= $sql."h0btedu_bg.is_edu,   ";  
$sql= $sql."h0btbasic_per.dist_cd   ";  
$sql= $sql."FROM h0btedu_bg,h0btedu_status_,h0btbasic_per ";  
$sql= $sql."WHERE h0btedu_bg.staff_cd = '".$_SESSION["id"]."'  and ";
$sql= $sql." ( h0btedu_bg.staff_cd =h0btbasic_per.id)and "; 
$sql= $sql." h0btedu_bg.edu_bg_d_start = '".$d_effect2."'";
//$sql= $sql."h0btedu_bg.edu_status *= h0btedu_status_.edu_status";  

if(!$result=pg_query($sql)){
echo "error!!";
}
$row=pg_fetch_array($result);  ?>

<table width="100%" border="1" align="center">
  <tr align="center" class="ptitle"> 
    <td colspan="2">學歷資料</td>
  </tr>
  <tr> 
    <td width="33%" class="title">身分證字號</td>
    <td width="67%" class="content"> 
      <?php   echo $row['id'];   ?>
    </td>
  </tr>
  <tr> 
    <td class="title">中文姓名</td>
    <td class="content"> 
      <?php echo $_SESSION["name"];?>
    </td>
  </tr>
  <tr> 
    <td class="title">修業期間</td>
    <td class="content"> 
      <?php    $year_edu_bg_d_start=substr($row['edu_bg_d_start'],0,3);
         $month_edu_bg_d_start=substr($row['edu_bg_d_start'],3,2);
         $time_edu_bg_d_start=$year_edu_bg_d_start."/".$month_edu_bg_d_start;
        
         $year_edu_bg_d_end=substr($row['edu_bg_d_end'],0,3);
         $month_edu_bg_d_end=substr($row['edu_bg_d_end'],3,2);
         $time_edu_bg_d_end=$year_edu_bg_d_end."/".$month_edu_bg_d_end;
        
         ?>
      <?php   @input_format("edu_bg_d_start",$time_edu_bg_d_start,$type);  ?>
      ~ 
      <?php   @input_format("edu_bg_d_end",$time_edu_bg_d_end,$type);  ?>
    </td>
  </tr>
  <tr> 
    <td class="title">修業國別</td>
    <td class="content"> 
      <?php    edu_nation("edu_nation",$row['edu_nation'],$type);  ?>
    </td>
  </tr>
  <tr> 
    <td class="title">修業學校</td>
    <td class="content"> 
      <?php   @input_format("edu_school",$row['edu_school'],$type);  ?>
    </td>
  </tr>
  <tr> 
    <td class="title">系所名稱</td>
    <td class="content"> 
      <?php   @input_format("dept",$row['edu_dept'],$type);  ?>
    </td>
  </tr>
  <tr> 
    <td class="title">修業別</td>
    <td class="content"> 
      <?php    edu_status("edu_status",$row['edu_status'],$type);  ?>
    </td>
  </tr>
  <tr> 
    <td class="title">教育程度</td>
    <td class="content"> 
      <?php    edu_deg("edu_deg",$row['edu_deg_cd'],$type);  ?>
    </td>
  </tr>
  <tr> 
    <td class="title">教育類別</td>
    <td class="content"> 
      <?php    edu_grp("edu_grp",$row['edu_grp_cd'],$type);  ?>
    </td>
  </tr>
 <tr> 
    <td class="title">學術專長</td>
    <td class="content"> 
    <?php    specialty($_SESSION["id"],$d_effect2,$type);  ?>
      
    </td>
  </tr>
<tr> 
    <td class="title">是否為最高學歷</td>
    <td class="content"> 
      <select name='is_edu' <?php    if ($type=="readonly"){echo "disabled";}  ?>>
        <option ></option>
        <option value="Y" <?php    if($row['is_edu']=="Y"){echo "selected";}   ?>>是</option>
        <option value="N" <?php    if($row['is_edu']=="N"){echo "selected";}   ?>>否</option>
      </select>
    </td>
  </tr>
</table>
<!-- 技工友資料若有問題,則出現維護者以便使用者聯絡 -->
<?php
if($row['dist_cd'] == "WOR"){   
	echo '<center>
			<font size=2 style="color:#0000FF">
				請注意:若您的學歷資料有問題,請洽總務處事務組-陳忠勇先生維護
			</font>
		  </center>';

    }   
?>
 </div>