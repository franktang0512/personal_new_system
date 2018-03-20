<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}

include('inc/conn.php');
include('inc/hp_work_check_function.php');

?>
<script language="JavaScript" type="text/javascript">
<!--
  
   var xmlhttp;
   var get_ym;
   
 function createxmlhttprequest(){
    if (window.ActiveXObject){
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }   
 }
 
 function count_seri_no(yyymm){
    createxmlhttprequest();
    get_yyymm(yyymm);
    var url="hp_work_check_ajax.php";
    var querystring="work_yyymm="+yyymm;
    xmlhttp.open("POST",url,true);
    xmlhttp.onreadystatechange=handleStateChange;
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
    xmlhttp.send(querystring);
 }
 
 function handleStateChange(){
    if(xmlhttp.readyState==4){
        if(xmlhttp.status==200){
           print_seri_no(); 
        }
    }
 }
 
 function get_yyymm(yyymm)
 {
    get_ym=yyymm;
 }
 
  function print_seri_no()
 {
   var td=document.getElementsByTagName("td");
   var count=0;
     for(var i=1;td[i];i+=4)
    {    
       var print_div=td[i].firstChild;
       var input_ym=td[i-1].firstChild.firstChild;
              
      if(input_ym.value==get_ym)
      {
         if(print_div.hasChildNodes())//當div有之前新增的元素，當前輸入年月值等於同列欄位年月值
        {
           print_div.removeChild(print_div.firstChild);//清除之前的元素
        }
         
         if(input_ym.value!="")//有或無其他空白欄位的情況，當前輸入年月值等於同列欄位年月值
        {
           count++;
           var result_text=(1*xmlhttp.responseText)+(1*count);
           var responseText=document.createTextNode(result_text);
           print_div.appendChild(responseText);
        }     
     }
      else if(input_ym.value!=get_ym){} 
    }
 }
  function new_row()
 {
    var tbody=document.getElementById("tbody1");
    var tr=document.createElement("tr");
    var td1=document.createElement("td");
    var td2=document.createElement("td");
    var td3=document.createElement("td");
    var td4=document.createElement("td");
    var div1=document.createElement("div");
    var div2=document.createElement("div");
    var div3=document.createElement("div");
    var div4=document.createElement("div");
    var input1=document.createElement("input");
    var input2=document.createElement("input");
    var textarea=document.createElement("textarea");
    input1.setAttribute("type","text");
    input1.setAttribute("size","5");
    input1.setAttribute("maxLength","5");
    input1.setAttribute("name","work_yyymm[]");
    input1.setAttribute("id","yyymm"+document.getElementsByTagName('tr').length);
    input1.onchange=function(){count_seri_no(this.value)};
    textarea.onkeyup=function(){alert_length()};
    textarea.onfocus=function(){check_length()};
    textarea.setAttribute("size","30");
    textarea.setAttribute("cols","30");
    textarea.setAttribute("rows","5");
    textarea.setAttribute("name","work_item[]");
    input2.setAttribute("type","text");
    input2.setAttribute("name","confirm_yn[]");
    input2.setAttribute("value","N");
    input2.setAttribute("readOnly","true");
    input2.setAttribute("size","1");
    input2.style.textAlign="center";
    div1.setAttribute("align","center");
    div2.setAttribute("align","center");
    div3.setAttribute("align","center");
    div4.setAttribute("align","center");
    div1.appendChild(input1);
    div3.appendChild(textarea);
    div4.appendChild(input2);
    td1.appendChild(div1);
    td2.appendChild(div2);
    td3.appendChild(div3);
    td4.appendChild(div4);
    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tbody.appendChild(tr); 
 }
 
  function delete_row()
 {
    var tbody=document.getElementById("tbody1");
    if(tbody.hasChildNodes()){
        if(document.getElementsByTagName("tr").length>2){
         tbody.removeChild(tbody.lastChild);     
        }
    }   
 }
 
  function delete_data(work_yyymm,seri_no,yyymm_beg,yyymm_end)
 {
  var sure=window.confirm('確定刪除此筆紀錄?');
  if(!sure)return;
  location.href="<?php echo $_SERVER['PHP_SELF'];?>?op=delete_record&work_yyymm="+work_yyymm+"&seri_no="+seri_no+"&yyymm_beg="+yyymm_beg+"&yyymm_end="+yyymm_end;
 
 }
  function update_data(work_yyymm,seri_no,yyymm_beg,yyymm_end)
 {
  location.href="<?php echo $_SERVER['PHP_SELF'];?>?op=update_record&work_yyymm="+work_yyymm+"&seri_no="+seri_no+"&yyymm_beg="+yyymm_beg+"&yyymm_end="+yyymm_end;
 }
 function check_length()
 {
    var textarea=document.getElementsByTagName("textarea");
     for(var i=0,string;string=textarea[i];i++)
    { 
      string.value=string.value.substring(0,127);      
    }        
 }
 function alert_length()
 {
    var limitlength=127;
    var nowlength=0;
    var morelength=0;
    var textarea=document.getElementsByTagName("textarea");
   
     for(var i=0,string;string=textarea[i];i++)
    { 
      nowlength=string.value.length;
      
      if(nowlength>limitlength)
     {
        morelength=nowlength-limitlength;
        alert("超過欄位限制字數"+morelength+"個字");
     } 
    }
     
 }
 function back()
 {
    var time=document.getElementById('count_time');
    var time_num=time.innerHTML-1;
    var new_time_num=document.createTextNode(time_num);
    time.replaceChild(new_time_num,time.firstChild);
    if(time_num==0){     
      window.location.href="<?php echo $_SERVER['PHP_SELF'].'?op=check';?>";
     }
     else{
        setTimeout('back()',1000);
     }
 }
 function remove_node()
 {
    var parentelement=document.getElementById('maincontent');
    var currentelement=document.getElementById('inform');
    parentelement.removeChild(currentelement);
 }
 function check_input(){
    var tbody=document.getElementById("tbody1");
    var flag;
    var re=/\D/;
    if(tbody.hasChildNodes()){
        
       for(var i=1;i<=document.getElementsByTagName("tr").length;i++){
          var work_yyymm=document.getElementById("yyymm"+i).value;
          var textarea=document.getElementsByTagName("textarea")[i-1].value;
          var work_mm=work_yyymm.substring(3,5);
         if(re.test(work_yyymm)||work_yyymm==""||work_yyymm.length<5||textarea==""){
            flag=false;
            break;
          }
          else if(work_mm<1||work_mm>12){
            flag=false;
            break;
          }
       }
        alert("工作年月欄位輸入為空或不正確");
        return flag;
    }
 }
function check_form(){
var yyymm_beg=document.getElementById('yyymm_beg').value;
var yyymm_end=document.getElementById('yyymm_end').value;
var beg_month=yyymm_beg.substring(3,5);
var end_month=yyymm_end.substring(3,5);
var re=/\D/;
   if(yyymm_beg==""||yyymm_end==""){
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
<div style= "width: 100%; background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>填寫平時考核紀錄</span>
</div>
<div class="spacer"></div>
</div>
<?php
$sql="SELECT h0btbasic_per.staff_cd,h0btbasic_per.c_name,h0etchange.unit_cd,h0rtunit_.unit_name
      FROM h0btbasic_per,h0etchange,h0rtunit_
	  WHERE( h0btbasic_per.staff_cd=h0etchange.staff_cd) and
	  ( h0etchange.unit_cd=h0rtunit_.unit_cd) and
	  ( h0btbasic_per.is_current='1')AND
	  ( h0etchange.is_current in('Y','y')) AND
	  (h0btbasic_per.dist_cd='OFF' OR h0btbasic_per.dist_cd='UMI') and
	  (h0btbasic_per.staff_cd='".$_SESSION['id']."')";
	  
	  if(pg_query($sql))
	  {
	  $result=pg_query($sql);
	  $data=pg_fetch_array($result);
	  }
	  else
	  {
	  echo "資料庫語法失敗";
	  }

?>

<div align="right">
<form name="search_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?op=search" onsubmit="return check_form();">
<table style="width:100%">
	<tr>
		<td>
			身分證號碼/統一證號:
		</td>
		<td>
			<?php echo $data['staff_cd'];?>
		</td>
	</tr>
	<tr>
		<td>
			中文姓名:
		</td>
		<td>
			<?php echo $data['c_name'];?>
		</td>
	</tr>
	<tr>
		<td>
			單位:
		</td>
		<td>
			<?php echo $data['unit_name'];?>
		</td>
	</tr>
	<tr>
		<td>
			平時考核紀錄查詢起迄年月:<br/>
			(日期格式:100年1月→10001)
		</td>
		<td>
			<input type="text" size="5" maxlength="5" id="yyymm_beg" name="yyymm_beg"/>~<input type="text" size="5" maxlength="5" id="yyymm_end" name="yyymm_end"/>&nbsp;<input type="submit" value="確定查詢"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div align="right">
				<input type="button" value="填寫平時考核紀錄" onclick="location.href='<?php echo $_SERVER['PHP_SELF'];?>?op=check'"/><br/>
			</div>			
		</td>
	</tr>
</table>
</form>
</div>

<?php
if($_GET['op']=="check")
{
$main1=<<<main1
	 <form id="work_check_form" method="post" action="{$_SERVER['PHP_SELF']}?op=save" onsubmit="return check_input();">
	 <table id="table1" align="left" width=100%>
	 <thead>
	  <tr>
	    <th width=15%>工作年月</th>
	    <th width=10%>序號</th>
	    <th width=50%>重要工作項目</th>
	    <th width=25%>人事單位確認</th>
	 </tr>
	</thead>
	 <tbody id="tbody1">
     <tr id="tr1">
      <td><div align="center"><input type="text" size=5 maxlength=5 name="work_yyymm[]" onchange="count_seri_no(this.value)" id="yyymm1"></div></td>
      <td><div align="center"></div></td>
      <td><div align="center"><textarea size=30 cols="30" rows="5" name="work_item[]" onfocus="check_length()" onKeyup="alert_length()"></textarea></div></td>
      <td><div align="center"><input type='text' name='confirm_yn[]' value='N' style='text-align:center' size=1 readonly></div></td>
    </tr>
    </tbody>
	 </table>
     <div align="center" style="clear: both;">
     <input type="button" value="新增" onclick="new_row()">
	 <input type="button" value="刪除" onclick="delete_row()">
     <input type="submit" value="儲存" id="btn_submit">
     <input id="index_number" type="hidden" value="0">
     </div>
	</form>
main1;
echo $main1;
}
else if($_GET['op']=="save")
{
    $counter=count($_POST['work_yyymm']);	 
    
    for($i=0;$i<$counter;$i++)
   {
    $sql="SELECT MAX(seri_no) FROM h0bt_work_check_rec WHERE (staff_cd='".$_SESSION['id']."') AND (work_yyymm='".trim($_POST['work_yyymm'][$i])."')";
    $result=pg_query($sql) or die("error!!");
	$data=pg_fetch_array($result);
     if(empty($data[0]))
    {
     $count_work_yyymm=0;
    }
	else
	{
	 $count_work_yyymm=$data[0];
	}
      for($j=$i;$j<$counter;$j++)
     {
        if(empty($seri_no[$j]))//最終存放的陣列要為空才可存
        {
		   if(trim($_POST['work_yyymm'][$j])==trim($_POST['work_yyymm'][$i]))//用後面的陣列比較前面的陣列是否相同
           {
		     $count_work_yyymm=$count_work_yyymm+1;
		     $seri_no[$j]=$count_work_yyymm;		   
           }
        }		  
     } 
   }
   
     for($i=0;$i<$counter;$i++)
	{
	 $_POST['staff_cd'][$i+1]=$_POST['staff_cd'][0];
     $sql="INSERT INTO h0bt_work_check_rec (staff_cd, work_yyymm, seri_no, work_item, confirm_yn)
	 VALUES('".$_SESSION['id']."', '".trim($_POST['work_yyymm'][$i])."', '".$seri_no[$i]."', '".trim($_POST['work_item'][$i])."', '".$_POST['confirm_yn'][$i]."')";
       $result=pg_query($sql) or die("error"); 
	}
       if($result)
	  {    
	     echo "<div><h1 style='color:red; text-align:center'>您已成功新增共".$counter."筆紀錄</h1>
         <h1 style='text-align:center'><span id='count_time'>3</span>秒後自動返回..</h1>
         </div>";
         echo "<script landuage='Javascript' type='text/javascript'>setTimeout('back();',1000);</script>";
		 
	  }
	   else
	  {
	    echo "<p>有部分資料新增失敗!</p>";
	  }
}  
 if($_GET['op']=="search")
{
   search_query($_REQUEST['yyymm_beg'],$_REQUEST['yyymm_end']);	  
}
 if($_GET['op']=="delete_record")
{
 $sql="DELETE FROM h0bt_work_check_rec WHERE (staff_cd='".$_SESSION['id']."') AND (work_yyymm='".$_GET['work_yyymm']."') AND (seri_no='".$_GET['seri_no']."') AND (confirm_yn='N')";
 
   if(pg_query($sql))
  {
    echo "<div id='inform'><h1 style='color:red; text-align:center'>紀錄已刪除</h1></div>";
    search_query($_REQUEST['yyymm_beg'],$_REQUEST['yyymm_end']);
    echo "<script language='Javascript' type='text/javascript'>setTimeout('remove_node();',2000);</script>"; 
  }
   else
  {
   echo "<div><h1 style='color:red; text-align:center'>刪除紀錄失敗</h1></div>";
   echo "<script language='Javascript' type='text/javascript'>setTimeout('history.back();',1000);</script>";
  }
}
 if($_GET['op']=="update_record")
{
?>

<form id="update_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?op=finish_update">
<input type='submit' value='確認修改'>
<table align="left" width=100%>
	  <thead>
	  <tr>
	    <th width=15%>工作年月</th>
	    <th width=10%>序號</th>
	    <th width=50%>重要工作項目</th>
	    <th width=25%>人事單位確認</th>		
	 </tr>
	</thead>
<?php
 $sql="SELECT*FROM h0bt_work_check_rec WHERE (staff_cd='".$_SESSION['id']."') AND (work_yyymm='".$_GET['work_yyymm']."')
	   AND (seri_no='".$_GET['seri_no']."') AND (confirm_yn='N')";
 $result=pg_query($sql);
        while($data=pg_fetch_array($result))
	  {	  
?>
	   <tr>
          <input type="hidden" name="work_yyymm" value="<?php echo $data['work_yyymm'];?>">
          <input type="hidden" name="seri_no" value="<?php echo $data['seri_no'];?>">
          <input type="hidden" name="yyymm_beg" value="<?php echo $_REQUEST['yyymm_beg'];?>">
          <input type="hidden" name="yyymm_end" value="<?php echo $_REQUEST['yyymm_end'];?>">	 		  
	      <td><div align="center"><?php echo dateFormat($data['work_yyymm']);?></div></td>
		  <td><div align="center"><?php echo $data['seri_no'];?></div></td>
		  <td><div align="center"><textarea name="work_item" cols="30" rows="5" onfocus="check_length()" onkeyup="alert_length()" <?php if($data['confirm_yn']=="Y") echo "disabled";?>><?php echo trim($data['work_item']);?></textarea></div></td>
		  <td><div align="center"><input type="text" style='text-align:center' size="1" name="confirm_yn" 
          value="<?php echo $data['confirm_yn'];?>"<?php if($data['confirm_yn']=="N"||$data['confirm_yn']=="Y") echo "readonly";?>/></div></td>
	  </tr>
<?php
	  }
	   echo "</table>";
	   echo "</form>";	   
}
 if($_GET['op']=="finish_update")
{

$sql="UPDATE h0bt_work_check_rec SET work_item='".$_POST['work_item']."' ,confirm_yn='".$_POST['confirm_yn']."'
      WHERE (seri_no='".$_POST['seri_no']."') AND (work_yyymm='".$_POST['work_yyymm']."') AND (staff_cd='".$_SESSION['id']."')";
    if(pg_query($sql))
   {
     echo "<div id='inform'><h1 style='color:red; text-align:center'>您已成功修改紀錄</h1></div>";
     search_query($_REQUEST['yyymm_beg'],$_REQUEST['yyymm_end']);
     echo "<script landuage='Javascript' type='text/javascript'>setTimeout('remove_node();',2000);</script>";  
   }
    else
   {
    echo "<div><h1 style='color:red; text-align:center'>修改紀錄失敗</h1></div>";
    echo "<script landuage='Javascript' type='text/javascript'>setTimeout('history.back();',1000);</script>";
   }
}
?>
</div>
