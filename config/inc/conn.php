<?php

if (@sybase_pconnect("140.123.30.9:4100","ccumis","!mis!ccu")==false){
	echo "資料庫連線失敗!! 請洽電算中心負責同仁梁蕙萍小姐(分機:14202)";
	exit();
}
@sybase_select_db("personneldb");

?>