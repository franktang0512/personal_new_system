<?php

if (@sybase_pconnect("140.123.30.9:4100","ccumis","!mis!ccu")==false){
	echo "��Ʈw�s�u����!! �Ь��q�⤤�߭t�d�P���翷�Ӥp�j(����:14202)";
	exit();
}
@sybase_select_db("personneldb");

?>