<?php
session_start();

if($_SESSION["id"]!="ADMIN" && !preg_match("/[^0-9A-Z]/",$_SESSION["id"]) && !isset($_GET["pid"])){
    $staff_cd=$_SESSION["id"];
}else if($_SESSION["id"]=="ADMIN" && strlen($_GET["pid"])==10 && !preg_match("/[^0-9A-Z]/",$_GET["pid"])){
    $staff_cd=$_GET["pid"];
}else{
    echo "無效的操作, 請先登入";
    exit();
}
//include("inc/conn.php");
include("inc/conn.php");
//這行是做甚麼的?
define('FPDF_FONTPATH','fpdf/font/');
require_once ('fpdf/fpdf.php');
require_once ('fpdf/fpdf_tpl.php');
require_once ('fpdf/chinese-unicode.php');
require_once ('fpdf/fpdi.php');


$pdf = new FPDI();

// 載入現在 PDF 檔案
//$page_count = $pdf->setSourceFile("./fpdf/blank.pdf");
//$pdf->setSourceFile("fpdf/blank.pdf");
$pdf->setSourceFile("fpdf/blank_new.pdf"); //104/05換新版本(hueyping-1040505)
// 匯入現在 PDF 檔案的第一頁
$tpl = $pdf->importPage(1);

// 在新的 PDF 上新增一頁
$pdf->addPage();

// 在新增的頁面上使用匯入的第一頁
$pdf->useTemplate($tpl);

$pdf->AddUniCNShwFont('uni');

function utf8_str_split($str, $split_len = 1)
{
    if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
        return FALSE;
 
    $len = mb_strlen($str, 'UTF-8');
    if ($len <= $split_len)
        return array($str);
 
    preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
 
    return $ar[0];
}

function wr($content, $x, $y, $fs=12, $len=0, $ff=0){
	global $pdf;
    if($ff==1)
        $pdf->SetFont('arial','',$fs);
    else
        $pdf->SetFont('uni','',$fs);
    if($len!=0 && strlen($content)>$len){
	   $temp=utf8_str_split($content,$len);
       for($i=0;$con=$temp[$i];$i++){
	       $pdf->SetXY($x,$y);
           $pdf->Write(0,$con);
           $y+=5;    
	   }       
    }else{
        $pdf->SetXY($x,$y);
        $pdf->Write(0,$content);
    }
}


$sql = "SELECT h0btbasic_per.c_name, h0btbasic_per.e_name, h0btbasic_per.sex, h0btbasic_per.staff_cd, h0btbasic_per.d_birth, h0btbasic_per.passport, h0btbasic_per.root_addr, h0btbasic_per.now_addr, h0btbasic_per.phone, h0btbasic_per.phone2, h0btbasic_per.pem_addr, h0btbasic_per.instancy_per, h0btbasic_per.relationship, h0btbasic_per.instancy_tel, h0btbasic_per.instancy_tel_2, ";
$sql.=" h0rtnation_.n_name,";
$sql.=" h0btbasic_per.is_in,"; //抓取照片上傳階段
$sql.=" h0btbasic_per.path";	//抓取相片路徑
$sql.=" FROM h0btbasic_per, h0rtnation_ WHERE h0btbasic_per.staff_cd ='".$staff_cd."' AND h0btbasic_per.n_cd = h0rtnation_.n_cd";

$result1=pg_query($sql);
$gar = pg_fetch_assoc($result1);
foreach($gar as $key=>$value){
	$value=trim($value);
    $gar[$key]=$value;
}

$picpath = "./$gar[is_in]/$gar[path]"; //照片路徑 包涵上傳階段與檔名 added 100.04.14 andy
$pdf->Image($picpath, 152, 38,41,64);	//pdf載入圖片函式 added 100.04.14 andy

wr($gar['c_name'],35,43); //中文姓名
wr($gar['e_name'],104,43,7,0,1); //英文姓名
wr($gar['staff_cd'],35,54,10,0,1); //身份證號碼
wr($gar['passport'],104,54); //護照號碼

//出生年、月、日
$temp=str_split($gar['d_birth']);
$temp[0]=($temp[0]=='0')? " ":$temp[0];
$bir_y=$temp[0].$temp[1].$temp[2];
$bir_m=$temp[3].$temp[4];
$bir_d=$temp[5].$temp[6];
wr($bir_y,42,64);
wr($bir_m,56,64);
wr($bir_d,66,64);

//性別(改用勾選)
if ($gar['sex']=="1"){
   wr('v',38,74);
}else{
   wr('v',38,78);
}

/*
$gar['sex']=($gar['sex']=="1") ? "男":"女";
wr($gar['sex'],139,43);
*/
if (trim($gar['n_name'])=='中華民國') {
   wr('v',105,67); //無外國國籍
}else{ 
   wr('v',105,71);  //有外國國籍
   wr($gar['n_name'],126,71,10);
}
//wr($gar['n_name'],100,68); //國籍

wr($gar['root_addr'],51,87,12,24); //通訊處-戶籍地
wr($gar['now_addr'],51,112,12,24); //通訊處-現居住所
wr($gar['phone'],166,116,9,12); //通訊處-電話(住宅)
wr($gar['phone2'],166,126,9,12);//通訊處-電話(手機)
wr($gar['pem_addr'],51,135,10,0,1);//通訊處-電子郵件信箱
wr($gar['instancy_per'],51,150); //緊急通知人-姓名
wr($gar['relationship'],120,150); //緊急通知人-關係
wr($gar['instancy_tel'],166,146,10,11); //緊急通知人-電話(住宅)
wr($gar['instancy_tel_2'],166,152,10,11);//緊急通知人-電話(手機)


//學歷

$sql = "SELECT h0btedu_bg.edu_school, h0btedu_bg.edu_dept, h0btedu_bg.edu_bg_d_start, h0btedu_bg.edu_bg_d_end, h0btedu_status_.edu_status_name, h0btedu_deg_.edu_deg_name, h0btedu_bg.edu_doc ";
//$sql = "SELECT h0btedu_bg.edu_school, h0btedu_bg.edu_dept, h0btedu_bg.edu_bg_d_start, h0btedu_bg.edu_bg_d_end, h0btedu_status_.edu_status_name, h0btedu_deg_.edu_deg_name ";
$sql.=" FROM h0btedu_bg, h0btedu_status_, h0btedu_deg_ WHERE h0btedu_bg.staff_cd ='".$staff_cd."' AND h0btedu_bg.edu_status = h0btedu_status_.edu_status AND h0btedu_bg.edu_deg_cd = h0btedu_deg_.edu_deg_cd ORDER BY h0btedu_bg.edu_bg_d_end ASC";

$result1=pg_query($sql);
$y=201;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
    	$value=trim($value);
        $gar[$key]=$value;
    }
    
    wr($gar['edu_school'],18,$y,10,7); //學校名稱
    wr($gar['edu_dept'],50,$y,10); //系所名稱
    $temp=str_split($gar['edu_bg_d_start']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $temp=str_split($gar['edu_bg_d_end']);
    $end_y=$temp[0].$temp[1].$temp[2];
    $end_m=$temp[3].$temp[4];
    wr($start_y,84,$y,10);
    wr($start_m,95,$y,10);
    wr($end_y,104,$y,10);
    wr($end_m,114,$y,10);
    switch($gar['edu_status_name']){
        case "畢業": wr("V",121,$y,12);
            break;
        case "結業": wr("V",128,$y,12);
            break;
        default:
            wr("V",134,$y,12);
    }
    wr($gar['edu_deg_name'],141,$y,10);
    wr($gar['edu_doc'],152,$y,7,12);
		$y+=20;
		
    if(++$num == 4)
        break;

}

//第二頁
$tpl = $pdf->importPage(2);
$pdf->addPage();
$pdf->useTemplate($tpl);


//考試或晉升訓練
$sql ="  SELECT h0btexam.t_year,   
         h0btexam_kind_.kind_name,   
         h0btexam_group_.group_name,   
         h0btexam.doc  
    FROM h0btexam,   
         h0btexam_group_,   
         h0btexam_kind_  
   WHERE ( h0btexam_group_.group_cd = h0btexam.group_cd ) and  
         ( h0btexam_kind_.kind_cd = h0btexam.kind_cd ) and  
         ( ( h0btexam.staff_cd = '".$staff_cd."' ) AND  
         ( h0btexam.exam_dist = '1' ) AND  
         ( h0btexam.kind_cd <> 'A002' ) AND  
         ( h0btexam.kind_cd <> 'B002' ) AND  
         ( h0btexam.kind_cd = h0btexam_kind_.kind_cd ) AND  
         ( h0btexam.group_cd = h0btexam_group_.group_cd ) ) ORDER BY h0btexam.t_year ASC  ";
$result1=pg_query($sql);
$y=49;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
    	$value=trim($value);
        $gar[$key]=$value;
    }
    
    wr($gar['t_year'],19,$y);
    wr($gar['kind_name'],31,$y,10,15);
    wr($gar['group_name'],106,$y,10,10);
    wr($gar['doc'],158,$y,10,10);
    if(++$num == 7)
        break;
    $y+=13;
}


//專門職業及技術人員考試
$sql ="SELECT h0btexam.staff_cd,   
         h0btexam.t_year,   
         h0btexam_group_.group_name,   
         h0btexam.effect_date,   
         h0btexam.orga,   
         h0btexam.doc  
    FROM h0btexam,   
         h0btexam_group_  
   WHERE (h0btexam.staff_cd = '".$staff_cd."') and
         ( h0btexam_group_.group_cd = h0btexam.group_cd ) and  
         ( h0btexam.exam_dist = '1' ) AND  
         ( h0btexam.kind_cd = 'A002' OR  
           h0btexam.kind_cd = 'B002') ORDER BY h0btexam.t_year ASC ";

$result1=pg_query($sql);
$y=172;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
    	$value=trim($value);
        $gar[$key]=$value;
    }
    
    wr($gar['t_year'],18,$y);
    wr($gar['group_name'],35,$y,10,10);
    $temp=str_split($gar['effect_date']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,61,$y);
    wr($start_m,71,$y);
    wr($start_d,80,$y);
    wr($gar['doc'],90,$y,10,10);	
    wr($gar['orga'],126,$y,10,10);
    wr($gar['doc'],162,$y,10,10);
    if(++$num == 6)
        break;
    $y+=17;
}

//第三頁
$tpl = $pdf->importPage(3);
$pdf->addPage();
$pdf->useTemplate($tpl);

//經歷及現職(任免及銓敘審定) 
//將經歷及現職(h0evchange_history)與銓敘審定(h0evchange_qual)做left outer join
$sql="SELECT h0evchange_history.torga_name,   
         h0evchange_history.title_name,   
         h0evchange_history.pub_name,   
         h0evchange_history.duty_name,   
         h0evchange_history.task_cd,   
         h0evchange_history.boss_level,   
         h0evchange_history.d_start,   
         h0evchange_history.doc as start_doc,   
         h0evchange_history.end_doc,   
         h0evchange_history.d_end,   
         h0evchange_history.out_reason_name,   
         h0evchange_history.no_qual,   
         h0evchange_history.per_dist,
         h0evchange_qual.doc as qual_doc,   
         h0evchange_qual.qual_result,   
         h0evchange_qual.pub_name_qual,   
         h0evchange_qual.lev,   
         h0evchange_qual.point,   
         h0evchange_qual.temp_point,   
         h0evchange_qual.d_effect,   
         h0evchange_qual.doc_1
   FROM h0evchange_history LEFT OUTER JOIN h0evchange_qual 
        on((h0evchange_history.staff_cd = h0evchange_qual.staff_cd) 
		    and(h0evchange_history.torga_name = h0evchange_qual.torga_name)
			and(h0evchange_history.title_name = h0evchange_qual.title_name)
            and(h0evchange_history.pub_name = h0evchange_qual.pub_name_change)
            and(h0evchange_history.task_cd = h0evchange_qual.task_cd )	
            and(h0evchange_history.duty_name = h0evchange_qual.duty_name)			
		)
   WHERE h0evchange_history.staff_cd = '".$staff_cd."' ORDER BY h0evchange_history.d_start DESC ";

$result1=pg_query($sql);
$num=0;
$y=74;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['torga_name'],13,$y,9,5); //服務機關
    wr($gar['title_name'],31,$y,9,5); //職稱
    wr($gar['task_cd'],31,$y+14,9,7);//職務編號	
    wr($gar['pub_name'],48,$y,9,5); //職務列等
    wr($gar['duty_name'],48,$y+14,9,5); //職系
    wr($gar['boss_level'],65,$y,9,3); //主管級別
    wr($gar['per_dist'],65,$y+14,9,3); //人員區分	
    wr($gar['start_doc'],74,$y,5,6); //任職_日期文號
    $temp=str_split($gar['d_start']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,76,$y+14,9); //任職_實際到職日_年
    wr($start_m,77,$y+18,9); //任職_實際到職日_月
    wr($start_d,77,$y+22,9); //任職_實際到職日_日
    wr($gar['end_doc'],84,$y,5,6); //免職_日期文號
    $temp=str_split($gar['d_end']);
    $end_y=$temp[0].$temp[1].$temp[2];
    $end_m=$temp[3].$temp[4];
    $end_d=$temp[5].$temp[6];
    wr($end_y,87,$y+14,9);//免職_實際離職日_年
    wr($end_m,88,$y+18,9);//免職_實際離職日_月
    wr($end_d,88,$y+22,9);//免職_實際離職日_日
	wr($gar['qual_doc'],98,$y,7,4);//銓敘審定_核定日期文號
	wr($gar['qual_result'],110,$y,9,4);//銓敘審定_審查結果
    wr($gar['pub_name_qual'],110,$y+14,9,4);//銓敘審定_官等職等
    wr($gar['lev'],130,$y,9,3);//銓敘審定_俸級
    wr($gar['point'],130,$y+14,9,3);//銓敘審定_俸點
    wr($gar['temp_point'],145,$y,9,3);//銓敘審定_暫支俸點	
    $temp=str_split($gar['d_effect']);//銓敘審定_生效日期
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,145,$y+14,9); //銓敘審定_生效日期_年
    wr($start_m,145,$y+18,9);//銓敘審定_生效日期_月
    wr($start_d,145,$y+22,9);//銓敘審定_生效日期_日

    wr($gar['out_reason_name'],158,$y,9,4);//異動(卸職)原因
    wr($gar['doc_1'],175,$y,9,5);//請任(免)核發日期_文號	
    wr($gar['no_qual'],192,$y,9,2); //不必詮審註記
    if(++$num == 7) //第三頁有7列
	  break;
	 $y+=26.4; 
    //$y=($num==5)? $y+25 : $y+29.6;
} 


//第四頁 --接續第3頁繼續讀以下的紀錄
$tpl = $pdf->importPage(4);
$pdf->addPage();
$pdf->useTemplate($tpl);
$num=0;
$y=74;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['torga_name'],13,$y,9,5); //服務機關
    wr($gar['title_name'],31,$y,9,5); //職稱
    wr($gar['task_cd'],31,$y+14,9,7);//職務編號	
    wr($gar['pub_name'],48,$y,9,5); //職務列等
    wr($gar['duty_name'],48,$y+14,9,5); //職系
    wr($gar['boss_level'],65,$y,9,3); //主管級別
    wr($gar['per_dist'],65,$y+14,9,3); //人員區分	
    wr($gar['start_doc'],74,$y,5,6); //任職_日期文號
    $temp=str_split($gar['d_start']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,76,$y+14,9); //任職_實際到職日_年
    wr($start_m,77,$y+18,9); //任職_實際到職日_月
    wr($start_d,77,$y+22,9); //任職_實際到職日_日
    wr($gar['end_doc'],84,$y,5,6); //免職_日期文號
    $temp=str_split($gar['d_end']);
    $end_y=$temp[0].$temp[1].$temp[2];
    $end_m=$temp[3].$temp[4];
    $end_d=$temp[5].$temp[6];
    wr($end_y,87,$y+14,9);//免職_實際離職日_年
    wr($end_m,88,$y+18,9);//免職_實際離職日_月
    wr($end_d,88,$y+22,9);//免職_實際離職日_日
	wr($gar['qual_doc'],98,$y,7,4);//銓敘審定_核定日期文號
	wr($gar['qual_result'],110,$y,9,4);//銓敘審定_審查結果
    wr($gar['pub_name_qual'],110,$y+14,9,4);//銓敘審定_官等職等
    wr($gar['lev'],130,$y,9,3);//銓敘審定_俸級
    wr($gar['point'],130,$y+14,9,3);//銓敘審定_俸點
    wr($gar['temp_point'],145,$y,9,3);//銓敘審定_暫支俸點	
    $temp=str_split($gar['d_effect']);//銓敘審定_生效日期
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,145,$y+14,9); //銓敘審定_生效日期_年
    wr($start_m,145,$y+18,9);//銓敘審定_生效日期_月
    wr($start_d,145,$y+22,9);//銓敘審定_生效日期_日

    wr($gar['out_reason_name'],158,$y,9,4);//異動(卸職)原因
    wr($gar['doc_1'],175,$y,9,5);//請任(免)核發日期_文號	
    wr($gar['no_qual'],192,$y,9,2); //不必詮審註記
    if(++$num == 7)
	  break;
	 $y+=26.4; 
    //$y=($num==5)? $y+25 : $y+29.6;
} 

//第五頁--接續第4頁繼續讀以下的紀錄
$tpl = $pdf->importPage(5);
$pdf->addPage();
$pdf->useTemplate($tpl);
$num=0;
$y=74;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['torga_name'],13,$y,9,5); //服務機關
    wr($gar['title_name'],31,$y,9,5); //職稱
    wr($gar['task_cd'],31,$y+14,9,7);//職務編號	
    wr($gar['pub_name'],48,$y,9,5); //職務列等
    wr($gar['duty_name'],48,$y+14,9,5); //職系
    wr($gar['boss_level'],65,$y,9,3); //主管級別
    wr($gar['per_dist'],65,$y+14,9,3); //人員區分	
    wr($gar['start_doc'],74,$y,5,6); //任職_日期文號
    $temp=str_split($gar['d_start']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,76,$y+14,9); //任職_實際到職日_年
    wr($start_m,77,$y+18,9); //任職_實際到職日_月
    wr($start_d,77,$y+22,9); //任職_實際到職日_日
    wr($gar['end_doc'],84,$y,5,6); //免職_日期文號
    $temp=str_split($gar['d_end']);
    $end_y=$temp[0].$temp[1].$temp[2];
    $end_m=$temp[3].$temp[4];
    $end_d=$temp[5].$temp[6];
    wr($end_y,87,$y+14,9);//免職_實際離職日_年
    wr($end_m,88,$y+18,9);//免職_實際離職日_月
    wr($end_d,88,$y+22,9);//免職_實際離職日_日
	wr($gar['qual_doc'],98,$y,7,4);//銓敘審定_核定日期文號
	wr($gar['qual_result'],110,$y,9,4);//銓敘審定_審查結果
    wr($gar['pub_name_qual'],110,$y+14,9,4);//銓敘審定_官等職等
    wr($gar['lev'],130,$y,9,3);//銓敘審定_俸級
    wr($gar['point'],130,$y+14,9,3);//銓敘審定_俸點
    wr($gar['temp_point'],145,$y,9,3);//銓敘審定_暫支俸點	
    $temp=str_split($gar['d_effect']);//銓敘審定_生效日期
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,145,$y+14,9); //銓敘審定_生效日期_年
    wr($start_m,145,$y+18,9);//銓敘審定_生效日期_月
    wr($start_d,145,$y+22,9);//銓敘審定_生效日期_日

    wr($gar['out_reason_name'],158,$y,9,4);//異動(卸職)原因
    wr($gar['doc_1'],175,$y,9,5);//請任(免)核發日期_文號	
    wr($gar['no_qual'],192,$y,9,2); //不必詮審註記
    if(++$num == 6) //第5頁有六列
	  break;
	 $y+=26.4; 
    //$y=($num==5)? $y+25 : $y+29.6;
} 

/*原來的第5頁
//專長
$sql="SELECT h0btskill_.skill_name,   
         h0btskill_per.doc_name,   
         h0btskill_per.d_effect,   
         h0btskill_per.doc,   
         h0btskill_per.validate_orga,   
         h0btskill_per.skill_desc  
    FROM h0btskill_,   
         h0btskill_per  
   WHERE ( h0btskill_per.skill_cd = h0btskill_.skill_cd ) and  
         ( ( h0btskill_per.staff_cd = '".$staff_cd."' ) AND  
         ( h0btskill_.skill_cd = h0btskill_per.skill_cd ) )  ORDER BY h0btskill_per.d_effect ASC  ";

$result1=pg_query($sql);
$y=55;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
   	    $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['skill_name'],16,$y,9,5);
    wr($gar['doc_name'],35,$y,9,6);
    $temp=str_split($gar['d_effect']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,60,$y,9);
    wr($start_m,69,$y,9);
    wr($start_d,78,$y,9);
    wr($gar['doc'],85,$y,9,8);
    wr($gar['validate_orga'],114,$y,9,10);
    wr($gar['skill_desc'],150,$y,9,12);
    if(++$num == 7)
        break;
    $y+=16.2;
}

//家屬    
$sql="  SELECT h0btrelation_.trelation_name,   
         h0btfamily.family_name,   
         h0btfamily.id,   
         h0btfamily.d_birth,   
         h0btfamily.occupation  
    FROM h0btfamily,   
         h0btrelation_  
   WHERE ( h0btrelation_.trelation_cd = h0btfamily.trelation_cd ) and  
         ( h0btfamily.staff_cd = '".$staff_cd."' ) ";

$result1=pg_query($sql);
$y=196;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
   	    $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['trelation_name'],16,$y,11,5);
    wr($gar['family_name'],38,$y,11,6);
    wr($gar['id'],77,$y,11,12);
    $temp=str_split($gar['d_birth']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,114,$y);
    wr($start_m,131,$y);
    wr($start_d,148,$y);
    wr($gar['occupation'],164,$y,9,8);
    if(++$num == 5)
        break;
    $y+=14;
}
原來的第5頁 */

//第六頁
//考績(成)或成績考核
//教師的年資加薪,等同於職員的考績獎懲;所以教師部份需區分出來。--hueyping(1050202)
$tpl = $pdf->importPage(6);
$pdf->addPage();
$pdf->useTemplate($tpl);

$sql ="SELECT h0btbasic_per.dist_cd ";
$sql.=" FROM h0btbasic_per WHERE h0btbasic_per.staff_cd ='".$staff_cd."'";

$result1=pg_query($sql);
$gar_dist =pg_fetch_assoc($result1);

if ($gar_dist['dist_cd']=='TEA'){ //如果是教師
    $sql="     SELECT h0vtprof_upgrade.d_effect,   
         h0vtprof_upgrade.reason_cd,   
         h0vtprof_upgrade.point_old,   
         h0vtprof_upgrade.point_add_old,   
         h0vtprof_upgrade.point_old_new,   
         h0vtprof_upgrade.doc  
    FROM h0vtprof_upgrade  
    WHERE h0vtprof_upgrade.staff_cd = '".$staff_cd."'  ORDER BY h0vtprof_upgrade.d_effect ASC" ;
    $result1=pg_query($sql);
    $num=0;
    $y=63;  //第一行起始高度
    $y1=67; //第二行起始高度
	while($gar =pg_fetch_assoc($result1)){
	   foreach($gar as $key=>$value){
         $value=trim($value);
         $gar[$key]=$value;
       }
	   $salary_old = $gar['point_old'] + $gar['point_add_old']; //原來的俸級
	   
	   if (trim($gar['reason_cd'])==''){ //如果有晉級
	      $reason_str ='擬晉支薪級:  '.$gar['point_old_new']; 
	   }
	   else{ //沒有晉級
	      //找出沒有晉級的原因說明
		  $sql ="SELECT h0vtno_grade_.name  
                   FROM  h0vtno_grade_  
                  WHERE h0vtno_grade_.cd = '".$gar['reason_cd']. "'"  ;
		  $result_reason=pg_query($sql);
		  $gar_reason =pg_fetch_assoc($result_reason);
          		  
	      $reason_str = '不予晉級:   '.trim($gar_reason['name']);
		  
	   }
	   wr($gar['d_effect'],14,$y); //年別
	   wr($reason_str,52,$y,8,8,0);//核定獎懲
	   wr($salary_old,110,$y);//俸級
	   wr($gar['doc'],150,$y,6,11,0); //核定日期文號
	   if(++$num == 15)  //第六頁有15列
         break;
       $y+=14;
       $y1+=14;
	
	}
	

}
else{ //如果不是教師

     $sql="  SELECT h0vveval_rec.d_eval,   
         h0vveval_rec.eval_type,   
         h0vveval_rec.second_scope,   
         h0vveval_rec.second_eval,   
         h0vveval_rec.rew_name,   
         h0vveval_rec.eval_doc,
         h0vveval_rec.eval_date,
         h0vveval_rec.ccu_doc,  
         h0vveval_rec.ccu_date
       FROM h0vveval_rec  
       WHERE h0vveval_rec.staff_cd = '".$staff_cd."'  ORDER BY h0vveval_rec.d_eval ASC";
   
    $result1=pg_query($sql);
    $num=0;
    $y=63;  //第一行起始高度
    $y1=67; //第二行起始高度
    while($gar =pg_fetch_assoc($result1)){
       foreach($gar as $key=>$value){
         $value=trim($value);
         $gar[$key]=$value;
       }
       wr($gar['d_eval'],14,$y);
    
       $gar['eval_type']=($gar['eval_type']=="1")? "年考":$gar['eval_type'];
       $gar['eval_type']=($gar['eval_type']=="2")? "另考":$gar['eval_type'];
       $gar['eval_type']=($gar['eval_type']=="3")? "不考":$gar['eval_type'];
       wr($gar['eval_type'],22,$y);
       wr($gar['second_scope'],35,$y);
       $gar['second_eval']=($gar['second_eval']=="1")? "甲":$gar['second_eval'];
       $gar['second_eval']=($gar['second_eval']=="2")? "乙":$gar['second_eval'];
       $gar['second_eval']=($gar['second_eval']=="3")? "丙":$gar['second_eval'];
       $gar['second_eval']=($gar['second_eval']=="4")? "丁":$gar['second_eval'];
       wr($gar['second_eval'],44,$y);
       wr($gar['rew_name'],52,$y,8,12);
       wr($gar['ccu_date'],150,$y,8,7);
       wr($gar['ccu_doc'],150,$y1,5,17);
       wr($gar['eval_date'],173,$y,8,7);
       wr($gar['eval_doc'],173,$y1,5,17);

       if(++$num == 15)  //第六頁有15列
         break;
       $y+=14;
       $y1+=14;
    } 
}  


//第七頁--接續第六頁
$tpl = $pdf->importPage(7);
$pdf->addPage();
$pdf->useTemplate($tpl);

$num=0;
$y=63;  //第一行起始高度
$y1=67; //第二行起始高度
if ($gar_dist['dist_cd']=='TEA'){ //如果是教師
    while($gar =pg_fetch_assoc($result1)){
	   foreach($gar as $key=>$value){
         $value=trim($value);
         $gar[$key]=$value;
       }
	   $salary_old = $gar['point_old'] + $gar['point_add_old'];
	   
	   if (trim($gar['reason_cd'])==''){ //如果有晉級
	      $reason_str ='擬晉支薪級:  '.$gar['point_old_new']; 
	   }
	   else{ //沒有晉級
	      //找出沒有晉級的原因說明
		  $sql ="SELECT h0vtno_grade_.name  
                   FROM  h0vtno_grade_  
                  WHERE h0vtno_grade_.cd = '".$gar['reason_cd']. "'"  ;
		  $result_reason=pg_query($sql);
		  $gar_reason =pg_fetch_assoc($result_reason);
          		  
	      $reason_str = '不予晉級:   '.trim($gar_reason['name']);
		  
	   }
	   
	   wr($gar['d_effect'],14,$y); //年別
	   wr($reason_str,52,$y,8,8,0);//核定獎懲	   
	   wr($salary_old,110,$y);//俸級
	   wr($gar['doc'],150,$y,6,11,0);//核定日期文號
	   
	   if(++$num == 13) //第七頁有13列
         break;
       $y+=14;
       $y1+=14;
	}
}
else{ //如果不是教師
    while($gar =pg_fetch_assoc($result1)){
       foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
       }
       wr($gar['d_eval'],14,$y);
    
       $gar['eval_type']=($gar['eval_type']=="1")? "年考":$gar['eval_type'];
       $gar['eval_type']=($gar['eval_type']=="2")? "另考":$gar['eval_type'];
       $gar['eval_type']=($gar['eval_type']=="3")? "不考":$gar['eval_type'];
       wr($gar['eval_type'],22,$y);
       wr($gar['second_scope'],35,$y);
       $gar['second_eval']=($gar['second_eval']=="1")? "甲":$gar['second_eval'];
       $gar['second_eval']=($gar['second_eval']=="2")? "乙":$gar['second_eval'];
       $gar['second_eval']=($gar['second_eval']=="3")? "丙":$gar['second_eval'];
       $gar['second_eval']=($gar['second_eval']=="4")? "丁":$gar['second_eval'];
       wr($gar['second_eval'],44,$y);
       wr($gar['rew_name'],52,$y,8,12);
       wr($gar['ccu_date'],150,$y,8,7);
       wr($gar['ccu_doc'],150,$y1,5,17);
       wr($gar['eval_date'],173,$y,8,7);
       wr($gar['eval_doc'],173,$y1,5,17);

       if(++$num == 13) //第七頁有13列
         break;
       $y+=14;
       $y1+=14;
    } 
} 

/*原來的第7頁
//經歷及現職(任免) 
$sql="SELECT h0evchange_history.torga_name,   
         h0evchange_history.title_name,   
         h0evchange_history.pub_name,   
         h0evchange_history.duty_name,   
         h0evchange_history.task_cd,   
         h0evchange_history.boss_level,   
         h0evchange_history.d_start,   
         h0evchange_history.doc,   
         h0evchange_history.end_doc,   
         h0evchange_history.d_end,   
         h0evchange_history.out_reason_name,   
         h0evchange_history.no_qual,   
         h0evchange_history.per_dist  
    FROM h0evchange_history  
   WHERE h0evchange_history.staff_cd = '".$staff_cd."' ORDER BY h0evchange_history.d_start DESC ";

$result1=pg_query($sql);
$num=0;
$y=69;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['torga_name'],15,$y,9,6);
    wr($gar['title_name'],36,$y,9,3);
    wr($gar['pub_name'],47,$y,9,5);
    wr($gar['task_cd'],66,$y,9,3);
    wr($gar['duty_name'],76,$y,9,3);
    wr($gar['boss_level'],88,$y,9,3);
    wr($gar['doc'],100,$y,9,7);
    
    $temp=str_split($gar['d_start']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,122,$y,10);
    wr($start_m,122,$y+5,10);
    wr($start_d,122,$y+10,10);
    
    wr($gar['end_doc'],130,$y,9,7);
    $temp=str_split($gar['d_end']);
    $end_y=$temp[0].$temp[1].$temp[2];
    $end_m=$temp[3].$temp[4];
    $end_d=$temp[5].$temp[6];
    wr($end_y,154,$y,10);
    wr($end_m,154,$y+5,10);
    wr($end_d,154,$y+10,10);

    wr($gar['out_reason_name'],161,$y,9,4);
    wr($gar['no_qual'],178,$y,9,2);
    wr($gar['per_dist'],186,$y,9,2);
    if(++$num == 7)
        break;
    $y=($num==5)? $y+25 : $y+29.6;
} 
原來的第7頁*/  

//第八頁
$tpl = $pdf->importPage(8);
$pdf->addPage();
$pdf->useTemplate($tpl);

$sql="SELECT h0vtreward.content,   
         h0vtrew_result_.name, 
         h0vtreward.d_rew,  
         h0vtreward.doc  
    FROM h0vtrew_result_,   
         h0vtreward  
   WHERE ( h0vtreward.result_cd = h0vtrew_result_.cd ) and  
         ( ( h0vtreward.staff_cd = '".$staff_cd."' ))";

$result1=pg_query($sql);
$num=0;
$y=51;
while($gar = pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['content'],16,$y,9,22);
    wr($gar['name'],92,$y,9,8);
    wr("國立中正大學",124,$y);
    wr($gar['d_rew'],162,$y,9,12);
    wr($gar['doc'],162,$y+5,9,12);

    
    if(++$num == 12)
        break;
    $y+=18.6;
}  

/*原來的第8頁
$num=0;
$y=69;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['torga_name'],15,$y,9,6);
    wr($gar['title_name'],36,$y,9,3);
    wr($gar['pub_name'],47,$y,9,5);
    wr($gar['task_cd'],66,$y,9,3);
    wr($gar['duty_name'],76,$y,9,3);
    wr($gar['boss_level'],88,$y,9,3);
    wr($gar['doc'],100,$y,9,7);
    
    $temp=str_split($gar['d_start']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,122,$y,10);
    wr($start_m,122,$y+5,10);
    wr($start_d,122,$y+10,10);
    
    wr($gar['end_doc'],130,$y,9,7);
    $temp=str_split($gar['d_end']);
    $end_y=$temp[0].$temp[1].$temp[2];
    $end_m=$temp[3].$temp[4];
    $end_d=$temp[5].$temp[6];
    wr($end_y,154,$y,10);
    wr($end_m,154,$y+5,10);
    wr($end_d,154,$y+10,10);

    wr($gar['out_reason_name'],161,$y,9,4);
    wr($gar['no_qual'],178,$y,9,2);
    wr($gar['per_dist'],186,$y,9,2);
    if(++$num == 6)
        break;
    $y+=27.6;
}
原來的第8頁*/

//第九頁
$tpl = $pdf->importPage(9);
$pdf->addPage();
$pdf->useTemplate($tpl);

//專長
$sql="SELECT h0btskill_.skill_name,   
         h0btskill_per.doc_name,   
         h0btskill_per.d_effect,   
         h0btskill_per.doc,   
         h0btskill_per.validate_orga,   
         h0btskill_per.skill_desc  
    FROM h0btskill_,   
         h0btskill_per  
   WHERE ( h0btskill_per.skill_cd = h0btskill_.skill_cd ) and  
         ( ( h0btskill_per.staff_cd = '".$staff_cd."' ) AND  
         ( h0btskill_.skill_cd = h0btskill_per.skill_cd ) )  ORDER BY h0btskill_per.d_effect ASC  ";

$result1=pg_query($sql);
$y=65;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
   	    $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['skill_name'],16,$y,9,5);
    wr($gar['doc_name'],35,$y,9,6);
    $temp=str_split($gar['d_effect']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,60,$y,9);
    wr($start_m,69,$y,9);
    wr($start_d,78,$y,9);
    wr($gar['doc'],85,$y,9,8);
    wr($gar['validate_orga'],114,$y,9,10);
    wr($gar['skill_desc'],150,$y,9,12);
    if(++$num == 7)
        break;
    $y+=16.2;
}

//外國語文
$sql =" SELECT h0btlang_.language_name  
    FROM h0btlang_,   
         h0btlanguage  
   WHERE ( h0btlanguage.language_cd = h0btlang_.language_cd ) and  
         ( ( h0btlanguage.staff_cd = '".$staff_cd."' ) AND  
         ( h0btlanguage.language_cd = h0btlang_.language_cd )   )  ";

$result1=pg_query($sql);
$num=0;
$y=200;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
    	$value=trim($value);
        $gar[$key]=$value;
    }
    
    wr($gar['language_name'],16,$y,12,5);
    if(++$num ==5 )
	break;
    $y+=15;
}

/*原來的第9頁
//經歷及現職(銓敘審定)
$sql="  SELECT h0evchange_qual.torga_name,   
         h0evchange_qual.title_name,   
         h0evchange_qual.pub_name_change,   
         h0evchange_qual.task_cd,   
         h0evchange_qual.duty_name,   
         h0evchange_qual.doc,   
         h0evchange_qual.qual_result,   
         h0evchange_qual.pub_name_qual,   
         h0evchange_qual.lev,   
         h0evchange_qual.point,   
         h0evchange_qual.temp_point,   
         h0evchange_qual.d_effect,   
         h0evchange_qual.doc_1  
    FROM h0evchange_qual  
   WHERE h0evchange_qual.staff_cd = '".$staff_cd."' ORDER BY h0evchange_qual.d_effect DESC ";
   
$result1=pg_query($sql);
$num=0;
$y=72;
while($gar = pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['torga_name'],14,$y,9,6);
    wr($gar['title_name'],36,$y,9,3);
    wr($gar['pub_name_change'],49,$y,9,4);
    wr($gar['task_cd'],66,$y,9,3);
    wr($gar['duty_name'],76,$y,9,3);
    wr($gar['doc'],88,$y,9,4);
    wr($gar['qual_result'],104,$y,9,3);
    wr($gar['pub_name_qual'],115,$y,9,4);
    wr($gar['lev'],132,$y,9,3);
    wr($gar['point'],146,$y,9,3);
    wr($gar['temp_point'],160,$y,9,3);
    
    $temp=str_split($gar['d_effect']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,171,$y,9);
    wr($start_m,171,$y+5,9);
    wr($start_d,171,$y+10,9);
    wr($gar['doc_1'],179,$y,9,5);
    
    if(++$num == 7)
        break;
    $y=($num==5)? $y+26 : $y+30;
} 
原來的第9頁*/  

//第十頁
$tpl = $pdf->importPage(10);
$pdf->addPage();
$pdf->useTemplate($tpl); 

//檢覆
$sql ="  SELECT h0btexam.t_year,   
         h0btexam_group_.group_name,   
         h0btexam.effect_date,   
         h0btexam.doc  
    FROM h0btexam,   
         h0btexam_group_  
   WHERE ( h0btexam_group_.group_cd = h0btexam.group_cd ) and  
         ( ( h0btexam.staff_cd = '".$staff_cd."' ) AND  
         ( h0btexam.exam_dist = '2' ) AND  
         ( h0btexam.group_cd = h0btexam_group_.group_cd ) )  ORDER BY h0btexam.t_year ASC ";

$result1=pg_query($sql);
$y=54;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
    	$value=trim($value);
        $gar[$key]=$value;
    }
    
    wr($gar['t_year'],19,$y);
    wr($gar['group_name'],34,$y,10,10);
    $temp=str_split($gar['effect_date']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,115,$y);
    wr($start_m,130,$y);
    wr($start_d,145,$y);
    wr($gar['doc'],158,$y,10,9);
    if(++$num == 6)
        break;
    $y+=16;
}  
//甄選--資料庫無甄選紀錄,所以省略。

/*原來的第10頁
$num=0;
$y=72;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['torga_name'],14,$y,9,6);
    wr($gar['title_name'],36,$y,9,3);
    wr($gar['pub_name_change'],49,$y,9,4);
    wr($gar['task_cd'],66,$y,9,3);
    wr($gar['duty_name'],76,$y,9,3);
    wr($gar['doc'],88,$y,9,4);
    wr($gar['qual_result'],104,$y,9,3);
    wr($gar['pub_name_qual'],115,$y,9,4);
    wr($gar['lev'],132,$y,9,3);
    wr($gar['point'],146,$y,9,3);
    wr($gar['temp_point'],160,$y,9,3);
    
    $temp=str_split($gar['d_effect']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,171,$y,9);
    wr($start_m,171,$y+5,9);
    wr($start_d,171,$y+10,9);
    wr($gar['doc_1'],179,$y,9,5);
    
    if(++$num == 6)
        break;
    $y+=28;
}  
原來第10頁*/ 

//第十一頁
$tpl = $pdf->importPage(11);
$pdf->addPage();
$pdf->useTemplate($tpl);


//兵役
$sql="  SELECT h0btbasic_per.d_mil_end,   
         h0btbasic_per.d_mil_start,   
         h0btmil_kind.kind_name,   
         h0btmil_rank.rank_name,   
         h0btmil_service_.service_name,   
         h0btmil_subj_.subj_name,   
         h0btbasic_per.mil_dis_doc  
    FROM h0btbasic_per,   
         h0btmil_kind,   
         h0btmil_rank,   
         h0btmil_service_,   
         h0btmil_subj_  
   WHERE ( h0btmil_kind.kind_cd = h0btbasic_per.kind_cd ) and  
         ( h0btmil_rank.rank_cd = h0btbasic_per.rank_cd ) and  
         ( h0btmil_service_.service_cd = h0btbasic_per.service_cd ) and  
         ( h0btmil_subj_.subj_cd = h0btbasic_per.mil_subj_cd ) and  
         ( ( h0btbasic_per.staff_cd = '".$staff_cd."' ) )";

$result1=pg_query($sql);
if($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['kind_name'],35,44,12,5);
    wr($gar['service_name'],86,44,12,5);
    wr($gar['subj_name'],154,44,12,5);
    wr($gar['rank_name'],35,60,12,5);
    $temp=str_split($gar['d_mil_start']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,98,55);
    wr($start_m,110,55);
    wr($start_d,121,55);
    $temp=str_split($gar['d_mil_end']);
    $end_y=$temp[0].$temp[1].$temp[2];
    $end_m=$temp[3].$temp[4];
    $end_d=$temp[5].$temp[6];
    wr($end_y,98,65);
    wr($end_m,110,65);
    wr($end_d,121,65);
    wr($gar['mil_dis_doc'],154,54,10,14);
}

//教師資格
$sql="  SELECT h0etprof_qual.qual_title,   
         h0rtschool_.school_name,   
         h0etprof_qual.d_salary_start,   
         h0etprof_qual.teach_doc  
    FROM h0etprof_qual,   
         h0rtschool_  
   WHERE ( h0rtschool_.school_cd = h0etprof_qual.qual_school ) and  
         ( ( h0etprof_qual.staff_cd = '".$staff_cd."' ) AND  
         ( h0etprof_qual.qual_school = h0rtschool_.school_cd ) ) ORDER BY h0etprof_qual.d_salary_start ASC ";

$result1=pg_query($sql);
$y=113;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
   	    $value=trim($value);
        $gar[$key]=$value;
    }
    wr("V",37,$y,12);
    switch($gar['qual_title']){
        case "T01":
            $gar['qual_title']="教授";
            break;
        case "T02":
            $gar['qual_title']="副教授";
            break;
        case "T03":
            $gar['qual_title']="講師";
            break;
        case "T04":
            $gar['qual_title']="助教";
            break;
        case "T05":
            $gar['qual_title']="助理教授";
            break;
        default:
            $gar['qual_title']="其他";
    }
    wr($gar['qual_title'],42,$y,10);
    wr($gar['school_name'],90,$y,10,10);
    $temp=str_split($gar['d_salary_start']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,138,$y,10);
    wr($start_m,148,$y,10);
    wr($start_d,158,$y,10);
    wr($gar['teach_doc'],164,$y,10,10);
    if(++$num == 6)
        break;
    $y+=18;
}

//身心障礙註記
$sql="  SELECT h0btbasic_per.disable_con,   
         h0btdiable_.disable_desc  
    FROM h0btbasic_per,   
         h0btdiable_  
   WHERE ( h0btdiable_.disable_cd = h0btbasic_per.disable_cd ) and  
         ( ( h0btbasic_per.staff_cd = '".$staff_cd."' ) AND  
         ( h0btbasic_per.disable_cd = h0btdiable_.disable_cd ) ) ";
         
$result1=pg_query($sql);
if($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['disable_desc'],18,242,12,10);
    $gar['disable_con']=($gar['disable_con']=="0") ? "無身心障礙":$gar['disable_con'];
    $gar['disable_con']=($gar['disable_con']=="4") ? "輕度":$gar['disable_con'];
    $gar['disable_con']=($gar['disable_con']=="3") ? "中度":$gar['disable_con'];
    $gar['disable_con']=($gar['disable_con']=="2") ? "重度":$gar['disable_con'];
    $gar['disable_con']=($gar['disable_con']=="1") ? "極重度":$gar['disable_con'];
    wr($gar['disable_con'],70,242);
}

//原住民族註記
$sql="  SELECT h0btabor_.abor_name,   
         h0btbasic_per.abor_dist  
    FROM h0btabor_,   
         h0btbasic_per  
   WHERE ( h0btbasic_per.abor_cd = h0btabor_.abor_cd ) and  
         ( ( h0btbasic_per.staff_cd = '".$staff_cd."' ) AND  
         ( h0btbasic_per.abor_cd = h0btabor_.abor_cd ) ) ";

$result1=pg_query($sql);
if($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
    $gar['abor_dist']=($gar['abor_dist']=="0") ? "非原住民族":$gar['abor_dist'];
    $gar['abor_dist']=($gar['abor_dist']=="1") ? "平地":$gar['abor_dist'];
    $gar['abor_dist']=($gar['abor_dist']=="2") ? "山地":$gar['abor_dist'];
    wr($gar['abor_dist'],114,242);
    wr($gar['abor_name'],154,242,12,8);
}



//第十二頁
$tpl = $pdf->importPage(12);
$pdf->addPage();
$pdf->useTemplate($tpl);

//家屬    
$sql="  SELECT h0btrelation_.trelation_name,   
         h0btfamily.family_name,   
         h0btfamily.id,   
         h0btfamily.d_birth,   
         h0btfamily.occupation  
    FROM h0btfamily,   
         h0btrelation_  
   WHERE ( h0btrelation_.trelation_cd = h0btfamily.trelation_cd ) and  
         ( h0btfamily.staff_cd = '".$staff_cd."' ) ";

$result1=pg_query($sql);
$y=62;
$num=0;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
   	    $value=trim($value);
        $gar[$key]=$value;
    }
    wr($gar['trelation_name'],16,$y,11,5);
    wr($gar['family_name'],38,$y,11,6);
    wr($gar['id'],77,$y,11,12);
    $temp=str_split($gar['d_birth']);
    $start_y=$temp[0].$temp[1].$temp[2];
    $start_m=$temp[3].$temp[4];
    $start_d=$temp[5].$temp[6];
    wr($start_y,114,$y);
    wr($start_m,129,$y);
    wr($start_d,140,$y);
    wr($gar['occupation'],164,$y,9,8);
    if(++$num == 8)
        break;
    $y+=21;
}

//公教貸款或配購公教住宅註記
$sql="  SELECT h0btbasic_per.loan_remark  
    FROM h0btbasic_per  
   WHERE h0btbasic_per.staff_cd = '".$staff_cd."'  ";

$result1=pg_query($sql);
if($gar =pg_fetch_assoc($result1)){
    switch($gar['loan_remark']){
        case "1":
            wr("V",29,242);
            break;
        case "2":
            wr("V",74,242);
            break;
        case "3":
            wr("V",114,242);
            break;
    }
}

 
//第十三頁
$tpl = $pdf->importPage(13);
$pdf->addPage();
$pdf->useTemplate($tpl);  

//訓練及進修
$sql ="SELECT h0btbasic_per.dist_cd ";
$sql.=" FROM h0btbasic_per WHERE h0btbasic_per.staff_cd ='".$staff_cd."'";

$result1=pg_query($sql);
$gar =pg_fetch_assoc($result1);
$num=0;
$y=70;
if($gar['dist_cd']=='TEA'){   //若是教師
    $sql="  SELECT  h0ttprof_study.country_hf, 
         h0ttprof_study.dist,   
         h0ttprof_study.school,   
         h0ttprof_study.project_name,   
         h0ttprof_study.d_study_start,   
         h0ttprof_study.d_study_end_actual,   
         h0ttprof_study.doc  
    FROM h0ttprof_study  
   WHERE ( h0ttprof_study.staff_cd = '".$staff_cd."' ) AND  
         ( h0ttprof_study.dist = '1' )  ORDER BY h0ttprof_study.d_study_start ASC ";
    $result1=pg_query($sql);

    while($gar =pg_fetch_assoc($result1)){
        foreach($gar as $key=>$value){
        	$value=trim($value);
            $gar[$key]=$value;
        }
        $x=($gar['country_hf']=="H")? 22:35;
        wr("V",$x,$y,10);    
        wr($gar['school'],42,$y,10,7);
        wr($gar['project_name'],79,$y,9,8);
        $temp=str_split($gar['d_study_start']);
        $start_y=$temp[0].$temp[1].$temp[2];
        $start_m=$temp[3].$temp[4];
        $start_d=$temp[5].$temp[6];
        wr($start_y,145,$y,9);
        wr($start_m,145,$y+4,9);
        wr($start_d,145,$y+8,9);
        $temp=str_split($gar['d_study_end_actual']);
        $end_y=$temp[0].$temp[1].$temp[2];
        $end_m=$temp[3].$temp[4];
        $end_d=$temp[5].$temp[6];
        wr($end_y,154,$y,9);
        wr($end_m,154,$y+4,9);
        wr($end_d,154,$y+8,9);
        wr($gar['doc'],173,$y,9,5);
        if(++$num == 12)
            break;
        $y+=16;
    }
}else{   //若不是教師
    $sql="  SELECT h0tvstaff_study_train.country_hf,   
         h0tvstaff_study_train.dist,   
         h0tvstaff_study_train.orga,   
         h0tvstaff_study_train.class,   
         h0tvstaff_study_train.how,   
         h0tvstaff_study_train.phase,   
         h0tvstaff_study_train.d_start,   
         h0tvstaff_study_train.d_end,   
         h0tvstaff_study_train.hours_points,   
         h0tvstaff_study_train.doc  
    FROM h0tvstaff_study_train  
   WHERE h0tvstaff_study_train.staff_cd = '".$staff_cd."' ORDER BY h0tvstaff_study_train.d_start ASC ";
    $result1=pg_query($sql);

    while($gar =pg_fetch_assoc($result1)){
        foreach($gar as $key=>$value){
        	$value=trim($value);
            $gar[$key]=$value;
        }
        $x=($gar['country_hf']=="H")? 16:29;
        $x=($gar['dist']=="1")? $x+6:$x;
        wr("V",$x,$y,10);    
        wr($gar['orga'],42,$y,10,7);
        wr($gar['class'],79,$y,9,8);
        $x=($gar['how']=="1")? 124:131;
        wr("V",$x,$y,10);
        wr($gar['phase'],137,$y,9,3);
        $temp=str_split($gar['d_start']);
        $start_y=$temp[0].$temp[1].$temp[2];
        $start_m=$temp[3].$temp[4];
        $start_d=$temp[5].$temp[6];
        wr($start_y,145,$y,9);
        wr($start_m,145,$y+4,9);
        wr($start_d,145,$y+8,9);
        $temp=str_split($gar['d_end']);
        $end_y=$temp[0].$temp[1].$temp[2];
        $end_m=$temp[3].$temp[4];
        $end_d=$temp[5].$temp[6];
        wr($end_y,154,$y,9);
        wr($end_m,154,$y+4,9);
        wr($end_d,154,$y+8,9);
        wr($gar['hours_points'],162,$y,9);
        wr($gar['doc'],173,$y,9,5);
        if(++$num == 12)
            break;
        $y+=16;
    }
    
} 



//第十四頁
$tpl = $pdf->importPage(14);
$pdf->addPage();
$pdf->useTemplate($tpl);

$sql="  SELECT staff_cd,des_01,des_02,des_03,des_04,des_05,des_06,des_07,des_08,des_09,des_10,des_11,des_12,des_13,des_14
		FROM h0bt_autobiography_rec  
		WHERE h0bt_autobiography_rec.staff_cd = '".$staff_cd."' ";
   
$result1=pg_query($sql);


$num=0;
$y=43;
while($gar =pg_fetch_assoc($result1)){
    foreach($gar as $key=>$value){
        $value=trim($value);
        $gar[$key]=$value;
    }
	
	
	wr($gar['des_01'],15,43);
    wr($gar['des_02'],15,56);
    wr($gar['des_03'],15,68);
    wr($gar['des_04'],15,80);
    wr($gar['des_05'],15,92);
    wr($gar['des_06'],15,104);
    wr($gar['des_07'],15,116);
    wr($gar['des_08'],15,128);
    wr($gar['des_09'],15,140);
    wr($gar['des_10'],15,152);
    wr($gar['des_11'],15,164);
    wr($gar['des_12'],15,176);
    wr($gar['des_13'],15,188);
    wr($gar['des_14'],15,200);
    
    if(++$num == 14)
        break;
    $y+=12;
}



$tpl = $pdf->importPage(15);
$pdf->addPage();
$pdf->useTemplate($tpl); 

$tpl = $pdf->importPage(16);
$pdf->addPage();
$pdf->useTemplate($tpl); 

$tpl = $pdf->importPage(17);
$pdf->addPage();
$pdf->useTemplate($tpl); 

// 輸出成本地端 PDF 檔案
$pdf->output($staff_cd.".pdf", "D");

// 結束 FPDI 剖析器
$pdf->closeParsers();

?>


