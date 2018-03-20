<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}



include_once("inc/conn.php");
// include_once("inc/pg_conn.php");
include_once("hp_sketch_proc_lib.php");


if(isset($_POST["form_sent"])){
    
	
	
	$desarray = array();
	$desarray[]=$_POST["desc01"];
	$desarray[]=$_POST["desc02"];
	$desarray[]=$_POST["desc03"];
	$desarray[]=$_POST["desc04"];
	$desarray[]=$_POST["desc05"];
	$desarray[]=$_POST["desc06"];
	$desarray[]=$_POST["desc07"];
	$desarray[]=$_POST["desc08"];
	$desarray[]=$_POST["desc09"];
	$desarray[]=$_POST["desc10"];
	$desarray[]=$_POST["desc11"];
	$desarray[]=$_POST["desc12"];
	$desarray[]=$_POST["desc13"];
	$desarray[]=$_POST["desc14"];
	foreach($desarray as $key=>$value){
		$desarray[$key]=$value;
	}
    foreach($_POST as $key=>$value){
		//$_POST[$key]=big52utf8($value);
		//$_POST[$key] = mb_convert_encoding($value, "UTF-8", "big5");
		
		$_POST[$key]=$value;
		//$_POST[$key]=bcf($_POST[$key]);
        $_POST[$key]=trim($_POST[$key]);
    }
    
    switch($_POST["form_sent"]){
        case "p01":

                if(pg_query("DELETE FROM h0xtbasic_per WHERE h0xtbasic_per.staff_cd='".$_SESSION["proc_edit_id"]."'")){
                        $sql=" INSERT INTO h0xtbasic_per  
                             ( staff_cd,   
                               c_name,   
                               e_name,   
                               d_birth,   
                               sex,   
                               d_join,   
                               marriage_cd,   
                               passport,
                               n_cd,   
                               root_addr,   
                               now_addr,   
                               phone,   
                               phone2,   
                               pem_addr,   
                               intancy_per,   
                               relationship,   
                               intancy_tel,   
                               intancy_tel_2,   
                               disable_cd,   
                               disable_con,   
                               abor_dist,   
                               abor_cd,   
                               loan_remark,   
                               kind_cd,   
                               service_cd,   
                               rank_cd,   
                               mil_subj_cd,   
                               d_mil_start,   
                               d_mil_end,   
                               mil_dis_doc )  
                      VALUES ( '".$_SESSION["proc_edit_id"]."',   
                               '".$_POST["c_name"]."',   
                               '".$_POST["e_name"]."',   
                               '".$_POST["d_birth"]."',   
                               '".$_POST["sex"]."',   
                               '".$_POST["d_join"]."',   
                               '".$_POST["marriage_cd"]."',   
                               '".$_POST["passport"]."',
                               '".$_POST["n_cd"]."',    
                               '".$_POST["root_addr"]."',   
                               '".$_POST["now_addr"]."',   
                               '".$_POST["phone"]."',   
                               '".$_POST["phone2"]."',   
                               '".$_POST["pem_addr"]."',   
                               '".$_POST["intancy_per"]."',
                               '".$_POST["relationship"]."',
                               '".$_POST["intancy_tel"]."',   
                               '".$_POST["intancy_tel_2"]."',   
                               '".$_POST["disable_cd"]."',   
                               '".$_POST["disable_con"]."',   
                               '".$_POST["abor_dist"]."',   
                               '".$_POST["abor_cd"]."',   
                               '".$_POST["loan_remark"]."',   
                               '".$_POST["kind_cd"]."',   
                               '".$_POST["service_cd"]."',   
                               '".$_POST["rank_cd"]."',   
                               '".$_POST["mil_subj_cd"]."',   
                               '".$_POST["d_mil_start"]."',   
                               '".$_POST["d_mil_end"]."',   
                               '".$_POST["mil_dis_doc"]."' )   ";
                        if(pg_query($sql)){
                            $init_html="資料更新成功，請返回主選單";
                        }else
                            $init_html="操作失敗(2)，請聯絡系統管理員";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";           
        break;
        
        case "p02":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtedu_bg WHERE h0xtedu_bg.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $sql="  INSERT INTO h0xtedu_bg  
                                         ( staff_cd,   
                                         edu_bg_d_end,   
                                         specialty_cd,   
                                         edu_deg_cd,   
                                         edu_grp_cd,   
                                         edu_dept,   
                                         edu_school,   
                                         edu_bg_d_start,   
                                         edu_status,   
                                         specialty_cd1,   
                                         specialty_cd2,   
                                         edu_nation,   
                                         is_edu,   
                                         edu_doc  )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["edu_bg_d_end--".$i]."',   
                                           '".$_POST["specialty_cd--".$i]."',   
                                           '".$_POST["edu_deg_cd--".$i]."',   
                                           '".$_POST["edu_grp_cd--".$i]."',   
                                           '".$_POST["edu_dept--".$i]."',   
                                           '".$_POST["edu_school--".$i]."',   
                                           '".$_POST["edu_bg_d_start--".$i]."',
                                           '".$_POST["edu_status--".$i]."',    
                                           '".$_POST["specialty_cd1--".$i]."',   
                                           '".$_POST["specialty_cd2--".$i]."',   
                                           '".$_POST["edu_nation--".$i]."',   
                                           '".$_POST["is_edu--".$i]."',   
                                           '".$_POST["edu_doc--".$i]."' )   ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;
        
        case "p03":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtfamily WHERE h0xtfamily.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $sql="  INSERT INTO h0xtfamily  
                                         ( staff_cd,   
                                         trelation_cd,   
                                         d_birth,   
                                         id,   
                                         family_name,   
                                         occupation,   
                                         passport,   
                                         cd,   
                                         resident  )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["trelation_cd--".$i]."',   
                                           '".$_POST["d_birth--".$i]."',   
                                           '".$_POST["id--".$i]."',   
                                           '".$_POST["family_name--".$i]."',   
                                           '".$_POST["occupation--".$i]."',   
                                           '".$_POST["passport--".$i]."',   
                                           '".$_POST["cd--".$i]."',
                                           '".$_POST["resident--".$i]."' )   ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;
        
        case "p04":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtprof_qual WHERE h0xtprof_qual.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $sql="  INSERT INTO h0xtprof_qual  
                                         ( staff_cd,   
                                         qual_dist,
                                         d_qual,     
                                         qual_title,   
                                         qual_school,   
                                         teach_doc,   
                                         d_salary_start  )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["qual_dist--".$i]."',
                                           '".$_POST["d_qual--".$i]."',      
                                           '".$_POST["qual_title--".$i]."',   
                                           '".$_POST["qual_school--".$i]."',   
                                           '".$_POST["teach_doc--".$i]."',   
                                           '".$_POST["d_salary_start--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;
        
        case "p05":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtskill_per WHERE h0xtskill_per.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $sql="  INSERT INTO h0xtskill_per  
                                         ( staff_cd,   
                                         skill_cd,   
                                         doc_name,   
                                         d_effect,   
                                         doc,   
                                         validate_orga,   
                                         skill_desc   )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["skill_cd--".$i]."',   
                                           '".$_POST["doc_name--".$i]."',   
                                           '".$_POST["d_effect--".$i]."',   
                                           '".$_POST["doc--".$i]."',   
                                           '".$_POST["validate_orga--".$i]."',   
                                           '".$_POST["skill_desc--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;
        
        case "p06":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtlanguage WHERE h0xtlanguage.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $sql="  INSERT INTO h0xtlanguage  
                                         ( staff_cd,   
                                         language_cd,   
                                         l_speak,   
                                         l_write,   
                                         translate,   
                                         l_listen,   
                                         l_read    )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["language_cd--".$i]."',   
                                           '".$_POST["l_speak--".$i]."',   
                                           '".$_POST["l_write--".$i]."',   
                                           '".$_POST["translate--".$i]."',   
                                           '".$_POST["l_listen--".$i]."',   
                                           '".$_POST["l_read--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;

        case "p07":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtexam WHERE h0xtexam.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $sql="  INSERT INTO h0xtexam  
                                         ( staff_cd,   
                                         group_cd,   
                                         group_cl_cd,   
                                         class_cd,   
                                         kind_cd,   
                                         t_year,   
                                         exam_dist,   
                                         orga,   
                                         doc,   
                                         accept_grade,   
                                         effect_date     )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["group_cd--".$i]."',   
                                           '".$_POST["group_cl_cd--".$i]."',   
                                           '".$_POST["class_cd--".$i]."',   
                                           '".$_POST["kind_cd--".$i]."',   
                                           '".$_POST["t_year--".$i]."',
                                           '".$_POST["exam_dist--".$i]."',   
                                           '".$_POST["orga--".$i]."',   
                                           '".$_POST["doc--".$i]."',   
                                           '".$_POST["accept_grade--".$i]."',   
                                           '".$_POST["effect_date--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;
        
        case "p08_01":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtstaff_study_train WHERE h0xtstaff_study_train.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $hours_points=($_POST["hours_points--".$i]=="")?"null":$_POST["hours_points--".$i];
                        $sql="  INSERT INTO h0xtstaff_study_train  
                                         ( staff_cd,   
                                             dist,   
                                             d_start,   
                                             d_end,
                                             torga_cd,   
                                             how,   
                                             orga,   
                                             class,   
                                             degree,   
                                             country_hf,   
                                             phase,   
                                             hours_points,   
                                             doc      )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["dist--".$i]."',   
                                           '".$_POST["d_start--".$i]."',   
                                           '".$_POST["d_end--".$i]."',
                                           '".$_POST["torga_cd--".$i]."',   
                                           '".$_POST["how--".$i]."',   
                                           '".$_POST["orga--".$i]."',
                                           '".$_POST["class--".$i]."',   
                                           '".$_POST["degree--".$i]."',   
                                           '".$_POST["country_hf--".$i]."',   
                                           '".$_POST["phase--".$i]."',   
                                           ".$hours_points.",
                                           '".$_POST["doc--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;        
        
        case "p08_02":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtprof_study WHERE h0xtprof_study.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $sql="  INSERT INTO h0xtprof_study  
                                         ( staff_cd,   
                                         dist,   
                                         country_hf,   
                                         n_cd,   
                                         d_ok_start,   
                                         d_study_end_actual,   
                                         subs_orga,   
                                         school,   
                                         project_name,   
                                         doc   )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["dist--".$i]."',   
                                           '".$_POST["country_hf--".$i]."',   
                                           '".$_POST["n_cd--".$i]."',   
                                           '".$_POST["d_ok_start--".$i]."',   
                                           '".$_POST["d_study_end_actual--".$i]."',
                                           '".$_POST["subs_orga--".$i]."',   
                                           '".$_POST["school--".$i]."',   
                                           '".$_POST["project_name--".$i]."',   
                                           '".$_POST["doc--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;        
        
        case "p09":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtreward WHERE h0xtreward.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $result_times=($_POST["result_times--".$i]=="") ? 'null':$_POST["result_times--".$i];
                        $sql="  INSERT INTO h0xtreward  
                                         ( staff_cd,   
                                             d_rew,   
                                             dist,   
                                             cd,   
                                             content,   
                                             result_cd,   
                                             result_times,   
                                             doc,   
                                             doc_no    )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["d_rew--".$i]."',   
                                           '".$_POST["dist--".$i]."',   
                                           '".$_POST["cd--".$i]."',   
                                           '".$_POST["content--".$i]."',   
                                           '".$_POST["result_cd--".$i]."',
                                           ".$result_times.",   
                                           '".$_POST["doc--".$i]."',   
                                           '".$_POST["doc_no--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;
        
        case "p10":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtchange_qual WHERE h0xtchange_qual.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $result_times=($_POST["result_times--".$i]=="") ? 'null':$_POST["result_times--".$i];
                        $s_no=sprintf("%03d",$i);
                        $sql="  INSERT INTO h0xtchange_qual  
                                         ( staff_cd,
                                         s_no,   
                                         d_start,   
                                         d_end,   
                                         torga_cd,
                                         unit_cd,   
                                         title_cd,
                                         pub_cd,
                                         duty_cd,
                                         boss_level,   
                                         doc,
                                         end_doc,   
                                         out_reason_cd,   
                                         qual_doc,   
                                         qual_cd,   
                                         pub_qual_cd,   
                                         lev,   
                                         point,   
                                         d_execute )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$s_no."',
                                           '".$_POST["d_start--".$i]."',   
                                           '".$_POST["d_end--".$i]."',   
                                           '".$_POST["torga_cd--".$i]."',
                                           '".$_POST["unit_cd--".$i]."',   
                                           '".$_POST["title_cd--".$i]."',
                                           '".$_POST["pub_cd--".$i]."',   
                                           '".$_POST["duty_cd--".$i]."',
                                           '".$_POST["boss_level--".$i]."',
                                           '".$_POST["doc--".$i]."',
                                           '".$_POST["end_doc--".$i]."',                                              
                                           '".$_POST["out_reason_cd--".$i]."',   
                                           '".$_POST["qual_doc--".$i]."',
                                           '".$_POST["qual_cd--".$i]."',   
                                           '".$_POST["pub_qual_cd--".$i]."',
                                           '".$_POST["lev--".$i]."',   
                                           '".$_POST["point--".$i]."',   
                                           '".$_POST["d_execute--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;        
               
        case "p11":
            //var_dump($_POST);
            if(isset($_POST["total_rows"])){
                if(pg_query("DELETE FROM h0xtstaff_eval WHERE h0xtstaff_eval.staff_cd = '".$_SESSION["proc_edit_id"]."' ")){
                    
                    for($i=1,$x=(int)($_POST["total_rows"]);$i<=$x;$i++){
                        $second_scop=($_POST["second_scop--".$i]==null) ? 'null':$_POST["second_scop--".$i];
                        $sql="  INSERT INTO h0xtstaff_eval  
                                         ( staff_cd,   
                                         d_eval,   
                                         eval_type,   
                                         eval_section,   
                                         second_scop,   
                                         cd,   
                                         doc )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$_POST["d_eval--".$i]."',   
                                           '".$_POST["eval_type--".$i]."',   
                                           '".$_POST["eval_section--".$i]."',   
                                           ".$second_scop.",   
                                           '".$_POST["cd--".$i]."',
                                           '".$_POST["doc--".$i]."' ) ";
                        if(pg_query($sql)){
                            continue;
                        }else{
                            $init_html.="操作失敗(2)，請聯絡系統管理員";
                            break;
                        }
                    }
                    if($i>$x)
                        $init_html="資料更新成功，請返回主選單";
                }else
                    $init_html="操作失敗(1)，請聯絡系統管理員";    
            }else
                $init_html="錯誤的要求，請聯絡系統管理員";
        break;
		
		case "p13":

                if(pg_query("DELETE FROM h0xt_autobiography_rec WHERE h0xt_autobiography_rec.staff_cd='".$_SESSION["proc_edit_id"]."'")){
						 $sql="  INSERT INTO h0xt_autobiography_rec  
                                       ( staff_cd,   
                                         des_01,   
                                         des_02,  
                                         des_03,  
                                         des_04,  
                                         des_05,  
                                         des_06,  
                                         des_07,  
                                         des_08,  
                                         des_09,  
                                         des_10,  
                                         des_11,  
                                         des_12,  
                                         des_13,  
                                         des_14  
                                         )  
                                  VALUES ( '".$_SESSION["proc_edit_id"]."',   
                                           '".$desarray[0]."',   
                                           '".$desarray[1]."',   
                                           '".$desarray[2]."',   
                                           '".$desarray[3]."',   
                                           '".$desarray[4]."',   
                                           '".$desarray[5]."',   
                                           '".$desarray[6]."',   
                                           '".$desarray[7]."',   
                                           '".$desarray[8]."',   
                                           '".$desarray[9]."',   
                                           '".$desarray[10]."',   
                                           '".$desarray[11]."',   
                                           '".$desarray[12]."',     
										   '".$desarray[13]."' ) ";	

                        if(pg_query($sql)){
                            
							$init_html="1:資料更新成功，請返回主選單";
							
                        }else
                            $init_html="2:操作失敗(2)，請聯絡系統管理員";
                }else
                    $init_html="3:操作失敗(1)，請聯絡系統管理員";           
        break;
		
	
               
        default:
            $init_html="錯誤的要求";
    }
    
    
}else
    $init_html="錯誤的要求";


echo $init_html;
?>