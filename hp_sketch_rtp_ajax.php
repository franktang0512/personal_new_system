<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if(isset($_SESSION["id"]) && $_SESSION["id"]!="ADMIN"){
     exit();
}else{
    //include("inc/conn.php");
    include("inc/conn.php");
    $unit_cd=$_POST['unit_cd'];
    if(strlen($unit_cd)!=4){
        exit();
    }else{
        $sql = "SELECT DISTINCT h0evbasic_union.staff_cd, h0evbasic_union.c_name FROM h0evbasic_union WHERE (h0evbasic_union.unit_cd = '".$unit_cd."') ORDER BY h0evbasic_union.c_name ASC";
        $result=pg_query($sql);
        $num=0;
        $html="<select id='p_id' name='p_id' size='10' onChange='printLink(this.value)'><option value='--' selected='selected'>請選擇一名同仁</option>";
        while($gar=pg_fetch_array($result)){
            
            if(mb_detect_encoding($gar['c_name'], 'big5',true)) {  
				$c_name = mb_convert_encoding($gar['c_name'],"UTF-8",'big5');
			}
			else {
				$c_name = $gar['c_name'];
			}
            $html.="<option value='".$gar['staff_cd']."'>".$c_name."</option>";
            $num++;
        }
        
        
        $html=($num==0)? "查無資料!":$html."</select>";
        //$html=iconv("big5","UTF-8",$html);
        
        echo $html;    
    }
        
}



?>