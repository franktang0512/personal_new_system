<?php
    $item_content = <<<HTML
<div id="main_content">
<head>
<title>新增IC卡資料</title>
<script>
function add(){
	document.form1.id.value = document.form1.id.value.toUpperCase();
	window.open("search.php?staff_cd="+document.form1.id.value,"搜尋","width=260,height=150,toolbar=no,scrollbars=yes,status=yes");     
	document.form1.id.value = "";
	document.form1.id.focus();
}

function make(){
	document.form1.submit();
}
</script>
</head>
<form name="form1" method="post" action="make_data.php" style="justify-content:center;align-items:center;">
  <table width="657" height="560" border="1" align="center">
  <tr> 
    <td height="60" colspan="2" align="center" bgcolor="#FFCC00"><font size="+3"><strong>新增IC卡資料</strong></font></td>
  </tr>
  <tr> 
    <td width="657" height="31">請輸入身分證字號：<input name="id" type="text" size="12">&nbsp;&nbsp;
	<input type="button" name="Submit" value="新增" onClick = "add()" >
          <input type="hidden" name="staff_cd" >
    </td>
  </tr>
  <TR bgcolor="#00CCFF">
      <TD height="31" align="center"><strong>已選取人員清單</strong> </TD>
  </TR>
  <TR valign="top" >
      <TD height="249" align="center">&nbsp;<b id="yyy"></b> </TD>
  </TR>
  <TR >
      <TD height="31" align="center"><input type="button" name="button" value="確認送出" onClick="make()"> 
      </TD>
  </TR>
  <TR >
      <TD height="31" ><p><font color="#000066"> <font color="#990000">說明：</font></font><font color="#990000">請逐一輸入欲轉出資料之人員身分證字號，確認無誤後再按<確認送出>以產生檔案 
          </font></p>
  </TD>
  </TR>
</table>
</form>


</div>
HTML;

?>