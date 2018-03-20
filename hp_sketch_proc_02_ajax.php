<?php
include("inc/conn.php");

$search_word=$_GET['search_string'];

$sql="SELECT * FROM h0btspecialyt_ WHERE specialty_name Like '%".$search_word."%'";
if(pg_query($sql)==false){
    echo "<option>sql error!!</option>";
}
else{
    $result=pg_query($sql);
    if(pg_num_rows($result)>0){
       while($data=pg_fetch_array($result)){
            $option_html.="<option value='".trim($data['specialty_cd'])."'>".trim($data['specialty_name'])."</option>";
       }
       echo $option_html;
     }
     else{
        echo "<option>查無關鍵字資料!</option>";
     }
}
?>