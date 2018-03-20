<?php
session_start();
$type="readonly";
include("inc/conn.php");

/*職員(除了人事、會計人員以外)考績紀錄存放 h0vtstaff_eva
人事、會計人員的考績紀錄存放在 h0vtstaff_eval_pa
所以需做 union
*/
$sql=  "SELECT h0vtstaff_eval.d_eval   
          FROM h0vtstaff_eval  
         WHERE h0vtstaff_eval.staff_cd = '".$_SESSION["id"]."' 
		 union
		 SELECT h0vtstaff_eval_pa.d_eval   
          FROM h0vtstaff_eval_pa  
         WHERE h0vtstaff_eval_pa.staff_cd = '".$_SESSION["id"]."' 
		 ORDER BY 1 ASC";   
$result1=pg_query($sql);
?>
<div id="maincontent">
<form id="form_style" name="date" method="POST">
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>考績資料查詢</span>
<span class="right">考核年度<select name="d_effect" onchange="document.date.submit();">
<option >請選擇</option>
<?php while ($row=pg_fetch_array($result1)){?>
<option value = <?php echo $row['d_eval'];?>  <?php if($row['d_eval']==$_POST["d_effect"]) echo "selected";?>> <?php echo $row['d_eval'];?></option>
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
<?php
   exit;
} ?>
<?php if(empty($_POST["d_effect"])||trim($_POST["d_effect"])==""||$_POST["d_effect"]=="請選擇"){ ?>
<table width="100%" >
  <tr > <td colspan="2" class="ptitle"><font color='#0000FF' size='4'>請於右上方選擇日期</font></td></tr>
  </table> 
</div>
	<?php
	exit();
}
include("inc/func.php");

/* h0vtstaff_eval :職員(除了人事、會計人員以外)考績
h0vtstaff_eval_pa:人事、會計人員的考績
做 union
*/
$sql=" SELECT h0vtstaff_eval.staff_cd, h0btbasic_per.id, h0vtstaff_eval.d_eval, h0vtstaff_eval.eval_type,h0vtstaff_eval.first_scop,  
	      h0vtstaff_eval.first_eval,h0vtstaff_eval.second_scop,h0vtstaff_eval.second_eval, 
	      h0vtstaff_eval.cd, h0vtstaff_eval.is_upgraded, h0vtstaff_eval.d_doc, h0vtstaff_eval.doc, 
 	      h0vtstaff_eval.remark  
         FROM h0vtstaff_eval,h0btbasic_per     
	WHERE ( h0vtstaff_eval.staff_cd = '".$_SESSION["id"]."' ) and  
              ( h0vtstaff_eval.staff_cd =h0btbasic_per.id) and  
 	      ( h0vtstaff_eval.d_eval = '".$_POST["d_effect"]."' )
    union
    SELECT h0vtstaff_eval_pa.staff_cd, h0btbasic_per.id, h0vtstaff_eval_pa.d_eval, h0vtstaff_eval_pa.eval_type,h0vtstaff_eval_pa.first_scop,  
	      h0vtstaff_eval_pa.first_eval,h0vtstaff_eval_pa.second_scop,h0vtstaff_eval_pa.second_eval, 
	      h0vtstaff_eval_pa.cd, h0vtstaff_eval_pa.is_upgraded, h0vtstaff_eval_pa.d_doc, h0vtstaff_eval_pa.doc, 
 	      h0vtstaff_eval_pa.remark  
         FROM h0vtstaff_eval_pa,h0btbasic_per     
	WHERE ( h0vtstaff_eval_pa.staff_cd = '".$_SESSION["id"]."' ) and  
              ( h0vtstaff_eval_pa.staff_cd =h0btbasic_per.id) and  
 	      ( h0vtstaff_eval_pa.d_eval = '".$_POST["d_effect"]."' )
		  ";     
   
if(!$result=pg_query($sql)){
echo "error!!";
echo $result;
}
$row=pg_fetch_array($result);
 ?>
<table width="100%" border="1" align="center">
  <tr align="center" class="ptitle"> 
      <td colspan="2">考績資料</td>
  </tr>
<tr> 
    <td width="33%" class="title">身分證字號</td>
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
    <td class="title">考核年度</td>
    <td class="content"> 
	<?php   @input_format("d_eval",$row['d_eval'],$type);?>
    </td>
  </tr> 
  <tr> 
    <td class="title">考核類別</td>
    <td class="content"> 
     <select name='eval_type' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="1" <?php if($row['eval_type']=="1"){echo "selected";} ?>>年考</option>
        <option value="2" <?php if($row['eval_type']=="2"){echo "selected";} ?>>另考</option>
		<option value="3" <?php if($row['eval_type']=="3"){echo "selected";} ?>>不考</option>
      </select>
    </td>
  </tr> 
  <tr> 
    <td class="title">初考分數／結果</td>
    <td class="content"> 
	 <?php @input_format("first_scop",$row['first_scop'],$type);?>
	 <?php echo "／";?>
     <select name='first_eval' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="1" <?php if($row['first_eval']=="1"){echo "selected";} ?>>甲</option>
        <option value="2" <?php if($row['first_eval']=="2"){echo "selected";} ?>>乙</option>
		<option value="3" <?php if($row['first_eval']=="3"){echo "selected";} ?>>丙</option>
		<option value="4" <?php if($row['first_eval']=="4"){echo "selected";} ?>>丁</option>
      </select>
    </td>
  </tr> 
  <tr> 
    <td class="title">複核分數／結果</td>
    <td class="content"> 
	 <?php @input_format("second_scop",$row['second_scop'],$type);?>
     <?php echo "／";?>
     <select name='second_eval' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="1" <?php if($row['second_eval']=="1"){echo "selected";} ?>>甲</option>
        <option value="2" <?php if($row['second_eval']=="2"){echo "selected";} ?>>乙</option>
		<option value="3" <?php if($row['second_eval']=="3"){echo "selected";} ?>>丙</option>
		<option value="4" <?php if($row['second_eval']=="4"){echo "selected";} ?>>丁</option>
      </select>
    </td>
  </tr> 
 
<?php
/*應使用者要求,考績核定結果不顯示
 <tr> 
    <td class="title">考績核定結果</td>
    <td class="content"> 
	 <?php eval_cd("cd",$row['cd'],$type); ?>
    </td>
  </tr>
  */
  ?>
   
  <tr> 
    <td class="title">是否晉級</td>
    <td class="content"> 
      <select name='is_upgrade' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="Y" <?php if($row['is_upgraded']=="Y"){echo "selected";} ?>>是</option>
        <option value="N" <?php if($row['is_upgraded']=="N"){echo "selected";} ?>>否</option>
      </select>
    </td>
  </tr>
    <tr> 
    <td class="title">核定日期</td>
    <td class="content"> 
	<?php  if($row['d_doc']=="") {
          @input_format("d_doc",$row['d_doc'],$type);
          }else{        
            $year_d_doc=substr($row['d_doc'],0,3);
	    $month_d_doc=substr($row['d_doc'],3,2);
            $day_d_doc=substr($row['d_doc'],5,2);
	    $date_d_doc= $year_d_doc."/".$month_d_doc."/".$day_d_doc;
	    @input_format("d_doc",$date_d_doc,$type);}?>
    </td>
  </tr> 
   <tr> 
    <td class="title">核定文號</td>
    <td class="content"> 
	 <?php @input_format("doc",$row['doc'],$type);?>
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
