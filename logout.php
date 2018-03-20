<?php
header("Content-Type:text/html; charset=utf-8");
include_once('getssoCcuRight_config.php');
if( isset($_SESSION['verifySso']) ){//2011/10/31 sso代簽入機制修改
	ssoLogOut();   //SSO 的登出方式 
}else{
	session_start();
	session_destroy();
	header("Location:index.php");
}
?>