<?php
$city=$_POST["city"];
$area=$_POST["area"];
$i =0;
include("inc/conn.php");

if ($city<>""){
$i=1;
$sql ="select towname from a11vcity_town_name where city ='$city'";
$result=pg_query($sql);
}
if($city=="嘉義市"||$city=="新竹市"){
$sql="";
$i=2;
$result2=pg_query("select zip_code from a11vcity_town_name where city ='$city' and towname = ''");
}
if(!empty($area) && $area<>""){
$sql="";
$i=2;
$result2=pg_query("select zip_code from a11vcity_town_name where city ='$city' and towname = '$area'");
}

?>
<html>

<head>
<meta http-equiv="Content-Language" content="zh-tw">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>地址精靈 0.1 版</title>
<!--請將form的action設為"", action=""-->

</head>


<script language="JavaScript">

//增加項目到addrOther
function addAddrOther(s){
  document.Address.AddrOther.value =  document.Address.AddrOther.value + s;
}


function CheckCity(){
  //document.Address.area.value=" ";
  //document.Address.city.value=123;
  //alert(ocument.Address.city.value);
  document.Address.submit();
}


function reloadSelf(){
  document.Address.submit();
  
}



//傳回選定後的住址
function returnAddr(){
  str_NoZip = document.Address.city.value + document.Address.area.value + document.Address.AddrOther.value;
  str = "("+document.Address.Zip.value +")" +document.Address.city.value + document.Address.area.value + document.Address.AddrOther.value;
	  
  window.opener.document.form1.address2.value=str;
 // window.opener.document.academicDetail.pacontadd.value = str;
 // window.opener.document.academicDetail.add_no_p.value = document.Address.Zip.value;
  close();
}

</script>
<body>


<form name = "Address" method="POST" action="adress2.php">
  <!--webbot bot="SaveResults"
  U-File="C:\myweb\templates\_private\form_results.txt" S-Format="TEXT/CSV"
  S-Label-Fields="TRUE" B-Reverse-Chronology="FALSE" S-Builtin-Fields -->
  <div align="center">
    <center>
      <table width="74%" height="195" border="1" bordercolor="#0000FF" style="border-collapse: collapse; border-width: 1">
        <tr bgcolor="#FFCC00"> 
          <td width="33%"><b><font size="2">縣市</font></b></td>
          <td width="33%"><b><font size="2">鄉市區鎮</font></b></td>
          <td width="34%"><b><font size="2">郵遞區號</font></b></td>
    </tr>
    <tr>
      <td width="33%"><select name="city" size="1" onChange="CheckCity()">
<option value=" "> 請選擇縣市</option>
<option value="台北市" <?php if ( $_POST["city"]=="台北市") echo "selected"; ?>>台北市</option>
<option value="台中市" <?php if ($i<>0 && $_POST["city"]=="台中市") echo "selected"; ?>>台中市</option>
<option value="基隆市" <?php if ($i<>0 && $_POST["city"]=="基隆市") echo "selected"; ?>>基隆市</option>
<option value="台南市" <?php if ($i<>0 && $_POST["city"]=="台南市") echo "selected"; ?>>台南市</option>
<option value="高雄市" <?php if ($i<>0 && $_POST["city"]=="高雄市") echo "selected"; ?>>高雄市</option>
<option value="台北縣" <?php if ($i<>0 && $_POST["city"]=="台北縣") echo "selected"; ?>>台北縣</option>
<option value="宜蘭縣" <?php if ($i<>0 && $_POST["city"]=="宜蘭縣") echo "selected"; ?>>宜蘭縣</option>
<option value="桃園縣" <?php if ($i<>0 && $_POST["city"]=="桃園縣") echo "selected"; ?>>桃園縣</option>
<option value="嘉義市" <?php if ($i<>0 && $_POST["city"]=="嘉義市") echo "selected"; ?>>嘉義市</option>
<option value="新竹縣" <?php if ($i<>0 && $_POST["city"]=="新竹縣") echo "selected"; ?>>新竹縣</option>
<option value="苗栗縣" <?php if ($i<>0 && $_POST["city"]=="苗栗縣") echo "selected"; ?>>苗栗縣</option>
<option value="台中縣" <?php if ($i<>0 && $_POST["city"]=="台中縣") echo "selected"; ?>>台中縣</option>
<option value="南投縣" <?php if ($i<>0 && $_POST["city"]=="南投縣") echo "selected"; ?>>南投縣</option>
<option value="彰化縣" <?php if ($i<>0 && $_POST["city"]=="彰化縣") echo "selected"; ?>>彰化縣</option>
<option value="新竹市" <?php if ($i<>0 && $_POST["city"]=="新竹市") echo "selected"; ?>>新竹市</option>
<option value="雲林縣" <?php if ($i<>0 && $_POST["city"]=="雲林縣") echo "selected"; ?>>雲林縣</option>
<option value="嘉義縣" <?php if ($i<>0 && $_POST["city"]=="嘉義縣") echo "selected"; ?>>嘉義縣</option>
<option value="台南縣" <?php if ($i<>0 && $_POST["city"]=="台南縣") echo "selected"; ?>>台南縣</option>
<option value="高雄縣" <?php if ($i<>0 && $_POST["city"]=="高雄縣") echo "selected"; ?>>高雄縣</option>
<option value="屏東縣" <?php if ($i<>0 && $_POST["city"]=="屏東縣") echo "selected"; ?>>屏東縣</option>
<option value="花蓮縣" <?php if ($i<>0 && $_POST["city"]=="花蓮縣") echo "selected"; ?>>花蓮縣</option>
<option value="台東縣" <?php if ($i<>0 && $_POST["city"]=="台東縣") echo "selected"; ?>>台東縣</option>
<option value="金門縣" <?php if ($i<>0 && $_POST["city"]=="金門縣") echo "selected"; ?>>金門縣</option>
<option value="澎湖縣" <?php if ($i<>0 && $_POST["city"]=="澎湖縣") echo "selected"; ?>>澎湖縣</option>
<option value="連江縣" <?php if ($i<>0 && $_POST["city"]=="連江縣") echo "selected"; ?>>連江縣</option>
<option value="釣魚台" <?php if ($i<>0 && $_POST["city"]=="釣魚台") echo "selected"; ?>>釣魚台</option>
<option value="南海島" <?php if ($i<>0 && $_POST["city"]=="南海島") echo "selected"; ?>>南海島</option>
<option value="其他">其他</option>
</select></td>
      <td width="33%"><select name="area" size="1" onChange="reloadSelf()">
<option value="" selected> 請選擇鄉鎮區</option>
<?php 
if ($i>0){
$num =pg_num_rows($result);
for($j=0;$j<$num;$j++){
$row=pg_fetch_row($result);
echo "<option value='".$row[0]."'";
if($row[0]==$area){
echo "selected";
}
echo ">".$row[0]." </option>";
}
}
pg_free_result($result);
?></select>

</td>
      <td width="34%"><input type="text" name="Zip" size="20" value=<?php if (!empty($result2)){$row=pg_fetch_row($result2); echo $row[0];} ?>></td>
    </tr>
    <tr>
      <td width="100%" colspan="3"><input type="text" name="AddrOther" size="64"></td>
    </tr>
    <tr>
      <td width="100%" colspan="3">
            <div align="center">
              <input type="button" value="１" name="B3"  onClick="addAddrOther(1)"> 
              <input type="button" value="２" name="B4"  onClick="addAddrOther(2)">     
              <input type="button" value="３" name="B5"  onClick="addAddrOther(3)"> 
              <input type="button" value="４" name="B6"  onClick="addAddrOther(4)">     
              <input type="button" value="５" name="B7"  onClick="addAddrOther(5)"> 
              <input type="button" value="６" name="B8"  onClick="addAddrOther(6)">     
              <input type="button" value="７" name="B9"  onClick="addAddrOther(7)"> 
              <input type="button" value="８" name="B10" onClick="addAddrOther(8)">     
              <input type="button" value="９" name="B11" onClick="addAddrOther(9)"> 
              <input type="button" value="０" name="B12" onClick="addAddrOther(0)">  
              <input type="button" value="－" name="B34" onClick="addAddrOther('－')">
            </div></td>   
    </tr>
    <tr>
      <td width="100%" colspan="3">
            <div align="center">
              <input type="button" value="一" name="B13" onClick="addAddrOther('一')"> 
              <input type="button" value="二" name="B14" onClick="addAddrOther('二')">     
              <input type="button" value="三" name="B15" onClick="addAddrOther('三')"> 
              <input type="button" value="四" name="B16" onClick="addAddrOther('四')">    
              <input type="button" value="五" name="B17" onClick="addAddrOther('五')"> 
              <input type="button" value="六" name="B18" onClick="addAddrOther('六')">    
              <input type="button" value="七" name="B19" onClick="addAddrOther('七')"> 
              <input type="button" value="八" name="B20" onClick="addAddrOther('八')">    
              <input type="button" value="九" name="B21" onClick="addAddrOther('九')"> 
              <input type="button" value="十" name="B22" onClick="addAddrOther('十')">  
              <input type="button" value="零" name="B33" onClick="addAddrOther('零')">
            </div></td> 
    </tr>
    <tr>
      <td width="100%" colspan="3">
            <div align="center">
              <input type="button" value="路" name="B23" onClick="addAddrOther('路')"> 
              <input type="button" value="街" name="B24" onClick="addAddrOther('街')">   
              <input type="button" value="段" name="B25" onClick="addAddrOther('段')"> 
              <input type="button" value="村" name="B26" onClick="addAddrOther('村')">   
              <input type="button" value="里" name="B27" onClick="addAddrOther('里')"> 
              <input type="button" value="鄰" name="B28" onClick="addAddrOther('鄰')">   
              <input type="button" value="巷" name="B29" onClick="addAddrOther('巷')"> 
              <input type="button" value="弄" name="B30" onClick="addAddrOther('弄')">   
              <input type="button" value="號" name="B31" onClick="addAddrOther('號')"> 
              <input type="button" value="樓" name="B35" onClick="addAddrOther('樓')">  
              <input type="button" value="之" name="B32" onClick="addAddrOther('之')"> 
            </div></td>
    </tr>
  </table>
    </center>
  </div>
  <p align="center"><input type="button" value="取回" name="submit0" onClick="returnAddr();">
     <input type="button" value="關閉" name="submit1" onClick="window.close();"></p>
</form>
</body>

</html>
