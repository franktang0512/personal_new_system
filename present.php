<?php
session_start();
if( !isset($_SESSION["id"]) ) {//還沒登入或已經登出的情況,返回index
	header("Location:index.php");
}
/*
 *2009/11/06
 *v1.00
 */
include("inc/conn.php");
if(empty($_SESSION["id"])=="1"||$_SESSION["id"]=="")
{
	echo "尚未登入";
    exit;
}

if(!empty($_FILES)){
	$allowed_filetypes = array('.jpg','.JPG','.jpeg','.JPEG');
	$self_picture = $_FILES["self_picture"];

	$filename = basename($self_picture['name']);
	$ext = substr($filename, strrpos($filename,'.'), strlen($filename)-1);
	list($width, $height, $type, $attr) = getimagesize($self_picture['tmp_name']);
	if(!in_array($ext,$allowed_filetypes)&&$type!=2){
		$msg="接受的檔案格式為*.jpeg, *.jpg";
	}elseif(!($width>=413&&$height>=531)){
		$msg="照片解析度至少為<b>高度531像素,寬度413像素</b>";
	}elseif(filesize($self_picture['tmp_name'])>358400){
		$msg="照片大小須小於<b>350KB</b>";
	}else{
		include("inc/func.php");
		$presentTime = new newDate();			
		$ls_datetime = $presentTime->present;
		$staff_cd=$_SESSION["id"];
		$sql ="select is_in from h0btbasic_per where h0btbasic_per.staff_cd = '".$staff_cd."'";
		$result = pg_query($sql);
		$row=pg_fetch_row($result);
		
		if(empty($row[0])||trim($row[0])==""){
			$is_in="2";
		}elseif($row[0]=="1"){
			$is_in="a";
		}elseif($row[0]=="a"){
	          $is_in="a";
		}elseif($row[0]=="2"){
	          $is_in="2";
		}
	
		
		$sql ="select unit_cd from h0etchange where h0etchange.staff_cd = '".$staff_cd."' and h0etchange.is_current in ('Y','y')";
		$result =pg_query($sql);
		$row=pg_fetch_row($result);
	    $ls_filepath = "upload/".trim($row[0]);
	    if ($ls_dir = !@opendir($is_in."/".$ls_filepath)) {
			echo "打開 $ls_filepath 失敗";
			
			if (@mkdir($is_in."/".$ls_filepath, 0700)) {
				echo "建立 $ls_filepath 成功 ";
			} else {
				echo "建立 $ls_filepath 失敗";
				echo  $is_in."/".$ls_filepath;
			}
		} else {
	      @closedir($ls_dir);//目的資料夾存在
		}		
		$ls_filename =$ls_filepath."/".$staff_cd.".jpg";
		system("rm /$is_in/$ls_filename");	//刪除該學號所擁有的照片，避免重覆

		if (@copy($self_picture['tmp_name'], $is_in."/".$ls_filename)) {
			$sql="Update h0btbasic_per set path='$ls_filename',is_in='$is_in',picture_date ='$ls_datetime' where staff_cd = '$staff_cd'";	
			$result =pg_query($sql) or die("update query fail");
			@pg_free_result($result);
			$msg="上傳成功，若下方圖片未更新請重新整理頁面";
		}else {
			$msg="上傳檔案失敗!檔案大小勿超過350KB";
		}
	}
}

$sql="select h0btbasic_per.staff_cd,h0btbasic_per.path,h0btbasic_per.is_in 
        from h0btbasic_per
      where (h0btbasic_per.staff_cd = '".$_SESSION["id"]."') ";
$result =pg_query($sql);
$fetchObj =pg_fetch_array($result);

?>


<script type="text/javascript">

function modifyAction(field) {
	if (document.form1.self_picture != null) {
		var self_pic = document.form1.self_picture.value;
	}

	 if(field.name == 'bt_upload_pic_db'){
	    if (self_pic == "") {
			alert("未選擇任何個人照片，請重新選取");
			return false;
		} else{
			if ((self_pic.lastIndexOf(".JPG") == -1) && (self_pic.lastIndexOf(".jpg") == -1) && (self_pic.lastIndexOf(".jpeg") == -1)) {
				alert("您僅可上傳jpg檔、JPG檔、jpeg檔");
				return false;
			} else{
				document.form1.action = "<?php echo $_SERVER['REQUEST_URI'];?>";
				document.form1.submit();
			}
	    }
	}
}
</script>
<style type="text\css">
body{
	background-color:#FFFFFF;

}
</style>
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>
</head>

<div id="maincontent">
 <strong><font color="#FF0000"><?php echo $msg;?></font></strong> 
  <form id="form_style" name="form1" method="post" action="" enctype="multipart/form-data">
    <div style= "width: 645; background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>照片上傳</span></div>
<div class="spacer"></div>
</div>
    <table width="645" border="1">
	
      <tr> 
        <td height="55" colspan="2"><strong><font color="#FF33FF">如上傳後未出現照片請重新整理頁面</font></strong><!--img src="image/pre.gif" width="91" height="20"--></td>
      </tr>
      <tr> 
        <td  width="420"> 
          <p><span lang="en-us"> 
            <input type="hidden" name="max_file_size" value="358400"/>
            <!-- 限制上傳大小350K bytes-->
            <input type="hidden" name="flag_upload_pic" value="0"/>
            <span lang="en-us">
            <!--<input type="file" name="self_picture" onChange="preview_self_pic(this.value)">-->
            <input type="file" name="self_picture"/>
            </span>            <br/>
            <!-- <input type="button" value="預覽照片 " name="bt_preview_self_pic" onClick="return modifyAction(this)"> -->
            <input type="button" value="上傳照片至資料庫" name="bt_upload_pic_db" onclick="return modifyAction(this)"/>
            <br/>
            <font size="2"><font color="red">照片上傳步驟:</font><br/>
            1.請先點選【瀏覽…】按鈕, 以指定個人照片<br/>
			2.接下來點選【上傳照片至資料庫】按鈕<br/>
			3.請稍後待系統出現「照片上傳成功」之訊息即可<br/>
			<br/>
            <font color="red">注意事項:</font><br/>
            1.系統僅接受<font color=red>副檔名為jpeg或jpg</font>之照片檔案<br/>
		    2.照片大小請勿超過<span class="style2">350K bytes</span><br/>
            3.照片解析度至少為<font color="red">高度531像素,寬度413像素</font><br/>
			4.照片比率約為高5與寬3.5的比率<br/>
            5.若現職資料有問題,請分別電洽:<br/>
              &nbsp;&nbsp;&nbsp;教職員--人事室&nbsp;胡秀治小姐&nbsp;(ext:18116)<br/>
              &nbsp;&nbsp;&nbsp;技工友--事務組&nbsp;劉玫麟&nbsp;(ext:13205)<br/>
			6.如照片或系統有問題, 請mail
          <a href="mailto:hicstd@ccu.edu.tw">系統管理員</a>
					</span></p>
        <td width="174"> 
          <div align="center"> 
            <?php 
        if ((empty($fetchObj['path'])) || (trim($fetchObj['path'])=="")){
			echo "<p><font color=#000099 size=4>照片尚未上傳</font></p>";
		}
		else{		 
       			echo "<img src=".$fetchObj['is_in']."/".$fetchObj['path']." width=240 height=300>";
		 }
            ?>
          </div></td>
      </tr>
    </table>
    <p align="center">&nbsp;</p>
  </form>
  

</div>
<?php
sybase_free_result ( $result);
?>