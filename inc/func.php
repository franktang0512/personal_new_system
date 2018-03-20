<?php

function input_format($name,$value,$type,$num){
	if ($type=="readonly"){
		if(empty($value)||trim($value)==""){
			echo "&nbsp;";
		}
		else{
			echo $value;
		}
	}
	else{
	   	echo "<input name='$name' value='$value' size='$num'>";
	}
}

//現職異動(hp041_change.php)職稱
function title($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0rttilte_.title_cd, h0rttilte_.title_name 
        	 	      FROM h0rttilte_  
       			      WHERE h0rttilte_.title_cd='$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['title_name'];
		}
		else{
			echo "&nbsp";
		}
	}
}

//現職異動(hp041_change.php)任職別
function dist($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0rtdist_.dist_cd, h0rtdist_.dist_type 
                  FROM h0rtdist_ 
                  WHERE h0rtdist_.dist_cd ='$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['dist_type'];
      		}
      		else{
      			echo "&nbsp";
      		}
      	}
}

//現職異動(hp041_change.php)單位
function unit($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0rtunit_.unit_cd, h0rtunit_.unit_name 
        	 	      FROM h0rtunit_
			      WHERE h0rtunit_.unit_cd ='$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['unit_name'];
		}
		else{
			echo "&nbsp";
		}
	}
}

//現職異動(hp041_change.php)部定官職等
//(職員)敘薪資料(hp113_salary.php)官職等
function pub_cd($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0etpub_rank_.pub_cd, h0etpub_rank_.pub_name 
			      FROM h0etpub_rank_   
			      WHERE h0etpub_rank_.pub_cd = '$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['pub_name'];
		}
		else{
			echo "&nbsp";
		}
	}
}

//現職異動(hp041_change.php)職系
function duty($name,$value,$type){
	if ($type=="readonly"){
        	if($value!=""){
        		$sql="SELECT h0etduty_.duty_cd, h0etduty_.duty_name 	
       		 	      FROM h0etduty_    
			      WHERE h0etduty_.duty_cd = '$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['duty_name'];
		}
		else{
			echo "&nbsp";
		}
	}
}

//現職異動(hp041_change.php)工作類別
function job($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0etjob_.job_cd, h0etjob_.job_name  
			      FROM h0etjob_  
			      WHERE h0etjob_.job_cd =  '$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['job_name'];
		}
		else{
     			echo "&nbsp";
     		}
	}
} 

 
//現職異動(hp041_change.php)任職/離職原因
//(教師)敘薪資料(hp119_salary.php)敘薪原因
//(稀少性科技職員)敘薪資料(hp503_salary.php)敘薪原因
//(職員)敘薪資料(hp113_salary.php)敘薪原因
function reason($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			if(strlen($value)<2){
				$value="0".$value;
				$sql="SELECT h0etchg_reason_.reason_cd, h0etchg_reason_.reason_name 
				      FROM h0etchg_reason_  
 				      WHERE h0etchg_reason_.reason_cd ='$value'";
			}
			else{
				$sql="SELECT h0etchg_reason_.reason_cd, h0etchg_reason_.reason_name 
				      FROM h0etchg_reason_  
				      WHERE h0etchg_reason_.reason_cd ='$value'";
			}
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['reason_name'];
		}
		else{
			echo "&nbsp";
		}
	}
}

//現職異動(hp041_change.php)機關代碼
function orga($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0rtorga_.torga_cd, h0rtorga_.torga_name    
		  	      FROM h0rtorga_   
			      WHERE h0rtorga_.torga_cd ='$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['torga_name'];
		}
		else{
			echo  "&nbsp";
		}
	}
}
		
//(教師)敘薪資料(hp119_salary.php)俸額
function salary($d_effect,$point,$type){
	if ($point!=""){
		$d_effect=substr($d_effect,0,3);
		$sql="SELECT h0ptsalary_.salary  
              FROM h0ptsalary_  
       	      WHERE (h0ptsalary_.dist_cd ='$type') AND   
                    (h0ptsalary_.d_effect='$d_effect') AND   
 		     	    (h0ptsalary_.point=$point)";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
		$salary=number_format($row['salary']);
		return $salary;
	}
	else{
	  	echo "&nbsp";
	} 
}

//(教師)敘薪資料(hp119_salary.php)學術研究費
function duty_pay($d_effect,$title_cd){
	$d_effect=substr($d_effect,0,3);
	$sql="SELECT h0ptduty_pay_.pay     
 	        FROM h0ptduty_pay_     
 	       WHERE (h0ptduty_pay_.d_effect='$d_effect') AND     
 		         (h0ptduty_pay_.title_cd='$title_cd')";  
	$result=pg_query($sql);
	$row=pg_fetch_array($result);
	if($row['pay']==""){
		echo "&nbsp";
	}
	else{
		$pay=number_format($row['pay']);  
		echo $pay;
	}
}

//年資加薪(hp168_prof_upgrade.php)未晉級原因
function grade_reason($name,$value,$type){
	if ($type=="readonly"){
  		if($value!=""){
   			$sql="SELECT h0vtno_grade_.name,
                         h0vtno_grade_.cd 
	   		        FROM h0vtno_grade_ 
                   WHERE h0vtno_grade_.cd ='$value'";
     	    $result=pg_query($sql);
   			$row=pg_fetch_array($result);
    			echo $row['name'];
    		}
    		else{
   			echo "&nbsp";
   		}
   	}
}

//獎懲資料(hp144_reward.php)獎懲類別
function rew_class($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0vtrew_class_.cd, h0vtrew_class_.name   
                              FROM h0vtrew_class_   
                       	      WHERE h0vtrew_class_.cd  ='$value'";
			$result= pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['name'];
		}
		else{
			echo  "&nbsp";
		}
	}
}

//獎懲資料(hp144_reward.php)獎懲結果
function rew_result($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
	 		$sql="SELECT h0vtrew_result_.name, h0vtrew_result_.cd  
                        	FROM h0vtrew_result_   
                       	WHERE h0vtrew_result_.cd ='$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['name'];
		}
		else{
			echo  "&nbsp";
		}
	}
}

//學歷資料(hp023_edu.php)修業國別
function edu_nation($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0rtnation_.n_name, h0rtnation_.n_cd    
			      FROM h0rtnation_   
                       	      WHERE h0rtnation_.n_cd = '$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['n_name'];
		}
		else{
			echo "&nbsp";
		}
	}
}

//學歷資料(hp023_edu.php)修業別
function edu_status($name,$value,$type){
	if ($type=="readonly"){
		if($value!=""){
			$sql="SELECT h0btedu_status_.edu_status_name,h0btedu_status_.edu_status 
                              FROM h0btedu_status_  
                              WHERE h0btedu_status_.edu_status = '$value'";
			$result=pg_query($sql);
			$row=pg_fetch_array($result);
			echo $row['edu_status_name'];
		}
		else{
			echo "&nbsp";
		}
	}
}	

//學歷資料(hp023_edu.php)教育程度
function edu_deg($name,$value,$type){
if ($type=="readonly"){
	$sql=" SELECT h0btedu_deg_.edu_deg_name, h0btedu_deg_.edu_deg_cd  
                 FROM h0btedu_deg_  
                WHERE h0btedu_deg_.edu_deg_cd = '$value'";
	$result=pg_query($sql);
	$row=pg_fetch_array($result);
	echo $row['edu_deg_name'];
}else{
echo "&nbsp";}
}
 
//學歷資料(hp023_edu.php)教育類別 
function edu_grp($name,$value,$type){
if ($type=="readonly"){
	$sql="SELECT h0btedu_grp_.edu_grp_name, h0btedu_grp_.edu_grp_cd
                FROM h0btedu_grp_  
               WHERE h0btedu_grp_.edu_grp_cd =  '$value'";
	$result=pg_query($sql);
	$row=pg_fetch_array($result);
	if($row['edu_grp_cd']==""||empty($row['edu_grp_cd'])){echo "&nbsp";}
   	else{ echo $row['edu_grp_name'];}
   	}
   	}
   	
//學歷資料(hp023_edu.php)學術專長
function specialty($name,$value,$type){
	// Lsg 95.05.29 取得某一人員之專長資料
	if ($type=="readonly"){
		$sql="SELECT h0btspecialyt_a.specialty_name as name_1,
                     h0btspecialyt_b.specialty_name as name_2,
                     h0btspecialyt_c.specialty_name as name_3 
              FROM h0btedu_bg 
              left OUTER JOIN  h0btspecialyt_ h0btspecialyt_a on(h0btedu_bg.specialty_cd=h0btspecialyt_a.specialty_cd)
              left OUTER JOIN  h0btspecialyt_ h0btspecialyt_b on(h0btedu_bg.specialty_cd1=h0btspecialyt_b.specialty_cd)
              left OUTER JOIN  h0btspecialyt_ h0btspecialyt_c on(h0btedu_bg.specialty_cd2=h0btspecialyt_c.specialty_cd)
              WHERE h0btedu_bg.staff_cd='$name' and h0btedu_bg.edu_bg_d_start='$value'";
		
		$special_name = "";
		$result=pg_query($sql) or die("error");		
		$fetch=pg_fetch_array($result);
				
		if ($fetch['name_1'])
			$special_name = $special_name . $fetch['name_1'];
				
		if ($fetch['name_2']){
			if($special_name == "")
				$special_name = $special_name . $fetch['name_2'];
			else
				$special_name = $special_name . "、" . $fetch['name_2'];
		}
			
		if ($fetch['name_3']){
			if($special_name == "")
				$special_name = $special_name . $fetch['name_3'];
			else
				$special_name = $special_name . "、" . $fetch['name_3'];
		}
		
		if($special_name == "")
			echo "&nbsp";
		else
			echo $special_name;
	}
}

/***function is_upgraded($name,$value,$type){
if ($type=="readonly"){
$sql="SELECT h0vtstaff_eval.is_upgraded, ";   
$sql=$sql."FROM h0vtstaff_eval"; 
$sql=$sql."WHERE h0btedu_grp_.edu_grp_cd =  '$value'";
$result= sybase_query($sql);
$row=sybase_fetch_array($result);
if($row['edu_grp_cd']==""||empty($row['edu_grp_cd'])){
   echo "&nbsp";}
 else{  
  echo $row['edu_grp_name'];}
}
}****/

//考績資料(hp_167_eval.php)考績核定結果
function eval_cd($name,$value,$type){
if ($type=="readonly"){
	if($value!=""){
		$sql=" SELECT h0vteval_rew_.name, h0vteval_rew_.cd   
                         FROM h0vteval_rew_        
                        WHERE h0vteval_rew_.cd ='$value'";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
		echo $row['name'];
	}else{
	echo "&nbsp";}
	}
	}

//(約聘雇人員)敘薪資料(hp104_salary.php)預算科目
function subj_cd($name,$value,$type){
if ($type=="readonly"){
	if($value!=""){
		$sql="SELECT h0ptbudg_subj_.cd,h0ptbudg_subj_.name
                        FROM h0ptbudg_subj_ 
                       WHERE h0ptbudg_subj_.cd =  '$value'";
		$result= sybase_query($sql);
		$row=sybase_fetch_array($result);
		echo $row['name'];
	}else{
	echo "&nbsp";}
	}
	}
/************	
function off_salary($pub_rank,$pub_lev,$is_serior,$pub_level,$i){
$sql=" SELECT h0ptrank_pnt_.pub_point,    ";     
$sql=$sql." h0ptrank_pnt_.match_rank,    ";     
$sql=$sql."  h0ptrank_pnt_.lev    ";  
$sql=$sql." FROM h0ptgov_pnt_,  ";    
$sql=$sql."  h0ptrank_pnt_    ";    
$sql=$sql." WHERE ( h0ptrank_pnt_.match_rank = h0ptgov_pnt_.match_rank ) and    ";    
$sql=$sql." ( h0ptrank_pnt_.lev = h0ptgov_pnt_.lev ) and    ";    
$sql=$sql." ( h0ptgov_pnt_.pub_rank = '$pub_rank' ) AND    ";    
$sql=$sql." ( h0ptgov_pnt_.pub_lev = '$pub_lev' ) AND    ";    
$sql=$sql." ( h0ptgov_pnt_.is_serior = '$is_serior' ) AND    ";    
$sql=$sql." ( h0ptgov_pnt_.pub_level = '$pub_level' )  ";  
$result= sybase_query($sql);
$row=sybase_fetch_array($result);
if ($i==1){
    switch($row['match_rank']){
     case '1':
      return "相當簡任";
      case '2':
      return "相當薦任";
      case '3':
     return "相當委任";
	}
}else{
	return $row['lev'];}
}**********************/


//(稀少性科技職員)敘薪資料(hp503_salary.php) =>$salary   俸額
//(職員)敘薪資料(hp113_salary.php) =>$salary   俸額
function off_get_salary($d_effect,$point){
$sql=" SELECT h0ptsalary_.salary  
         FROM h0ptsalary_  
        WHERE ( h0ptsalary_.dist_cd = '1' ) AND ( h0ptsalary_.d_effect = '$d_effect' ) AND ( h0ptsalary_.point = '$point' )  ";
$result=pg_query($sql);
$row=pg_fetch_array($result);
return $row['salary'];
}
	
//(稀少性科技職員)敘薪資料(hp503_salary.php) =>$duty   專業加給
//(職員)敘薪資料(hp113_salary.php) =>$duty   專業加給
function off_get_duty($d_effect,$title_cd,$lev){
$sql="SELECT h0ptduty_pay_.pay  
	FROM h0ptduty_pay_  
       WHERE h0ptduty_pay_.d_effect = '$d_effect' and h0ptduty_pay_.title_cd = '$title_cd' and  
             h0ptduty_pay_.rank_cd = ( select max(a.rank_cd) from h0ptduty_pay_ a  where a.d_effect = h0ptduty_pay_.d_effect and a.title_cd = h0ptduty_pay_.title_cd and a.rank_cd <= '$lev' )  ";
$result=pg_query($sql);
$row=pg_fetch_array($result);
if(empty($row['pay']) or trim($row['pay']) =='' or $row['pay']==0){
	$sql="select max(h0ptduty_pay_.pay) 
	        from h0ptduty_pay_  
               where h0ptduty_pay_.d_effect = '$d_effect' and  h0ptduty_pay_.title_cd =  '$title_cd'  ";
	$result=pg_query($sql);
	$row=pg_fetch_array($result);
	}
return $row[0];
}

//(職員)敘薪資料(ho113_salary.php) =>$boss 主管加給
function off_get_boss($d_effect,$title_cd,$point){
$sql=" SELECT h0ptboss_pay_.pay
	 FROM h0ptboss_pay_   
        WHERE ( h0ptboss_pay_.d_effect = '$d_effect' ) AND( h0ptboss_pay_.title_cd = '$title_cd' )  ";
$result= pg_query($sql);
$row=pg_fetch_array($result);
if(pg_num_rows($result) > 1){
	$sql=" SELECT h0ptboss_pay_.pay  
	         FROM h0ptboss_pay_ 
	        WHERE ( h0ptboss_pay_.d_effect = '$d_effect' ) AND ( h0ptboss_pay_.title_cd = '$title_cd' ) AND ( h0ptboss_pay_.point = $point)  ";
	$result=pg_query($sql);
	$row=pg_fetch_array($result);
	}
return $row['pay'];
}

//(稀少性科技職員)敘薪資料(hp503_salary.php)職等 
function rank($name,$rank,$p_level,$type){
if ($type=="readonly"){
	if(empty($rank)||trim($rank)==""){
   		if(empty($p_level)||trim($p_level)=="")	echo "&nbsp";
  		else if(trim($p_level)!="")   echo $p_level."級";
  		}
	else if(trim($rank)!=""){
   		if(trim($p_level)!="")      echo $rank."職等".$p_level."級";
   		 else if(trim($rank)=="")   echo $rank."職等";
   		 }
   		 }
   		 }
   		 
//到校前經歷資料查詢(pre_work.php)機關
function pre_torga($name,$value,$type){
if ($type=="readonly"){
	if($value!=""){
		$sql="SELECT   h0rtorga_.torga_name,  h0rtorga_.torga_cd    
                        FROM h0rtorga_   
                       WHERE h0rtorga_.torga_cd = '$value'";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
		echo $row['torga_name'];
	}else{
		echo "&nbsp";}
		}
		}
		
//到校前經歷資料查詢(pre_work.php)職稱
function pre_pub_title_cd($name,$value,$type){
if ($type=="readonly"){
	
	if($value!="" && $value != NULL){
		$sql="SELECT h0rttilte_.title_name,  h0rttilte_.title_cd    
                        FROM h0rttilte_   
                       WHERE h0rttilte_.put_title_cd = '$value'";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
	 if (pg_num_rows($result)>0){
		echo $row['title_name'];}
	else{echo "&nbsp";}	
	}else{
		echo "&nbsp";}
		}
		}
//到校前經歷資料查詢(pre_work.php)官職等
function pre_pub_cd($name,$value,$type){
if ($type=="readonly"){
	if($value!="" && $value != NULL){		
		$sql="SELECT   h0etpub_rank_.pub_name,  h0etpub_rank_.pub_cd    
                        FROM h0etpub_rank_   
                       WHERE h0etpub_rank_.pub_cd = '$value'";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
		echo $row['pub_name'];
	}else{
		echo "&nbsp";}
		}
		}
		
//到校前經歷資料查詢(pre_work.php)職系
function pre_duty_cd($name,$value,$type){
if ($type=="readonly"){
	if($value!=""){
		$sql="SELECT   h0etduty_.duty_name,  h0etduty_.duty_cd    
                        FROM h0etduty_   
                       WHERE h0etduty_.duty_cd = '$value'";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
		echo $row['duty_name'];
	}else{
		echo "&nbsp";}
		}
		}
		
//到校前經歷資料查詢(pre_work.php)離職原因
function pre_out_reason($name,$value,$type){
if ($type=="readonly"){
	if($value!=""){
		$sql="SELECT   h0etchg_reason_.reason_name,  h0etchg_reason_.reason_cd    
                        FROM   h0etchg_reason_   
                       WHERE h0etchg_reason_.reason_cd = '$value'";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
		echo $row['reason_name'];
	}else{
		echo "&nbsp";}
		}
		}
 
 //教師兼行政職查詢(tea_plural.php)兼任單位
 function plural_unit($name,$value,$type){
if ($type=="readonly"){
	if($value!=""){
		$sql="SELECT h0rtunit_.unit_name,h0rtunit_.unit_cd    
                FROM h0rtunit_  
               WHERE h0rtunit_.unit_cd='$value'";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
		echo $row['unit_name'];
	}else{
		echo "&nbsp";}
		}
		}

 //教師兼行政職查詢(tea_plural.php)兼任職務
 function plural_title_cd($name,$value,$type){
if ($type=="readonly"){
	if($value!=""){
		$sql="SELECT h0rttilte_.title_name,h0rttilte_.title_cd    
                FROM h0rttilte_  
               WHERE h0rttilte_.title_cd = '$value'";
		$result=pg_query($sql);
		$row=pg_fetch_array($result);
		echo $row['title_name'];
	}else{
		echo "&nbsp";}
		}
		}

   		 

//紀錄修改基本資料的使用者帳號和時間
class newDate{
		var $present;
		function newDate(){
				$date= array("year", "month", "day");
				for($i=0;$i<sizeof($date);$i++)
				{
				$result3 = pg_query("Select CAST(DATE_PART('$date[$i]',NOW()) AS CHAR(10))");
				list($time) =pg_fetch_array($result3);
				
				pg_free_result($result3);
				$dd[$i]= $time;
			}
			$dd[0] = trim($dd[0]);
			
			$dyear = strrev(substr(strrev("000".(intval($dd[0])-1911)), 0, 3));
 
			$dd[1] = strval(intval($dd[1]));
			if (strlen($dd[1]) < 2)
			   $dd[1] = "0".$dd[1];
			   
			$dd[2] = strval(intval($dd[2]));   
			if (strlen($dd[2]) < 2)
			   $dd[2] = "0".$dd[2];
			
			$this->present = $dyear.$dd[1].$dd[2];
			
	
		}
	}	
	
	//於update.php中使用
	function write_log($count){		
		
		$upcount = strtoUpper($count);	
		$presentTime = new newDate();			
		$ls_datetime = $presentTime->present;
				
		//記錄修改資訊(last_m_staff_cd與last_m_date)
	   	$sqlStr = "update h0btbasic_per  set last_m_staff_cd = '$upcount', last_m_date ='$ls_datetime' where staff_cd ='".$_SESSION["id"]."'"; 
		$ret =	sybase_query($sqlStr);
		sybase_free_result($ret);
		}
		
	// 密碼解密函數
    /*
        function decode($p){
		$ll_length=strlen($p)-1;
		$li_rand=ord(substr($p, -1));
		if(!isset($ls_decode))
			$ls_decode="";
		for ($i=0; $i< $ll_length; $i++){
			$lc_char = substr($p, $i, 1);
			$ls_decode = $ls_decode . chr(ord($lc_char)-$li_rand);
		}
		return $ls_decode;
	}
    */
    function encode($p){
    $sql="SELECT encode(encrypt('".$p."','bsofafrfktr','aes'),'hex')";
    $result=pg_query($sql) or die("encode sql error!");
    $ls_encode=pg_fetch_result($result,0,0);
    return $ls_encode;
    }
    
    function decode($p){
    $sql="SELECT convert_from(decrypt(decode('".$p."','hex'),'bsofafrfktr','aes'),'utf-8')";
    $result=pg_query($sql) or die("decode sql error!");
    $ls_decode=pg_fetch_result($result,0,0);
    return $ls_decode;
    }    
	
	// 日期格式化程式
	function dataFormat($d){		
	    $year=substr($d,0,3);
	    $month=substr($d,3,2);
	    $days=substr($d,5,2);
	    $dates = $year."/".$month."/".$days;
	    return $dates;
	}				
?>