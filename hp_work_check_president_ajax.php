<?php
include('inc/conn.php');

$unit_cd=$_POST['unit_cd'];

$sql="SELECT h0btbasic_per.staff_cd, h0btbasic_per.c_name 
      FROM h0btbasic_per,h0evbasic_union
      WHERE(h0evbasic_union.staff_cd=h0btbasic_per.staff_cd)AND
           (h0btbasic_per.is_current='1')AND
           (h0btbasic_per.dist_cd='OFF'OR h0btbasic_per.dist_cd='UMI')AND
           (h0evbasic_union.unit_cd = '".$_POST['unit_cd']."')";
                     
$result=pg_query($sql) or die("資料庫語法失敗");

if(pg_num_rows($result)>0){   
while($data=pg_fetch_assoc($result)){
$staff_group[]=array('staff_cd' => $data['staff_cd'], 'c_name' =>trim($data['c_name']));
}

echo json_encode($staff_group);
}
else{
    echo "false";
}
?>