<?php
header("Content-Type:text/html; charset=utf-8");
session_start();

include("inc/conn.php");
if(empty($_SESSION["id"])=="1"||$_SESSION["id"]=="")
{
	header("Location:index.php");
	exit;
}
?>
搜尋中
<?php
$staff_cd = $_GET["staff_cd"];
$sql = "SELECT h0btbasic_per.staff_cd,h0btbasic_per.c_name,is_in FROM h0btbasic_per WHERE (h0btbasic_per.staff_cd = '$staff_cd') OR (h0btbasic_per.c_name = '$staff_cd')";
$result =pg_query($sql);
if($row =pg_fetch_array($result)){
	$p='';
	if(empty($row['is_in'])||trim($row['is_in'])==""){
		$p="無照片";
	}
?>
<script>
var re;
re=/<?php echo $row['staff_cd']?>/i; 
if(window.opener.document.form1.staff_cd.value.search(re)==-1){
window.opener.document.form1.staff_cd.value = window.opener.document.form1.staff_cd.value +",'<?php echo $row['staff_cd']?>'";
window.opener.document.all["yyy"].insertAdjacentHTML("BeforeBegin","<?php echo $row['staff_cd']." ".$row['c_name']." ".$p; ?><br>");
}else{
window.opener.alert("身分證字號重複輸入!!");
}
</script>
<?php
}else {
?>
<script>
window.opener.alert("查無此人!!");
</script>
<?php
}
?>
<script>
window.close()
</script>