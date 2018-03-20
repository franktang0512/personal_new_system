<?php
session_start();
$type="readonly";
include("inc/pg_conn.php");
include("inc/pg_start.php");
$sql=  "SELECT DISTINCT h0vtprof_upgrade.d_effect      
	  FROM h0vtprof_upgrade      
         WHERE h0vtprof_upgrade.staff_cd ='".$_SESSION["id"]."' ORDER BY h0vtprof_upgrade.d_effect ASC";   
$result1=pg_query($sql);
?>
<div id="maincontent">
<form id="form_style" name="date" method="POST">
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>年資加薪查詢</span>
<span class="right">學年度<select name="d_effect" onchange="document.date.submit();">
<option >請選擇</option>
<?php while($row=pg_fetch_row($result1)){
?>
<option value="<?php echo $row[0];?>"<?php if($row[0]==$_POST["d_effect"]) echo "selected";?>><?php echo $row[0];?></option>
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
include("inc/menu.php");
include("inc/end.php");
exit;
}?>

<?php
if(empty($_POST["d_effect"])||trim($_POST["d_effect"])==""||$_POST["d_effect"]=="請選擇"){?>
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
$sql=" SELECT h0vtprof_upgrade.staff_cd, 
              h0btbasic_per.id, 
              h0vtprof_upgrade.is_upgraded, 
              h0vtprof_upgrade.p_level_old,      
	          h0vtprof_upgrade.point_old, 
              h0vtprof_upgrade.point_add_old, 
              h0vtprof_upgrade.reason_cd, 
              h0vtprof_upgrade.remark, 
              h0vtprof_upgrade.d_salary_start,       
	          h0vtprof_upgrade.point_old_new, 
              h0vtprof_upgrade.d_effect, 
              h0vtprof_upgrade.doc,
              h0vtprof_upgrade.point_old+h0vtprof_upgrade.point_add_old as old_total      
	     FROM h0vtprof_upgrade,h0btbasic_per        
	    WHERE ( h0vtprof_upgrade.staff_cd='".$_SESSION["id"]."')
          and ( h0vtprof_upgrade.staff_cd=h0btbasic_per.id)
          and ( h0vtprof_upgrade.d_effect='".$_POST["d_effect"]."')";           

$result=pg_query($sql) or die("error!");
$row=pg_fetch_array($result);
?>
<table width="100%" border="1" align="center">
  <tr align="center" > 
    <td colspan="3" class="ptitle">年資加薪資料</td>
  </tr>
  
 <tr> 
    <td colspan="2" width="33%" class="title">身分證字號</td>
    <td width="67%" class="content"> 
        <?php echo $row['id']; ?>
    </td>
  </tr>  
<tr> 
    <td colspan="2" class="title">中文姓名</td>
    <td class="content"> 
      <?php echo $_SESSION["name"]; ?>
    </td>
  </tr>  
<tr> 
    <td colspan="2" class="title">是否晉級</td>
    <td class="content"> 
      <select name='is_upgrade' <?php if ($type=="readonly"){echo "disabled";}?>>
        <option ></option>
        <option value="Y" <?php if($row['is_upgraded']=="Y"){echo "selected";} ?>>是</option>
        <option value="N" <?php if($row['is_upgraded']=="N"){echo "selected";} ?>>否</option>
      </select>
    </td>
  </tr>
  <tr> 
    <td colspan="2" width="50%" class="title">起支日期</td>
    <td width="50%" class="content"> 
      <?php $year=substr($row['d_salary_start'],0,3);
       $month=substr($row['d_salary_start'],3,2);
       $day=substr($row['d_salary_start'],5,2);
       $date=$year."/".$month."/".$day;?>
      <?php echo $date;?>
    </td>
  </tr>
  <tr> 
    <td rowspan="3" class="title">原支薪額</td>
    <td class="title">本俸</td>
    <td class="content"> 
      <?php echo $row['point_old']; ?>
     </td>
  </tr>
  <tr>
    <td class="title">年功俸</td>
    <td class="content">
      <?php echo $row['point_add_old']; ?>
    </td>
  </tr>    
  <tr>
    <td class="title">合計</td>
    <td class="content">
      <?php echo $row['old_total']; ?>
    </td>
  </tr>      
  <tr> 
    <td colspan="2" class="title">擬晉支薪額</td>
    <td class="content"> 
      <?php if($row['is_upgraded']=="Y"){echo $row['point_old_new'];}else{echo "不予晉級";}?>
      </td>
  </tr>
  <tr> 
    <td colspan="2" class="title">未晉級原因</td>
    <td class="content"> 
      <?php grade_reason("reason",$row['reason_cd'],$type);?>
    </td>
  </tr>
  <tr> 
    <td colspan="2" class="title">備註</td>
    <td class="content"> 
      <?php input_format("re_mark",$row['remark'],$type);?>
    </td>
  </tr>
  <tr> 
    <td colspan="2" class="title">核定文號</td>
    <td class="content"> 
      <?php input_format("doc",$row['doc'],$type);?>
    </td>
  </tr>
</table>
</form>
</div>
<?php 
include("inc/menu.php");
include("inc/end.php");
?>
