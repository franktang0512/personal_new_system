<?php
include('inc/conn.php');

$sql="SELECT h0evbasic_union.staff_cd, h0evbasic_union.c_name FROM h0evbasic_union
      WHERE (h0evbasic_union.unit_cd = '".$_POST['unit_cd']."')
      AND(h0evbasic_union.dist_cd ='6' or  h0evbasic_union.dist_cd ='7' or  h0evbasic_union.dist_cd ='0'
	      or h0evbasic_union.dist_cd ='N')";
      
if(pg_query($sql)){    
 $result=pg_query($sql);
}
else{
 $staff_group.="資料庫語法失敗";
}
$staff_group=""."/"."請選擇人員"."|";
while($data=pg_fetch_array($result)){
  $staff_group.=trim($data["staff_cd"])."/".trim($data['c_name'])."|"; 
}
 echo trim($staff_group,"|");
 

?>