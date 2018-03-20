<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
include("inc/conn.php");
$mode=($_SESSION["id"]=="ADMIN" && $_SESSION["basic_dist_cd"]=="ADMIN")? 1:2;
if($mode==1){
    $sql="SELECT h0rtunit_.unit_cd, h0rtunit_.unit_name FROM h0rtunit_ WHERE h0rtunit_.unit_use='Y' ORDER BY h0rtunit_.unit_cd ASC";
    $result=pg_query($sql);
    $select_menu="<select id='unit_' name='unit_' size='1' onChange='ajax(this.value)'><option value='----' selected='selected'>點一下選擇單位</option>";
	while($gar=pg_fetch_assoc($result)){
        $select_menu.="<option value='".$gar["unit_cd"]."'>".$gar["unit_name"]."</option>";
    }
	
    $select_menu.="</select>";
    if($_GET["func"]=="proc"){

		        $printlink=<<<PL
            function printLink(value){
                var p_id=document.getElementById("p_id");
                var pdf_link=document.getElementById("pdf_link");
                if(value!='--'){
                    pdf_link.innerHTML="<center><br/><font size='4'>點選下方連結來進行對 <b>"+p_id.options[p_id.selectedIndex].text+"</b> 的履歷資料修改</font>";
                    pdf_link.innerHTML+="<br><a href='hp_sketch_proc_main.php?pid="+value+"'><font size='3'>履歷資料修改</font></a></center>";
                }else{
                    pdf_link.innerHTML="";
                }
            }
PL;
    }else{
        $printlink=<<<PL
            function printLink(value){
                var p_id=document.getElementById("p_id");
                var pdf_link=document.getElementById("pdf_link");
                if(value!='--'){
                    pdf_link.innerHTML="<center><br/><font size='4'>點選下方連結將會產生 <b>"+p_id.options[p_id.selectedIndex].text+"</b> 的履歷資料PDF檔</font>";
                    pdf_link.innerHTML+="<br><a href='hp_sketch_rtp_pdf_new.php?pid="+value+"' target='_blank'><font size='3'>產生PDF檔</font></a></center>";
                }else{
                    pdf_link.innerHTML="";
                }
            }
PL;
    }
    $html=<<<HTML
  		<tr ><td colspan="2" class="ptitle">
 			<p><br><br><center><label>{$select_menu}</label></center></p>
            <div id='per' name='per' align='center'>請於上方選單中選擇單位</div>
            <div id='pdf_link' name='pdf_link' align='center'></div>            
  		</td></tr>
        <script type='text/javascript'>
            function createXmlHttpRequest(){
                if (window.XMLHttpRequest){
                    var oHttp = new XMLHttpRequest();
                    return oHttp;
                }
                else if (window.ActiveXObject)
                {
                    var versions = 
                    [
                        "MSXML2.XmlHttp.6.0",
                        "MSXML2.XmlHttp.3.0"
                    ];
                    for (var i = 0; i < versions.length; i++)
                    {
                        try
                        {
                            var oHttp = new ActiveXObject(versions[i]);
                            return oHttp;
                        }
                        catch (error)
                        {
                          //do nothing here
                        }
                    }
                }
                return null;
            }
            function ajax(unit_cd){
                var personnel=document.getElementById("per");
                var pdf_link=document.getElementById("pdf_link");
                pdf_link.innerHTML="";
                if(unit_cd != "----"){
                    personnel.innerHTML="資料載入中, 請稍候";
                    var ajaxRequest=createXmlHttpRequest();
                    function request_readyStateChange()
                    {
                        if (ajaxRequest.readyState == 4){
                            if (ajaxRequest.status == 200){
                                personnel.innerHTML=ajaxRequest.responseText;                    
                            }else
                                personnel.innerHTML="錯誤! 狀態:" + ajaxRequest.status;
                        }
                    }
                    var param="unit_cd="+unit_cd;
                    ajaxRequest.open("POST","hp_sketch_rtp_ajax.php",true);
                    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajaxRequest.setRequestHeader("Content-length", param.length);
                    ajaxRequest.setRequestHeader("Connection", "close");
                    ajaxRequest.onreadystatechange = request_readyStateChange;
                    ajaxRequest.send(param);
                }else{
                    personnel.innerHTML="請於上方選單中選擇單位";
                    pdf_link.innerHTML="";
                }
            }
            {$printlink}
        </script>
        
HTML;
}else{
    $html=<<<HTML
      		<tr ><td colspan="2" class="ptitle">  			
			<center>
			<div id="pdfcard"><font size='4'>點選下方連結將會產生使用者個人的履歷資料PDF檔</font><br/>
			<font color='red'>注意！履歷經更改後如未完成核符動作，產生之PDF檔內資料將為更改前資料。</font>
			<!-- <br><br><a href='hp_sketch_rtp_pdf.php' target='_blank'><font size='3'>產生PDF檔</font></a></center> -->
			<!-- 104/05 履歷表修正為新的版本 -->
			<br><br><a href='hp_sketch_rtp_pdf_new.php' target='_blank'><div id="create_pdf"><font size='3'>產生PDF檔</font><div></a></div></center>			
  		</td></tr>
HTML;
}


$item_content .='
<div id="maincontent">
	<div style= "width: 100%; background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
		<div class="spacer"></div>
		<div class="row">
			<span class="left">履歷資料查詢</span>
			<span class="right"></span>
		</div>
		<div class="spacer"></div>
	</div>
     <table width="100%" >'.$html.'</table>
</div>';
echo $html;
?>
