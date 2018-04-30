<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
include('inc/conn.php');
include('inc/hp_work_check_function.php');
?>
<script language="javascript" type="text/javascript">
<!--
 var xmlhttp;

   
 function createxmlhttprequest(){
    if (window.ActiveXObject){
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }   
 }
 
 function get_unit(unit_cd){
    if(unit_cd==""){
    var staff=document.getElementById("staff");
    if(staff.hasChildNodes())
        {
            while(staff.hasChildNodes()){   
             staff.removeChild(staff.firstChild);//清除之前的元素
             }
        }
    var option=document.createElement("option");
    option.setAttribute("value","");
    var text=document.createTextNode("請選擇人員");
    option.appendChild(text);
    staff.appendChild(option);
    }
    else{
      createxmlhttprequest();
      var url="hp_work_check_manager_ajax.php";
      var querystring="unit_cd="+unit_cd;
      xmlhttp.open("POST",url,true);
      xmlhttp.onreadystatechange=handleStateChange;
      xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
      xmlhttp.send(querystring);
    }
        
}
 
 function handleStateChange(){
    if(xmlhttp.readyState==4){
        if(xmlhttp.status==200){
           staff_name(); 
        }
    }
 }
 
function staff_name(){
    
    var staff=document.getElementById("staff");
    if(staff.hasChildNodes())//當有之前的元素時
        {
            while(staff.hasChildNodes()){   
             staff.removeChild(staff.firstChild);//清除之前的元素
             }
        }
    
    
    var option_array=xmlhttp.responseText.split("|");
    for(var i=0;i<option_array.length;i++){
        var options=document.createElement("option");
        var option_array2=option_array[i].split("/");
        var option_text=document.createTextNode(option_array2[1]);
        options.setAttribute("value",option_array2[0]);
        options.appendChild(option_text);
        staff.appendChild(options);
    
    }
    
    /*alert(xmlhttp.responseText);*/
}

function trim(stringToTrim)
{
 return stringToTrim.replace(/^\s+|\s+$/g,"");
}

function check_form(){
    var staff=document.getElementById("staff").value;
    var unit_cd=document.getElementById("unit_cd").value;
    var yyymm_beg=document.getElementById("yyymm_beg").value;
    var yyymm_end=document.getElementById("yyymm_end").value;
    var beg_month=yyymm_beg.substring(3,5);
    var end_month=yyymm_end.substring(3,5);
    var re=/\D/;
    if(staff==""||unit_cd==""){
        alert("請選擇單位及人員!");
        return false;
    }
    else if(yyymm_beg==""||yyymm_end==""){
        alert("請輸入年月");
        return false;
    }
    else if(re.test(yyymm_beg)||re.test(yyymm_end)){
        alert("年月輸入不正確");
        return false;
    }
    else if(yyymm_beg.length<5||yyymm_end.length<5){
        alert("年月輸入過短");
        return false;
    }
    else if((beg_month<1||beg_month>12)||(end_month<1||end_month>12)){
        alert("月份輸入錯誤");
        return false;
    }
}
 
-->
</script>
<div id="maincontent">
<div style= "background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>所屬單位考核紀錄查詢</span>
</div>
<div class="spacer"></div>
</div>
<?php
$sql="SELECT h0evside_job_parent.unit_cd,
             h0evside_job_parent.title_cd,
             h0evside_job_parent.unit_parent,
             h0evside_job_parent.staff_cd
      FROM h0evside_job_parent
      WHERE(h0evside_job_parent.staff_cd='".$_SESSION['id']."')";
      if(pg_query($sql))
	  {
	  $result=pg_query($sql);
	  }
	  else
	  {
	  echo "資料庫語法失敗";
	  }


     while($data=pg_fetch_array($result)){
     if(!($data['title_cd']=="O00"||$data['title_cd']=="O01")){
       $unit_cd=$data['unit_cd'];
       $unit_parent=$data['unit_parent'];
       } 
     }
if(empty($unit_parent))
{
    $sql="SELECT h0rtunit_.unit_cd,
                 h0rtunit_.unit_name
            FROM h0rtunit_
           WHERE unit_use='Y' ORDER BY h0rtunit_.unit_cd ASC";     
}
else
{
    $sql="SELECT h0evside_job_parent.unit_cd,
                 h0rtunit_.unit_name
            FROM h0evside_job_parent,
                 h0rtunit_
           WHERE (h0evside_job_parent.unit_cd=h0rtunit_.unit_cd) 
             AND ((h0evside_job_parent.unit_parent='".$unit_cd."')
              OR (h0evside_job_parent.unit_cd='".$unit_cd."'))";
}

            
 if(pg_query($sql))
 {
    $result=pg_query($sql);
 }
 else
 {
    echo "資料庫語法失敗";
 }
      
?>
<div align="right" style="width:100%">
<form name="search_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?op=search" onsubmit="return check_form(this);">
<table width="100%">
	<tr>
		<td>
			單位:
		</td>
		<td>
			<select id="unit_cd" name="unit_cd" onchange="get_unit(this.value)">
				<option value="">請選擇單位</option>
				<?php while($data2=pg_fetch_array($result)){
				echo "<option value='".$data2['unit_cd']."'>".$data2['unit_name']."</option>";    
				}                        
				?>
			</select>			
		</td>
	</tr>
	<tr>
		<td>
			人員:
		</td>
		<td>
			<select name="staff_cd" id="staff">
				<option value="">請選擇人員</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			考核紀錄查詢起迄年月:<br/>
			<div style="font-size:13px">(日期格式:100年1月→10001)</div>
		</td>
		<td>
			<input type="text" id="yyymm_beg" size="5" maxlength="5" name="yyymm_beg"/>~<input type="text" id="yyymm_end" size="5" maxlength="5" name="yyymm_end"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" value="確定查詢"/>
		</td>

	</tr>
</table>



</form>
</div>
<?php                     
if($_GET['op']=="search"){
    
$yyymm_beg=$_POST['yyymm_beg'];
$yyymm_end=$_POST['yyymm_end'];

$sql="SELECT h0bt_work_check_rec.staff_cd,
           h0btbasic_per.c_name,
		   h0etchange.unit_cd,
		   h0rtunit_.unit_name,
		   h0rttilte_.title_name,
		   h0bt_work_check_rec.work_yyymm,
		   h0bt_work_check_rec.seri_no,
		   h0bt_work_check_rec.work_item,
		   h0bt_work_check_rec.confirm_yn
	  FROM h0bt_work_check_rec,
          h0btbasic_per,
          h0etchange,
          h0rtdist_,
          h0rttilte_,
          h0rtunit_
      WHERE(h0bt_work_check_rec.staff_cd=h0btbasic_per.staff_cd) and
          (h0bt_work_check_rec.staff_cd=h0etchange.staff_cd) and
          (h0etchange.dist_cd=h0rtdist_.dist_cd) and
          (h0btbasic_per.dist_cd=h0rtdist_.basic_dist_cd) and
          (h0etchange.title_cd=h0rttilte_.title_cd) and
          (h0etchange.unit_cd=h0rtunit_.unit_cd) and
          ((h0etchange.unit_cd>='".$_POST['unit_cd']."') AND
          (h0etchange.unit_cd<='".$_POST['unit_cd']."') AND
          (h0bt_work_check_rec.staff_cd>='".$_POST['staff_cd']."') AND
		  (h0bt_work_check_rec.staff_cd<='".$_POST['staff_cd']."') AND
		  (h0bt_work_check_rec.work_yyymm>='".$yyymm_beg."') AND
		  (h0bt_work_check_rec.work_yyymm<='".$yyymm_end."') AND
		  (h0btbasic_per.dist_cd='OFF' OR
		  h0btbasic_per.dist_cd='UMI') AND
		  h0etchange.is_current in('Y','y') AND
		  h0btbasic_per.is_current='1')
          ORDER BY h0bt_work_check_rec.work_yyymm ASC";
		  
	   if(pg_query($sql))
	  {
	    $result=pg_query($sql);
        $info_result=pg_query($sql);
		
	  }
	   else
	  {
	    echo "資料庫語法失敗!";
	  }   
       if(pg_num_rows($result)!=0)
      {
       $staff_info=pg_fetch_array($info_result);
?>
     <div align="right">
       <p style="text-align:center;">姓名:<?php echo $staff_info['c_name'];?>&nbsp;所屬單位:<?php echo $staff_info['unit_name'];?></p>
     </div>


      <a href="hp_work_check_pdf.php?yyymm_beg=<?php echo $yyymm_beg;?>&yyymm_end=<?php echo $yyymm_end;?>&staff_cd=<?php echo $_POST['staff_cd'];?>" target="_blank">產生平時考核記錄表</a>
      <table align="left" width="100%">
	  <thead>
	  <tr>
	    <th width="15%">工作年月</th>
	    <th width="10%">序號</th>
	    <th width="50%">重要工作項目</th>
	    <th width="25%">人事單位確認</th>
	 </tr>
	</thead>
      
      
<?php
	   while($data=pg_fetch_array($result))
	  {	  
?>
	   <tr>
	      <td><div align="center"><?php echo dateFormat($data['work_yyymm']);?></div></td>
		  <td><div align="center"><?php echo $data['seri_no'];?></div></td>
		  <td><div align="left"><textarea cols="30" rows="5" readonly><?php echo trim($data['work_item']);?></textarea></div></td>
		  <td><div align="center"><?php echo $data['confirm_yn'];?></div></td>
	  </tr>
<?php
	  }
	   echo "</table>";
       }
        else
       {
        echo "<h1 style='color:red; text-align:center;'>查無資料!</h1>";
       }     
}

?>    
</div>
