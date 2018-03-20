<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
if(!isset($_SESSION["id"])){
    // echo "無效的操作，請先登入";
	header("Location:index.php");
    exit();
}
/****************每個單位的header**********************/
include('inc/header.php');
if($_SESSION["basic_dist_cd"]=="ADMIN"){
	include('admin_.php');
}
if($_SESSION["basic_dist_cd"]=="TEA"){
	include('tea_.php');
}
if($_SESSION["basic_dist_cd"]=="OFF"){
	include('off_.php');
}
if($_SESSION["basic_dist_cd"]=="UMI"){
	include('umi_.php');
}
if($_SESSION["basic_dist_cd"]=="WOR"){
	include('wor_.php');
}
$content = $slide_menu ;
echo $content;
/***************************************/
	
	
include("hp_sketch_proc_lib.php");
if(isset($_GET["pid"]) && $_SESSION["id"]=="ADMIN" && $_SESSION["basic_dist_cd"]=="ADMIN"){
    if(!preg_match("~[^0-9a-zA-Z]~",$_GET["pid"]))
        $_SESSION["proc_edit_id"]=$_GET["pid"];
}else if(!isset($_SESSION["proc_edit_id"])){
    $_SESSION["proc_edit_id"]=$_SESSION["id"];
}
$sql="SELECT c_name,dist_cd FROM h0btbasic_per WHERE staff_cd='".$_SESSION["proc_edit_id"]."'";
$result=pg_query($sql);
if($obj=pg_fetch_object($result)){
    $_SESSION["proc_edit_cname"]=$obj->c_name;
    $_SESSION["dist_cd"]=$obj->dist_cd;
}
    $proc_08=($_SESSION["dist_cd"]!="TEA")?"職員進修與訓練記錄":"教師研究與進修記錄";
    $content_html=<<<HTML
            <div id="panel">
                <div id="main_panel">
				<br /><br /><br /><br />
                    <a id="init" class="form_button func_" href="hp_sketch_proc_main.php?f=init">
                        <span>履歷資料初始作業</span>
                    </a>
                    <a id="mail" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>填寫完成通知人事室核符</span>
                    </a>
                    <br /><br /><br />
                    <hr />
                    
                   
					<a id="p_01" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>個人基本資料</span>
                    </a>
                    <a id="p_02" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>學歷資料</span>
                    </a>
                    <a id="p_03" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>家屬資料</span>
                    </a>
                    <a id="p_04" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>教師資格</span>
                    </a>
                    <a id="p_05" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>專長記錄</span>
                    </a>
					 <br /><br /><br /><br />
                    <a id="p_06" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>語言專長</span>
                    </a>
                   
                    <a id="p_07" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>考試或晉升(官等、資位)訓練/檢覆</span>
                    </a>
                    <a id='p_08' class='form_button func_' href='hp_sketch_proc_main.php'>
                        <span>{$proc_08}</span>
                    </a>
					<br /><br /><br /><br />
                    <a id="p_09" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>獎懲記錄</span>
                    </a>
                    
                    <a id="p_10" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>經歷與現職(任免、銓敘審定)</span>
                    </a>
                    
                    <a id="p_11" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>考績(成)或成績考核</span>
                    </a>
					 <a id="p_13" class="form_button func_" href="hp_sketch_proc_main.php">
                        <span>簡要自述</span>
                    </a>
                    <br /><br /><br /><br />
                </div>
                <div id="control_panel">
                    <a class="form_button control_" href="hp_sketch_proc_main.php">
                        <span>顯示功能表</span>
                    </a>
                    <br /><br /><br />
                </div>
            </div>
            <div id="content_" style="width: 100%;padding:3 3 3 3;"></div>
HTML;
//}


?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-tw.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#maincontent a:not(.control_),button").live('click',function(e){   e.preventDefault();this.blur();    });
        $("#control_panel").hide();
        $(".func_").live('click',function(){
            $("#main_panel").hide(500).next().show(500);
            var func=$(this).attr("id");
            $("#content_").html("<center><img src='image/loading.gif' title='讀取中' alt='讀取中...' /></center>").show(500);
            switch(func){
                case "init":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_init.php"});
                    $("#init_y").live('click',function(){
                        $.ajax({data:"ajax=Y&init=Y",url:"hp_sketch_proc_init.php"});
                    });
                break;
                case "mail":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_mail.php"});
                    $("#mail_y").live('click',function(){
                        $.ajax({data:"ajax=Y&mail=Y",url:"hp_sketch_proc_mail.php"});
                    });                    
                break;                
                case "p_01":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_01.php"});
                break;
                case "p_02":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_02.php"});
                break;
                case "p_03":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_03.php"});
                break;
                case "p_04":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_04.php"});
                break;
                case "p_05":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_05.php"});
                break;
                case "p_06":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_06.php"});
                break;
                case "p_07":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_07.php"});
                break;
                case "p_08":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_08.php"});
                break;
                case "p_09":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_09.php"});
                break;
                case "p_10":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_10.php"});
                break;
                case "p_11":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_11.php"});
                break;
				case "p_13":
                    $.ajax({data:"ajax=Y",url:"hp_sketch_proc_13.php"});
                break;
            }
        });
        /*$(".control_").live('click',function(){
            $(".error").remove();
            $("#content_").fadeOut(500).html("");
            $("#control_panel").hide(500).prev().show(500);
        });*/
    });
    $.ajaxSetup({           
        type:"POST",
        dataType:"html",
        timeout:300000,
        cache:false,
        success: function(data){
            $("#content_").html(data).fadeIn(1000);
        },
        error: function(xhr,aa){
            $("#content_").html("資料要求失敗("+aa+")，請聯絡系統管理員").fadeIn(1000);
        }
    });
</script>
<link rel="stylesheet" type="text/css" href="./css/dateinput.css"/>
<link rel="stylesheet" type="text/css" href="./css/hp_sketch_proc.css"/>
<link rel="stylesheet" type="text/css" href="./css/validationEngine.jquery.css"/>
<div id="maincontent">
	<div id="resume_panel" style= "">
		<div class="spacer"></div>
		<!--div class="row">
			<span class="left">履歷資料查詢</span>
			<span class="right"></span>
		</div-->
  			<span><br /><center><font size='4px'>國立中正大學個人履歷表填寫作業</font></center></span>
        <?php echo $content_html;?>
     </div>
</div>

<?php
	include('inc/footer.php');
?>