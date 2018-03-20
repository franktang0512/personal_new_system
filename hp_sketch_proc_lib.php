<?php

function cohs($sql,$selected="",$ifnull="",$option_value=0,$option_desc=1){  //create_option_html_sql
    $option_html="";//<option value=''>請選擇</option>
    $result=pg_query($sql);
    while($arr=pg_fetch_array($result)){
        $arr[$option_value]=trim($arr[$option_value]);
        $option_html.="<option value='".$arr[$option_value]."'";
        $option_html.=(($arr[$option_value]==$selected && $selected!="") || ($arr[$option_value]==$ifnull && empty($selected))) ? " selected='selected'>":">";
        $option_html.=$arr[$option_desc]."</option>";
    }
    return $option_html;
}
function coh($arr,$selected="",$ifnull=""){
    $option_html="";//<option value=''>請選擇</option>
    $arr=explode(",",$arr);
    for($i=0;$z=$arr[$i];$i++){
        $z=explode(":",$z);
        $z[0]=trim($z[0]);
        $option_html.="<option value='".$z[0]."'";
        $option_html.=(($z[0]==$selected && $selected!="") || ($z[0]==$ifnull && empty($selected))) ? " selected='selected'>":">";
        $option_html.=$z[1]."</option>";   
    }
    return $option_html;
}

/*過濾特殊字元函式 *可能造成中文亂碼問題*/
function bcf($strChar){ // bad_char_filter
	if(strlen($strChar) == 0 || is_null($strChar) == true)
        return "";
    $strBadChar = "',%,^,&,?,<,>,{,},;,:,=," . chr(34) . "," . chr(0) . "," . chr(32) . "\"";
    $arrBadChar = split(",",$strBadChar);
	$arrLength = count($arrBadChar);
    $tempChar = $strChar;
    for($i=0;$i<$arrLength;$i++)
        $tempChar = str_replace($arrBadChar[$i], "",$tempChar);
    return trim($tempChar);
}

function setdbbig5(){
	 $result=sybase_query("SET NAMES 'big5'");
}

?>