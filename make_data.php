<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
set_time_limit(0);

$zip_code = "";
$staff_cd = $_POST['staff_cd'];
// 發現staff_cd的值前後會有兩個單引號,因此要將其去除
$pat = array("''");
$rep = array("'");
$staff_cd = eregi_replace($pat[0],$rep[0],$staff_cd);

include("inc/conn.php");
if(empty($_SESSION["id"])=="1"||$_SESSION["id"]=="")
{
	header("Location:index.php");
	exit;
}
include("inc/header.php");
include('admin_.php');
$item_content ='
<div id="main_content"></div>';

$content = $slide_menu . $item_content;
echo $content;

?>
<p align="center">&nbsp;</p>
<table width="657" height="201" border="1" align="center">
  <tr> 
    <td height="60" colspan="2" align="center" bgcolor="#FFCC00"><font size="+3"><strong>IC卡資料檔製作</strong></font></td>
  </tr>
  <TR > 
    <TD height="28"><p><font color="#000066"> </font>
        <?php
$sql = "SELECT h0rtunit_.unit_cd,
               h0rtunit_.unit_name,
               h0btbasic_per.staff_cd,
               h0btbasic_per.c_name,
               h0btbasic_per.e_name,
               h0btbasic_per.resident,
               h0btbasic_per.pem_addr,
               h0btbasic_per.path,h0btbasic_per.is_in 
          FROM h0btbasic_per,h0etchange, 
               h0rtunit_  
         WHERE ( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and  
               ( h0rtunit_.unit_cd = h0etchange.unit_cd ) and 
               ( h0btbasic_per.is_current = '1' ) AND  
               ( h0etchange.is_current in ('Y','y') ) AND 
               ( h0etchange.staff_cd in (";
$sql=$sql.substr($staff_cd,1);
$sql=$sql.")) and ( h0btbasic_per.path IS NOT Null )AND 
          ( h0btbasic_per.path <> '' )
          ORDER BY h0rtunit_.unit_cd ASC ";
          
$result = pg_query($sql) or die("error");

$content="\"單位代碼\",\"單位\",\"人事代號\",\"姓名\",\"英文名\",\"居留證號\",\"電子郵件\"\n";

while($row =pg_fetch_array($result) ){
$content = $content .'"'.$row['unit_cd'].'","'.$row['unit_name'].'","'.$row['staff_cd'].'","'.$row['c_name'].'","'.$row['e_name'].'","'.$row['resident'].'","'.$row['pem_addr']."\"\n";
}

if ($handle = @opendir("photo/ic")) {
   
while (false!==($FolderOrFile = readdir($handle)))
  {
     if($FolderOrFile != "." && $FolderOrFile != "..") 
     {  
        unlink("photo/ic/$FolderOrFile"); 
     }  
  }
closedir($handle); 

}

 mkdir("photo/ic");

 if (!($fp= fopen("photo/ic/".date("ymd").".csv","w"))){
 echo "無法開啟photo/ic/".date("ymd").".csv檔案!!";
 }
fwrite($fp,mb_convert_encoding($content,"BIG5","UTF-8"));
fclose($fp);
$zip_code = @$zip_code."photo/ic/".date("ymd").".csv ";

pg_result_seek($result,0);
while ($row =pg_fetch_array($result)){
copy($row['is_in']."/".$row['path'], "photo/ic/".substr($row['path'],-14) );
$zip_code = @$zip_code."photo/ic/".substr($row['path'],-14)." ";
}

if(file_exists("photo/".date("ymd").".zip" )){
   unlink("photo/".date("ymd").".zip");
}

// 資料壓縮方法一、利用pclzip壓縮,但在27.62那台機器(php5.x)執行正常,而在26.151那台機器(php4.x)
// 執行卻有問題,圖檔無法開啟,其他類型檔案ok,造成此問題主要是因為圖檔利用fopen開啟後,filesize顯
// 示之檔案大小正常,但若透過fread讀取後,再利用strlen取得檔案大小,顯示之數值會變大,但不曉得為何
// 會形成這樣的問題??且fopen(xx,rb)也設定rb參數可以讀取binary的資料
/* 
  include_once('pclzip.lib.php');
  $archive = new PclZip("photo/".date("ymd").".zip");
  $v_list = $archive->create('photo/ic',PCLZIP_OPT_REMOVE_PATH,"photo/ic");
  
  if ($v_list == 0) {
    die("Error : ".$archive->errorInfo(true));
  }*/

// 資料壓縮方法二、利用phpzip壓縮,但在27.62那台機器(php5.x)執行正常,而在26.151那台機器(php4.x)
// 執行卻有問題,圖檔無法開啟,其他類型檔案ok-->問題同壓縮方法一
/*
  include_once('phpzip.inc.php');
  $z = new PHPZip(); 
  $filename = "photo/".date("ymd").".zip";
  $z -> Zip('photo/ic', $filename); 
  */	

// 資料壓縮方法三、利用freebsd系統內建的壓縮程式將所需檔案壓縮,但此作法可能會增加系統的漏洞,
// 再未找出解決方案前,先使用此方法因應
  $zip_code = "/usr/local/bin/zip -9 photo/".date("ymd").".zip ".$zip_code;
  @system($zip_code);
  
?>
<script>
window.open("<?php echo "photo/".date("ymd").".zip";?>","搜尋","width=260,height=150,toolbar=no,scrollbars=yes,status=yes");   
</script>
      </p>
      <p align="center">IC卡資料檔製作完成,若未自動出現下載畫面,</p>
      <p align="center">則請點選下方所列之"下載點",以供下載檔案.</p>
      <p align="center"><a href="<?php echo "photo/".date("ymd").".zip"; ?>">下載點</a></p>
</TD>
  </TR>
</table>
<p align="center">&nbsp;</p>

<?php
include("inc/footer.php");
?>