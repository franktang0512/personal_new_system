<html>
<head>
<title>人事系統</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
include("inc/conn.php");
include ("inc/func.php");	

if(empty($_SESSION["id"])=="1"||$_SESSION["id"]=="")
{

      header("Location:index.php");
	  exit;
}


$staff_cd=$_SESSION["id"]; 

$presentTime = new newDate();			
$ls_datetime = $presentTime->present;

//變數default 為 local 變數
//所以,先將變數從 $_POST[]取出

$e_name = $_POST["e_name"]; //英文姓名
$sex = $_POST["sex"]; //性別
$marriage_cd = $_POST["marriage_cd"];//已婚--'y' or 未婚--'n'
$phone = $_POST["phone"]; //現居住所電話
$address = $_POST["address"]; //戶籍住址
$address2 = $_POST["address2"];//現居住址
$pem_addr = $_POST["pem_addr"]; //e_mail address
$plab_room = $_POST["plab_room"];//研究室
$pweb_url = $_POST["pweb_url"];//個人網頁
$instancy_per = $_POST["instancy_per"]; //緊急聯絡人
$instancy_tel = $_POST["instancy_tel"]; //緊急聯絡電話
$phone2 = $_POST["phone2"]; //聯絡電話
$ext = $_POST["ext"]; //分機
$resident = $_POST["resident"];//統一證號

//update sql statements
$sql="update h0btbasic_per 
      set e_name='$e_name',
          sex='$sex',
          marriage_cd='$marriage_cd',
          phone='$phone',root_addr='$address',
          now_addr='$address2',
          pem_addr='$pem_addr',
          plab_room='$plab_room',
          pweb_url='$pweb_url',
          instancy_per='$instancy_per',
          instancy_tel='$instancy_tel',
          phone2='$phone2',ext='$ext',
          resident='$resident',
          last_m_staff_cd='$staff_cd',
          last_m_date ='$ls_datetime'
    where staff_cd ='".$_SESSION["id"]."'";

$result=pg_query($sql);

if($result==false){
	echo "資料修改失敗!! update語法如下:<br><br>";
	echo $sql;
	echo "<br><br><input name=\"back\" type=\"submit\" id=\"back\" value=\"回上一頁\" onClick=\"javascript:history.back()\" hidefocus=true>";
	exit;
}	

$msg="親愛的".trim($_SESSION["name"]).$_SESSION["prefix"]."!\n\n您的個人基本資料於".dataFormat($ls_datetime)."修改如下:\n\n";
$msg=$msg."　統一證號：".$resident;
// Lsg 95.09.05 中文姓名改為純顯示
//$msg=$msg."\n姓名          :".$c_name;
$msg=$msg."\n　英文姓名：".$e_name;
// Lsg 95.09.05 生日改為純顯示
//$msg=$msg."\n生日:".$byear."/".$bmonth."/".$bday;
$msg=$msg."\n　性　　別：";
if ($sex=="1"){
$msg=$msg."男";
}else{
	$msg=$msg."女";
}
$msg=$msg."\n　婚姻狀況：";
if ($marriage_cd=="y"){
$msg=$msg."已婚";
}else{
	$msg=$msg."未婚";
}
$msg=$msg."\n　電子郵件：".$pem_addr;
$msg=$msg."\n　現居所電話：".$phone;
$msg=$msg."\n　聯絡電話2：".$phone2;
$msg=$msg."\n　學校分機：".$ext;
$msg=$msg."\n　戶籍地址：".$address;
$msg=$msg."\n　現居地址：".$address2;
$msg=$msg."\n　緊急聯絡人：".$instancy_per;
$msg=$msg."\n　緊急聯絡人電話：".$instancy_tel;
$msg=$msg."\n　研究室：".$plab_room;
$msg=$msg."\n　個人網頁：".$per_url;
$msg=$msg."\n\n若您有任何問題,歡迎來函hicstd@ccu.edw.tw詢問,謝謝~";

//用PHP 內建的 mail() 寄發的mail 會出現亂碼
//將會出現亂碼的文字用以下方式處理: "=?UTF-8?B?".base64_encode(" 會出現亂碼的文字 ")."?="
//請參考 http://blog.qoding.us/2011/06/how-to-send-correct-utf8-mail-in-php --hueyping 106/04/06

$subject = "=?UTF-8?B?".base64_encode("個人基本資料修改通知")."?=";
mail($pem_addr,$subject."(".dataFormat($ls_datetime).")",$msg);
?>
<script type='text/javascript'>
   alert('資料修改成功!!');
   location.href='tea_hp020_basic.php';
</script>
</html>