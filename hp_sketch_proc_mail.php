<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
	header("Location:index.php");
    exit();
}
include_once("inc/conn.php");

$a = check();	//讀取存在資料筆數, array
if($_POST["ajax"] == "Y" && $_POST["mail"] == "Y"){
        include_once("inc/class.phpmailer.php");
		$mail = new PHPMailer;
		$mail->IsSMTP(); 
		$mail->CharSet = 'utf-8'; //換資料庫PostgreSQL,編碼要改用utf-8
		// $mail->Encoding = 'base64';
		$mail->From = 'person@ccu.edu.tw'; //寄件者地址
		$mail->FromName ='人事系統發信程式';  //寄件者姓名
		$mail->Host ='mail144.ccu.edu.tw';
		$mail->Port = 25; 
		$mail->SMTPAuth = false;
		$mail->WordWrap = 50;
		$mail->Subject = "履歷資料請核符";  //主旨
		$mail->Body = "<p>身份證號碼 : ".$_SESSION["proc_edit_id"]."</p><p>姓名 : ".$_SESSION["proc_edit_cname"]."</p><p>以上使用者的履歷資料已完成填寫,請核符</p>";   //內文
		$mail->IsHTML(true);
		// $mail->AddAddress("hueyping@ccu.edu.tw"); //測試用
		$mail->AddAddress("person@ccu.edu.tw");//正式

		if(!$mail->Send() || $a["des"]<1 || $a["degree"]<1 ){
			$init_html.="<font color='#ff0000'>";
			// 簡要自述可以不填,所以不用判斷這個條件--1001108(hueyping)
			// if($a["des"]<1)
				// $init_html.="<br/>請確實填寫簡要自述後，重新進行送出核符<br/>";
			if($a["degree"]<1)
				$init_html.="<br/>請確認學歷資料存在大於一筆資料<br/>";
			if(!$mail->Send())
				$init_html.="<br/>信件寄出失敗，請稍候再試或聯絡系統管理員<br/></font>";
			$init_html.="</font>";
			// $init_html.=$mail->ErrorInfo."<br />";
		}else
			$init_html.="已成功發送核符要求，請返回主選單";  
 
}else{
    $init_html=<<<HTML
        <p><b><font size="4px">填寫完成通知人事室核符</font></b></p><br />
        <p>&nbsp;&nbsp;&nbsp;&nbsp;確定要通知人事室核符履歷資料嗎？</p>
        <p>
            <a id="mail_y" class="form_button" href="hp_sketch_proc_main.php">
                <span>確定</span>
            </a>
            <a class="form_button control_" href="hp_sketch_proc_main.php">
                <span>取消並返回功能表</span>
            </a>
            <br /><br /><br /><br />
        </p>
HTML;
}
if($_POST["ajax"]=="Y"){
    echo $init_html;
}
function check(){
	/*讀取履歷填寫自我簡述資料筆數*/
	$cousql="SELECT * FROM h0xt_autobiography_rec WHERE h0xt_autobiography_rec.staff_cd='".$_SESSION['proc_edit_id']."'";
	if($couresult=pg_query($cousql)){
        $countnum=pg_num_rows($couresult);  
		
	}
	/*讀取履歷填寫學歷資料筆數*/
	$stusql="SELECT * FROM h0xtedu_bg WHERE staff_cd='".$_SESSION['proc_edit_id']."'";
	$valuearray["des"]=$countnum;
	if($sturesult=pg_query($stusql)){
        $stunum=pg_num_rows($sturesult);  
		
	}
	$valuearray["degree"]=$stunum;
	return($valuearray);
}	
?>

