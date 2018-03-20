<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
if( !isset($_SESSION["id"]) ) {//還沒登入或已經登出的情況,返回index
	header("Location:index.php");
}
include("inc/conn.php");

$sql="SELECT h0btbasic_per.id,h0btbasic_per.staff_cd,
             h0btbasic_per.c_name,h0btbasic_per.e_name,
             h0btbasic_per.d_join,
             h0btbasic_per.d_birth,h0btbasic_per.sex,
             h0btbasic_per.marriage_cd,h0btbasic_per.phone,
             h0btbasic_per.phone2,
             h0btbasic_per.ext,
             h0btbasic_per.root_addr,
             h0btbasic_per.now_addr,
             h0btbasic_per.instancy_per,
             h0btbasic_per.pem_addr,
             h0btbasic_per.pweb_url,
             h0btbasic_per.plab_room,
             h0btbasic_per.path,
             unit_name,title_name,
             resident,h0btbasic_per.instancy_tel,
             is_in,
             x00tpseudo_uid_.pseudo_cd 
        FROM h0etchange,
             h0rtunit_,
             h0rttilte_,
             h0btbasic_per LEFT OUTER JOIN x00tpseudo_uid_ on(h0btbasic_per.staff_cd=x00tpseudo_uid_.staff_cd)  
       WHERE(h0btbasic_per.staff_cd=h0etchange.staff_cd) and (h0btbasic_per.staff_cd = '".$_SESSION["id"]."') and 
             (h0etchange.is_current in ('Y','y')) and (h0etchange.title_cd=h0rttilte_.title_cd) and 
             (h0etchange.unit_cd = h0rtunit_.unit_cd )";

$result =pg_query($sql);
$fetchObj =pg_fetch_array($result);

?>
<script language="JavaScript">

<!--檢核輸入格式是否正確-->
function checkAllfields() {
	var alertMesg = "";
	var tmp_c_name = document.form1.c_name.value;
	re = /^\d{3}$/;
	re1= /^\(\d{2}\)\d{7,}/;
	re3=/^[A-Z,a-z,0-9,\" \",-]{8,}$/;
	re4=/^[A-Z,a-z,0-9,\" \"]{4,}$/;
    var regUrl = /^(((ht|f){1}(tp:[/][/]){1})|((www.){1}))[-a-zA-Z0-9@:%_\+.~#?&//=]+$/;
    var regRoom=/^[0-9]{3}$/;
 
 	// Lsg 95.09.05 改為純顯示
	//if (document.form1.c_name.value == "") {
	//	alertMesg += ("\"中文姓名\"欄位未填") + "\n";
	//}
 
         if(document.form1.e_name.value == ""){
        	alertMesg += ("\"英文姓名\"欄位未填") + "\n";
        }
        else{        
        	// Lsg 96.05.31 有老師反應其中文姓名只有兩個字,因此輸入英文姓名時均會出現輸入錯誤的訊息,所以將中文字兩個字的判斷另外寫        	
        	if (tmp_c_name.length <= 2) {
       		if (!re4.test(document.form1.e_name.value)) {
				//alertMesg += "\"英文姓名\"格式錯誤" + "\n";
			}
        	}
        	else{        	
        		if (!re3.test(document.form1.e_name.value)) {
				alertMesg += "\"英文姓名\"格式錯誤" + "\n";
			}
		}
	}
    
	// Lsg 95.10.11 改為純顯示
	//if (document.form1.byear.value == "" || document.form1.bmonth.selectedIndex ==0 || document.form1.bday.selectedIndex == 0) {
	//	alertMesg += ("\"生日\"欄位未填") + "\n";
	//}else if(!re.test(document.form1.byear.value)){
	//     alertMesg += ("\"生日~年\"格式不對") + "\n";
	//}else if(js_checkdate(document.form1.byear.value+document.form1.bmonth.options[document.form1.bmonth.selectedIndex].value+document.form1.bday.options[document.form1.bday.selectedIndex].value) == false){
	//	 alertMesg += ("\"生日日期\"檢核錯誤") + "\n";
	//}
	if (document.form1.sex.value == "") {
		alertMesg += ("\"性別\"欄位未填") + "\n";
	}
	if (document.form1.address2.value == "") {
		alertMesg += ("\"現居地址\"欄位未填") + "\n";
	}
	if (document.form1.pem_addr.value == "") {
		alertMesg += ("\"電子郵件\"欄位未填") + "\n";
	}else if (document.form1.pem_addr.value.indexOf("@") == -1 || document.form1.pem_addr.value.indexOf(".") == -1) {
			alertMesg += ("\"電子郵件地址\"格式不對")+"\n";
	}
    if(!(regRoom.test(document.getElementById("lab_room").value)||document.getElementById("lab_room").value=="")){
        alertMesg+=("\"\研究室\"格式不對") + "\n";
    }
    if(!(regUrl.test(document.getElementById("per_url").value)||document.getElementById("per_url").value=="")){
        alertMesg+=("\"個人網頁\"格式不對")+"\n";
    }
	if (document.form1.ext.value == "") {
		alertMesg += ("\"學校分機\"欄位未填") + "\n";
	}
	
	
	if (document.form1.address.value == "") {
		alertMesg += ("\"戶籍地址\"欄位未填") + "\n";
	}
	
	if (document.form1.phone2.value == "") {
		alertMesg += ("\"聯絡電話\"欄位未填") + "\n";
	}
	
	if (alertMesg) {alert(alertMesg); return false;}
	return true; 
}

<!-- 檢查日期函數 -->
function js_checkdate(d_birth) {
	re4=/^[0-9]{7}$/;
	var yy = d_birth.substr(0,3) - -1911;
	var mm = d_birth.substr(3,2);
	var dd = d_birth.substr(5,2);
	
	// 先檢查日期的合理輸入範圍
	if(!re4.test(d_birth)) return false;
	if(d_birth.substr(0,3)<"001") return false;	
	if(mm<"01" || mm>"12") return false;	
	if(dd<"01" || dd>"31") return false;
	
	// 再檢查不同月份,日期值是否輸入正確	
	if(mm=="02"){
		if((yy % 4 == 0 && yy % 100 == 0 && yy % 400 == 0) || (yy % 100 != 0 && yy % 4 == 0)){
			//潤年
			if(dd>"29") return false;
		}
		else{
			//非潤年
			if(dd>"28") return false;
		}
	}
	if((mm=="04" || mm=="06" || mm=="09" || mm=="11") && (dd>"30")) return false;
	
	return true;
}

<!-- 字母轉大寫函數 -->
function upcase(){
   document.form1.resident.value=document.form1.resident.value.toUpperCase()
  
}

<!-- 開啟住址精靈視窗 -->
function nowAddr(){
  window.open("address.php","住址精靈","width=630,height=300,toolbar=no,scrollbars=yes,status=yes,resizable=yes");
}
function nowAddr2(){
window.open("adress2.php","住址精靈","width=630,height=300,toolbar=no,scrollbars=yes,status=yes,resizable=yes");
}

</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<div id="maincontent">

<form id="form_style" name="form1" method="post" action="update.php" enctype="multipart/form-data">
<div styLe= "width: 645; background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
  <div align="left"><span class="left">基本資料修改</span></div><div align="right"><span class="content"><font size=2 style="color:#FF0000">標示星號*者為必須填寫之欄位</font></span></div>
</div>
<div class="spacer"></div>
</div>
    <table width="645">
      <tr> 
        <td class="title" > 
        身分證字號 
        </td>
        <td  class="content" > 
          <?php echo $fetchObj['id'];?> </td>
      </tr>
      <tr> 
        <td class="title" > 
        虛擬使用者代碼 
        </td>
        <td  class="content" > 
          <?php echo $fetchObj['pseudo_cd'];?> </td>
      </tr>
      <tr> 
        <td  class="title" > 
          統一證號
        </td>
        <td  class="content" > 
         <input type="text" name="resident" maxlength="10"  onkeyUp="upcase();" onBlur="upcase();" value="<?php echo trim($fetchObj['resident']);?>">
          <font size=2 color="blue">(有統一證號者)</font></td>
      </tr>
      <tr> 
      <!-- Lsg 95.09.05 中文姓名很重要,因此不適合使用者自行修改,將其改為純顯示 -->
        <td  class="title" >中文姓名
 <!-- <span class="style1">*</span>中文姓名 -->
        </td>
        <td  class="content" > 
        <?php echo trim($fetchObj['c_name']);?>
        <input type=hidden name="c_name" value="<?php echo trim($fetchObj['c_name']);?>">
          <!-- <input name="c_name" type="text"  maxlength="12" value="<?php echo trim($fetchObj['c_name']);?>" size="20"> -->
        </td>
      </trtr>
      <tr> 
        <td valign="top"   class="title" ><span class="style1" >*</span>英文姓名 </td>
        <td  class="content"> 
          <input name="e_name" type="text" maxlength="30" value="<?php echo trim($fetchObj['e_name']);?>" size="20">
          <br>
          <font color="#0000FF" size="2">
          <!--例：羅仁權校長 Ren-Chyuan Luo<br>-->
          (英文字母開頭須大寫，名字在前，姓氏在後，名字之間以-分隔)</font> </td>
      </tr>
       <tr> 
        <td  class="title" > 
         到校日期
        </td>
        <td  class="content" > 
        <?php         $year_d_join = substr($fetchObj['d_join'],0,3);
		   $month_d_join = substr($fetchObj['d_join'],3,2);
		   $day_d_join = substr($fetchObj['d_join'],5,2);
		   $fetchObj['d_join']=$year_d_join."/".$month_d_join."/".$day_d_join;
           echo $fetchObj['d_join']; ?>
        </td>
      </TR>
      <tr> 
        <td  class="title" > 
         單位
        </td>
        <td  class="content" > 
          <?php echo $fetchObj['unit_name']; ?>
        </td>
      </TR>
      <tr> 
        <td  class="title" > 
          職稱
        </td>
        <td  class="content" > 
          <?php echo $fetchObj['title_name']; ?>
        </td>
      </tr>
    <tr> 
        <td  class="title" > 
         <!--<span class="style1">*</span>-->生日
        </td>
        <td  class="content" >           
          <?php
		   $syear = substr($fetchObj['d_birth'],0,3);
		   $smonth = substr($fetchObj['d_birth'],3,2);
		   $sday = substr($fetchObj['d_birth'],5,2);
		   
		   ?>
	  <!-- Lsg 95.10.11 人事室反應生日不可修改,因此將其改為純顯示 -->
	  <?php echo trim($syear);?>
          <!-- <input name="byear" type="text" size="5" maxlength="3" value=<?php echo $syear;?>> -->
          年 
          <?php echo trim($smonth);?>
          <!--
          <SELECT size=1 name=bmonth>
            
            <?php 
				for ($j=1;$j<13;$j++)
				{
				   if ($j < 10)
				   {
				       $arg = "0".number_format($j);
				   }else
				   {
				      $arg = number_format($j);
				   }
				   echo "<OPTION value=$arg  ";
				   if ($arg==$smonth){
				   echo "selected"; 
				   }
				   echo " >$arg </OPTION>";
				} 
				?>
          </SELECT>
          -->
          月 
          <?php echo trim($sday);?>
          <!--
          <SELECT size=1 name=bday onChange="ckdate('1','2','3')">
            
            <?php
				for ($j=1;$j<32;$j++)
				{
				   if ($j < 10)
				   {
				       $arg = "0".number_format($j);
				   }else
				   {
				     $arg = number_format($j);
				   }
				   echo "<OPTION value=$arg  ";
				   if ($arg==$sday){
				   echo "selected"; 
				   }
				   echo " >$arg </OPTION>";
				}
				?>
          </SELECT>
          -->
          日 <!--<font size=2 color="blue"> 年度格式範例:056 </font>--> </td>
      </tr>
      <tr> 
        <td  class="title" > 
         <span class="style1">*</span>性別
        </td>
        <td  class="content" > 
          <select name="sex">
            <option value="1" <?php if($fetchObj['sex']=="1") echo "selected";?>>男</option>
            <option value="2" <?php if($fetchObj['sex']=="2") echo "selected";?>>女</option>
          </select>
        </td>
      </tr>
      <tr> 
        <td  class="title" > 
          婚姻狀況
        </td>
        <td  class="content" > 
          <select name="marriage_cd">
            <option value="y" <?php if($fetchObj['marriage_cd']=="y") echo "selected";?>>已婚</option>
            <option value="n" <?php if($fetchObj['marriage_cd']=="n") echo "selected";?>>未婚</option>
          </select>
        </td>
      </tr>
      <tr>
      <td class="title">研究室</td>
      <td class="content">
      <input type="text" name="plab_room" size="10" id="lab_room" value="<?php echo trim($fetchObj['plab_room']);?>"/>
      </td>
      </tr>
      <tr>
      <td class="title">個人網頁</td>
      <td class="content">
      <input type="text" name="pweb_url" size="30" id="per_url" value="<?php echo trim($fetchObj['pweb_url']);?>"/>
      </td>
      </tr>
       <tr> 
        <td  class="title" > 
          <span class="style1">*</span>電子郵件
        </td>
        <td  class="content" > 
          <input name="pem_addr" type="text" size="25"  id="pem_addr"maxlength="50"value="<?php echo trim($fetchObj['pem_addr']);?>">
		  <font size=2 color="red">請務必填寫公務信箱(@ccu.edu.tw),以利教職員證製作。</font>		  
        </td>
      </tr>
      <tr> 
        <td  class="title" > 
         現居所電話
        </td>
        <td  class="content" > 
          <input type="text" name="phone" maxlength="32" value="<?php echo trim($fetchObj['phone']);?>">
          <font size=2 color="blue">範例 (04)1234567</font></td>
      </tr>
      <tr> 
        <td  class="title" ><span class="style1">*</span> 
         聯絡電話
        </td>
        <td  class="content" > 
          <input type="text" name="phone2" maxlength="16" value="<?php echo trim($fetchObj['phone2']);?>">
          <font size=2 color="blue">範例 市話: (04)1234567  手機: 0933-001122  </font>
          	
        </td>
      </tr>
       <tr> 
        <td  class="title" ><span class="style1">*</span> 
         學校分機
        </td>
        <td  class="content" > 
          <input type="text" name="ext" maxlength="5" value="<?php echo trim($fetchObj['ext']);?>">
         </td>
      </tr>
      <tr> 
        <td  class="title" ><span class="style1">*</span> 
          戶籍地址
        </td>
        <td  class="content" > 
          <input name="address" type="text" size="30"  maxlength="100" value="<?php echo trim($fetchObj['root_addr']);?>">
          <input name="b6" type="button" id="b6" value="地址精靈" onClick="nowAddr()">
        </td>
      </tr>
      <tr> 
        <td  class="title" > 
         <span class="style1">*</span>現居地址
        </td>
        <td  class="content" > 
          <input name="address2" type="text" size="30"  maxlength="100" value="<?php echo trim($fetchObj['now_addr']);?>">
          <input name="b7" type="button" id="b7" value="地址精靈" onClick="nowAddr2()">
        </td>
      </tr>
         <tr> 
        <td  class="title" > 
         緊急聯絡人
        </td>
        <td  class="content" > 
          <input name="instancy_per" type="text" size="20" maxlength="10" value="<?php echo trim($fetchObj['instancy_per']);?>">
        </td>
      </tr>
      <tr> 
        <td  class="title" > 
         緊急聯絡人電話
       </td>
        <td  class="content" > 
           <input type="text" name="instancy_tel" maxlength="16" value="<?php echo trim($fetchObj['instancy_tel']);?>">
        </td>
      </tr>
     <tr align="center" > 
        <td colspan="2"> 
            <input type="submit" name="bt_update" value="修改資料" onClick="return checkAllfields()">
        </td>
      </tr>   
    </table>
  </form>
</div>
<?php
        pg_free_result ( $result);
?>
 