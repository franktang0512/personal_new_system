<?php
session_start();
$is_seepic='N';
$date= array("year", "month", "day");
for($i=0;$i<sizeof($date);$i++)
	{
	$result3 = pg_query("Select CAST(DATE_PART('$date[$i]',NOW()) AS CHAR(10))");
	list($time) =pg_fetch_array($result3);
	pg_free_result($result3);
	$dd[$i]= $time;
}
$dd[0] = trim($dd[0]);
$dyear = strrev(substr(strrev("000".(intval($dd[0])-1911)), 0, 3));

$dd[1] = strval(intval($dd[1]));
if (strlen($dd[1]) < 2)
   $dd[1] = "0".$dd[1];
   
$dd[2] = strval(intval($dd[2]));   
if (strlen($dd[2]) < 2)
   $dd[2] = "0".$dd[2];

$ls_datetime = $dyear.$dd[1].$dd[2];

// 判斷登入之使用者是否符合可瀏覽教職員工照片檔之權限
		
$id = $_SESSION["id"];
// 首先有權限的為現任校長/代理校長
$sql_1 = "select staff_cd from h0etside_job where staff_cd = '$id' and title_cd = 'O00' and unit_cd = '0000' and d_start <= '$ls_datetime' and (d_end = '0' or d_end = '' or d_end is null or d_end >= '$ls_datetime')";
$result_1=pg_query($sql_1);
if (pg_num_rows($result_1) >= 1){
	// 現任校長/代理校長
	$is_seepic = "Y";
}
else{		

	// 接下來有權限的為現任人事室主任
	$sql_1 = "select staff_cd from h0etchange where staff_cd = '$id' and title_cd = 'O40' and unit_cd = 'S000' and d_start <= '$ls_datetime' and (d_end = '0' or d_end = '' or d_end is null or d_end >= '$ls_datetime')";
	$result_1=pg_query($sql_1);
	if (pg_num_rows($result_1) <= 0){
		// 非現任人事室主任
		$is_seepic = "N";
	}
	else{
		// 現任人事室主任
		$is_seepic = "Y";
	}	
}
?>