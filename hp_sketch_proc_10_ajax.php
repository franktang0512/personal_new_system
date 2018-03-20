<?php
include("inc/pg_conn.php");
$search_word=$_POST['search_word'];
$sql="SELECT torga_cd,torga_name FROM h0rtorga_ WHERE torga_name LIKE '%".$search_word."%'";   
if(pg_query($sql)){
   $result=pg_query($sql);
   if(pg_num_rows($result)>0){
    while($arr=pg_fetch_array($result)){
        $option_html.="<option value='".trim($arr['torga_cd'])."'>".trim($arr['torga_name'])."</option>";
    }
    echo $option_html;
   }
   else{
    echo "<option value=''>查無關鍵字資料!</option>";
   } 
}
else{
    echo "資料庫語法失敗";
}
?>