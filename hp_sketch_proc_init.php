<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
//include_once("inc/conn.php");
include_once("inc/conn.php");
if( $_GET["init"] == "Y" || ($_POST["ajax"] == "Y" && $_POST["init"] == "Y") ){
    $sql="DELETE FROM h0xtbasic_per WHERE h0xtbasic_per.staff_cd = '".$_SESSION["proc_edit_id"]."'";
    if(pg_query($sql)){
        $sql="SELECT h0btbasic_per.staff_cd,
                    h0btbasic_per.c_name,
                    h0btbasic_per.e_name,
                    h0btbasic_per.d_birth,
                    h0btbasic_per.sex,
                    h0btbasic_per.d_join,
                    h0btbasic_per.marriage_cd,
                    h0btbasic_per.passport,
                    h0btbasic_per.n_cd,
                    h0btbasic_per.root_addr,
                    h0btbasic_per.now_addr,
                    h0btbasic_per.phone,
                    h0btbasic_per.phone2,
                    h0btbasic_per.pem_addr,
                    h0btbasic_per.instancy_per,
                    h0btbasic_per.relationship,
                    h0btbasic_per.instancy_tel,
                    h0btbasic_per.instancy_tel_2,
                    h0btbasic_per.disable_cd,
                    h0btbasic_per.disable_con,
                    h0btbasic_per.abor_dist,
                    h0btbasic_per.abor_cd,
                    h0btbasic_per.loan_remark,
                    h0btbasic_per.kind_cd,
                    h0btbasic_per.service_cd,
                    h0btbasic_per.rank_cd,
                    h0btbasic_per.mil_subj_cd,
                    h0btbasic_per.d_mil_end,
                    h0btbasic_per.d_mil_start,
                    h0btbasic_per.mil_dis_doc,
                    h0btbasic_per.dist_cd
               FROM h0btbasic_per WHERE h0btbasic_per.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
            $sql="  INSERT INTO h0xtbasic_per  
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
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->c_name."',   
                               '".$obj->e_name."',   
                               '".$obj->d_birth."',   
                               '".$obj->sex."',   
                               '".$obj->d_join."',   
                               '".$obj->marriage_cd."',   
                               '".$obj->passport."',
                               '".$obj->n_cd."',    
                               '".$obj->root_addr."',   
                               '".$obj->now_addr."',   
                               '".$obj->phone."',   
                               '".$obj->phone2."',   
                               '".$obj->pem_addr."',   
                               '".$obj->instancy_per."',
                               '".$obj->relationship."',
                               '".$obj->instancy_tel."',   
                               '".$obj->instancy_tel_2."',   
                               '".$obj->disable_cd."',   
                               '".$obj->disable_con."',   
                               '".$obj->abor_dist."',   
                               '".$obj->abor_cd."',   
                               '".$obj->loan_remark."',   
                               '".$obj->kind_cd."',   
                               '".$obj->service_cd."',   
                               '".$obj->rank_cd."',   
                               '".$obj->mil_subj_cd."',   
                               '".$obj->d_mil_start."',   
                               '".$obj->d_mil_end."',   
                               '".$obj->mil_dis_doc."' )   ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-1)，請聯絡系統管理員</p>";
                break;
            }
        }
        //dist_cd
        $dist_cd=$obj->dist_cd;
        
        $sql="DELETE FROM h0xtedu_bg WHERE h0xtedu_bg.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $sql="SELECT h0btedu_bg.staff_cd,   
                     h0btedu_bg.edu_bg_d_end,   
                     h0btedu_bg.specialty_cd,   
                     h0btedu_bg.edu_deg_cd,   
                     h0btedu_bg.edu_grp_cd,   
                     h0btedu_bg.edu_dept,   
                     h0btedu_bg.edu_school,   
                     h0btedu_bg.edu_bg_d_start,   
                     h0btedu_bg.edu_status,   
                     h0btedu_bg.specialty_cd1,   
                     h0btedu_bg.specialty_cd2,   
                     h0btedu_bg.edu_nation,   
                     h0btedu_bg.is_edu,   
                     h0btedu_bg.edu_doc  
                FROM h0btedu_bg  
               WHERE h0btedu_bg.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
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
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->edu_bg_d_end."',   
                               '".$obj->specialty_cd."',   
                               '".$obj->edu_deg_cd."',   
                               '".$obj->edu_grp_cd."',   
                               '".$obj->edu_dept."',   
                               '".$obj->edu_school."',   
                               '".$obj->edu_bg_d_start."',
                               '".$obj->edu_status."',    
                               '".$obj->specialty_cd1."',   
                               '".$obj->specialty_cd2."',   
                               '".$obj->edu_nation."',   
                               '".$obj->is_edu."',   
                               '".$obj->edu_doc."' )   ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-2)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        $sql="DELETE FROM h0xtfamily WHERE h0xtfamily.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $sql="SELECT h0btfamily.staff_cd,   
                     h0btfamily.trelation_cd,   
                     h0btfamily.d_birth,   
                     h0btfamily.id,   
                     h0btfamily.family_name,   
                     h0btfamily.occupation,   
                     h0btfamily.passport,   
                     h0btfamily.cd,   
                     h0btfamily.resident  
                FROM h0btfamily  
               WHERE h0btfamily.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
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
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->trelation_cd."',   
                               '".$obj->d_birth."',   
                               '".$obj->id."',   
                               '".$obj->family_name."',   
                               '".$obj->occupation."',   
                               '".$obj->passport."',   
                               '".$obj->cd."',
                               '".$obj->resident."' )   ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-3)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        $sql="DELETE FROM h0xtprof_qual WHERE h0xtprof_qual.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $sql="SELECT h0etprof_qual.staff_cd,   
                     h0etprof_qual.qual_dist,
                     h0etprof_qual.d_qual,   
                     h0etprof_qual.qual_type,   
                     h0etprof_qual.qual_title,   
                     h0etprof_qual.qual_school,   
                     h0etprof_qual.teach_doc,   
                     h0etprof_qual.d_salary_start  
                FROM h0etprof_qual  
               WHERE h0etprof_qual.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
            $sql="  INSERT INTO h0xtprof_qual  
                             ( staff_cd,   
                             qual_dist,
                             d_qual,     
                             qual_title,   
                             qual_school,   
                             teach_doc,   
                             d_salary_start  )  
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->qual_dist."',
                               '".$obj->d_qual."',      
                               '".$obj->qual_title."',   
                               '".$obj->qual_school."',   
                               '".$obj->teach_doc."',   
                               '".$obj->d_salary_start."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-4)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        $sql="DELETE FROM h0xtskill_per WHERE h0xtskill_per.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $sql="SELECT h0btskill_per.staff_cd,   
                     h0btskill_per.skill_cd,   
                     h0btskill_per.doc_name,   
                     h0btskill_per.d_effect,   
                     h0btskill_per.doc,   
                     h0btskill_per.validate_orga,   
                     h0btskill_per.skill_desc  
                FROM h0btskill_per  
               WHERE h0btskill_per.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
            $sql="  INSERT INTO h0xtskill_per  
                             ( staff_cd,   
                             skill_cd,   
                             doc_name,   
                             d_effect,   
                             doc,   
                             validate_orga,   
                             skill_desc   )  
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->skill_cd."',   
                               '".$obj->doc_name."',   
                               '".$obj->d_effect."',   
                               '".$obj->doc."',   
                               '".$obj->validate_orga."',   
                               '".$obj->skill_desc."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-5)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        $sql="DELETE FROM h0xtlanguage WHERE h0xtlanguage.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $sql="SELECT  h0btlanguage.staff_cd,   
                         h0btlanguage.language_cd,   
                         h0btlanguage.l_speak,   
                         h0btlanguage.l_write,   
                         h0btlanguage.translate,   
                         h0btlanguage.l_listen,   
                         h0btlanguage.l_read  
                    FROM h0btlanguage  
                   WHERE h0btlanguage.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
            $sql="  INSERT INTO h0xtlanguage  
                             ( staff_cd,   
                             language_cd,   
                             l_speak,   
                             l_write,   
                             translate,   
                             l_listen,   
                             l_read    )  
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->language_cd."',   
                               '".$obj->l_speak."',   
                               '".$obj->l_write."',   
                               '".$obj->translate."',   
                               '".$obj->l_listen."',   
                               '".$obj->l_read."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-6)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        $sql="DELETE FROM h0xtexam WHERE h0xtexam.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $sql="SELECT  h0btexam.staff_cd,   
                     h0btexam.group_cd,   
                     h0btexam.group_cl_cd,   
                     h0btexam.class_cd,   
                     h0btexam.kind_cd,   
                     h0btexam.t_year,   
                     h0btexam.exam_dist,   
                     h0btexam.orga,   
                     h0btexam.doc,   
                     h0btexam.accept_grade,   
                     h0btexam.effect_date  
                FROM h0btexam  
               WHERE h0btexam.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
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
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->group_cd."',   
                               '".$obj->group_cl_cd."',   
                               '".$obj->class_cd."',   
                               '".$obj->kind_cd."',   
                               '".$obj->t_year."',
                               '".$obj->exam_dist."',   
                               '".$obj->orga."',   
                               '".$obj->doc."',   
                               '".$obj->accept_grade."',   
                               '".$obj->effect_date."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-7)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        if($dist_cd!="TEA"){
            $sql="DELETE FROM h0xtstaff_study_train WHERE h0xtstaff_study_train.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
            $result=pg_query($sql);
            $sql="SELECT h0ttstaff_study.staff_cd,   
                         h0ttstaff_study.dist,   
                         h0ttstaff_study.d_start,   
                         h0ttstaff_study.d_end,   
                         h0ttstaff_study.how,   
                         h0ttstaff_study.orga,   
                         h0ttstaff_study.class,   
                         h0ttstaff_study.degree,   
                         h0ttstaff_study.country_hf,   
                         h0ttstaff_study.phase,   
                         h0ttstaff_study.hours_points,   
                         h0ttstaff_study.doc  
                    FROM h0ttstaff_study  
                   WHERE h0ttstaff_study.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
            $result=pg_query($sql);
            while($obj=pg_fetch_object($result)){
                $hours_points=($obj->hours_points==null) ? 'null':$obj->hours_points;
                $sql="  INSERT INTO h0xtstaff_study_train  
                                 ( staff_cd,   
                                     dist,   
                                     d_start,   
                                     d_end,   
                                     how,   
                                     orga,   
                                     class,   
                                     degree,   
                                     country_hf,   
                                     phase,   
                                     hours_points,   
                                     doc      )  
                          VALUES ( '".$obj->staff_cd."',   
                                   '".$obj->dist."',   
                                   '".$obj->d_start."',   
                                   '".$obj->d_end."',   
                                   '".$obj->how."',   
                                   '".$obj->orga."',
                                   '".$obj->class."',   
                                   '".$obj->degree."',   
                                   '".$obj->country_hf."',   
                                   '".$obj->phase."',   
                                   ".$obj->hours_points.",
                                   '".$obj->doc."' ) ";
                if(pg_query($sql)){
                    continue;
                }else{
                    $init_html.="<p>無法進行初始化(1-8-1-1)，請聯絡系統管理員</p>";
                    break;
                }
            }
            
            $sql="SELECT h0ttout_train.staff_cd,   
                         h0ttout_train.torga_cd,   
                         h0ttout_train.class,   
                         h0ttout_train.d_start,   
                         h0ttout_train.d_end,   
                         h0ttout_train.country_hf,   
                         h0ttout_train.how,   
                         h0ttout_train.phase,   
                         h0ttout_train.train_hours,   
                         h0ttout_train.doc  
                    FROM h0ttout_train  
                   WHERE h0ttout_train.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
            $result=pg_query($sql);
            while($obj=pg_fetch_object($result)){
                $hours_points=($obj->train_hours==null) ? 'null':$obj->hours_points;
                $sql="  INSERT INTO h0xtstaff_study_train  
                                 ( staff_cd,   
                                 torga_cd,   
                                 class,   
                                 d_start,   
                                 d_end,   
                                 country_hf,   
                                 how,   
                                 phase,   
                                 hours_points,   
                                 doc,
                                 dist,
                                 degree )  
                          VALUES ( '".$obj->staff_cd."',   
                                   '".$obj->torga_cd."',   
                                   '".$obj->class."',   
                                   '".$obj->d_start."',   
                                   '".$obj->d_end."',   
                                   '".$obj->country_hf."',
                                   '".$obj->how."',   
                                   '".$obj->phase."',   
                                   ".$obj->train_hours.",   
                                   '".$obj->doc."',   
                                   '3',
                                   '0' ) ";
                if(pg_query($sql)){
                    continue;
                }else{
                    $init_html.="<p>無法進行初始化(1-8-1-2)，請聯絡系統管理員</p>";
                    break;
                }
            }
            
        }else if($dist_cd=="TEA"){
            $sql="DELETE FROM h0xtprof_study WHERE h0xtprof_study.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
            $result=pg_query($sql);
            $sql="SELECT h0ttprof_study.staff_cd,   
                         h0ttprof_study.dist,   
                         h0ttprof_study.country_hf,   
                         h0ttprof_study.n_cd,   
                         h0ttprof_study.d_ok_start,   
                         h0ttprof_study.d_study_end_actual,   
                         h0ttprof_study.subs_orga,   
                         h0ttprof_study.school,   
                         h0ttprof_study.project_name,   
                         h0ttprof_study.doc  
                    FROM h0ttprof_study  
                    WHERE h0ttprof_study.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
            $result=pg_query($sql);
            while($obj=pg_fetch_object($result)){
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
                          VALUES ( '".$obj->staff_cd."',   
                                   '".$obj->dist."',   
                                   '".$obj->country_hf."',   
                                   '".$obj->n_cd."',   
                                   '".$obj->d_ok_start."',   
                                   '".$obj->d_study_end_actual."',
                                   '".$obj->subs_orga."',   
                                   '".$obj->school."',   
                                   '".$obj->project_name."',   
                                   '".$obj->doc."' ) ";
                if(pg_query($sql)){
                    continue;
                }else{
                    $init_html.="<p>無法進行初始化(1-8-2)，請聯絡系統管理員</p>";
                    break;
                }
            }           
        }else{
            $init_html.="<p>無法進行初始化(1-8, dist_cd: ".$dist_cd.")，請聯絡系統管理員</p>";
        }
        
        $sql="DELETE FROM h0xtreward WHERE h0xtreward.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $sql="SELECT h0vtreward.staff_cd,   
                     h0vtreward.d_rew,   
                     h0vtreward.dist,   
                     h0vtreward.cd,   
                     h0vtreward.content,   
                     h0vtreward.result_cd,   
                     h0vtreward.result_times,   
                     h0vtreward.d_data,   
                     h0vtreward.doc  
                FROM h0vtreward  
               WHERE h0vtreward.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
            $result_times=($obj->result_times==null) ? 'null':$obj->result_times;
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
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->d_rew."',   
                               '".$obj->dist."',   
                               '".$obj->cd."',   
                               '".$obj->content."',   
                               '".$obj->result_cd."',
                               ".$result_times.",   
                               '".$obj->doc."',   
                               '".$obj->d_data."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-9)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        //1-10 h0xtchange_qual.s_no(pk)需要有值
        $sql="DELETE FROM h0xtchange_qual WHERE h0xtchange_qual.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $tt=0;
        $s_no=sprintf("%03d",0);
        $sql="SELECT DISTINCT h0bthistory.staff_cd,   
                             h0bthistory.d_start,   
                             h0bthistory.d_end,   
                             h0bthistory.torga_cd,   
                             h0rttilte_.title_cd,
                             h0bthistory.duty_cd,   
                             h0bthistory.clerk_doc,   
                             h0bthistory.out_reason,   
                             h0btappoint.appoint_doc,   
                             h0btappoint.audit_result,   
                             h0btappoint.rank_cd,   
                             h0btappoint.lev,   
                             h0btappoint.point_check,   
                             h0btappoint.d_doc  
                      FROM h0bthistory
                      RIGHT OUTER JOIN h0btappoint on( h0btappoint.staff_cd=h0bthistory.staff_cd)
                      RIGHT OUTER JOIN h0btappoint on( h0btappoint.d_start=h0bthistory.d_start) 
                      RIGHT OUTER JOIN h0rttilte_ on( h0rttilte_.put_title_cd=h0bthistory.pub_title_cd)                          
                   WHERE( h0bthistory.staff_cd = '".$_SESSION["proc_edit_id"]."' ) ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
            $tt++;
            $s_no=sprintf("%03d",$tt);
            $sql="  INSERT INTO h0xtchange_qual  
                             ( staff_cd,
                             s_no,   
                             d_start,   
                             d_end,   
                             torga_cd,   
                             title_cd,
                             duty_cd,   
                             doc,   
                             out_reason_cd,   
                             qual_doc,   
                             qual_cd,   
                             pub_qual_cd,   
                             lev,   
                             point,   
                             d_execute )  
                      VALUES ( '".$obj->staff_cd."',
                               '".$s_no."',   
                               '".$obj->d_start."',   
                               '".$obj->d_end."',   
                               '".$obj->torga_cd."',   
                               '".$obj->title_cd."',   
                               '".$obj->duty_cd."',
                               '".$obj->clerk_doc."',   
                               '".$obj->out_reason."',   
                               '".$obj->appoint_doc."',
                               '".$obj->audit_result."',   
                               '".$obj->rank_cd."',
                               '".$obj->lev."',   
                               '".$obj->point_check."',   
                               '".$obj->d_doc."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-10-1)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        $sql="SELECT DISTINCT h0etchange.staff_cd,   
                     h0etchange.d_start,   
                     h0etchange.d_end,   
                     '309310000Q' torga_cd,   
                     h0etchange.dist_cd,
                     h0etchange.unit_cd,   
                     h0etchange.title_cd,   
                     h0etchange.pub_cd,   
                     h0etchange.duty_cd,   
                     h0etchange.doc,   
                     h0etchange.out_reason,   
                     h0etstaff_qual.qual_doc,   
                     h0etstaff_qual.qual_result,   
                     h0etstaff_qual.rank_cd,   
                     h0etstaff_qual.lev,   
                     h0etstaff_qual.point_base,   
                     COALESCE(h0etstaff_qual.d_doc,'0000000') d_doc  
                FROM h0etchange 
                LEFT OUTER JOIN h0etstaff_qual on(h0etchange.staff_cd = h0etstaff_qual.staff_cd)
                LEFT OUTER JOIN h0etstaff_qual on(h0etchange.d_start = h0etstaff_qual.d_work)
               WHERE ( h0etchange.staff_cd = '".$_SESSION["proc_edit_id"]."' )";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
            $tt++;
            $s_no=sprintf("%03d",$tt);
            $sql="  INSERT INTO h0xtchange_qual  
                             ( staff_cd,   
                             s_no,
                             d_start,   
                             d_end,
                             dist_cd,   
                             torga_cd,
                             unit_cd,   
                             title_cd,
                             pub_cd,
                             duty_cd,   
                             doc,   
                             out_reason_cd,   
                             qual_doc,   
                             qual_cd,   
                             pub_qual_cd,   
                             lev,   
                             point,   
                             d_execute )  
                      VALUES ( '".$obj->staff_cd."',
                               '".$s_no."',
                               '".$obj->d_start."',   
                               '".$obj->d_end."',
                               '".$obj->dist_cd."',   
                               '".$obj->torga_cd."',
                               '".$obj->unit_cd."',   
                               '".$obj->title_cd."',
                               '".$obj->pub_cd."',   
                               '".$obj->duty_cd."',
                               '".$obj->doc."',   
                               '".$obj->out_reason."',   
                               '".$obj->qual_doc."',
                               '".$obj->qual_result."',   
                               '".$obj->rank_cd."',
                               '".$obj->lev."',   
                               '".$obj->point_base."',   
                               '".$obj->d_doc."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-10-2)，請聯絡系統管理員</p>";
                break;
            }
        }
        
        $sql="DELETE FROM h0xtstaff_eval WHERE h0xtstaff_eval.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        $sql="SELECT h0vtstaff_eval.staff_cd,   
                     h0vtstaff_eval.d_eval,   
                     h0vtstaff_eval.eval_type,   
                     h0vtstaff_eval.eval_section,
                     h0vtstaff_eval.second_eval,   
                     h0vtstaff_eval.second_scop,   
                     h0vtstaff_eval.cd,   
                     h0vtstaff_eval.doc  
                FROM h0vtstaff_eval  
               WHERE h0vtstaff_eval.staff_cd = '".$_SESSION["proc_edit_id"]."' 
            
            union  

              SELECT h0vtstaff_eval_pa.staff_cd,   
                     h0vtstaff_eval_pa.d_eval,   
                     h0vtstaff_eval_pa.eval_type,   
                     h0vtstaff_eval_pa.eval_section,
                     h0vtstaff_eval_pa.second_eval,   
                     h0vtstaff_eval_pa.second_scop,   
                     h0vtstaff_eval_pa.cd,   
                     h0vtstaff_eval_pa.doc  
                FROM h0vtstaff_eval_pa  
               WHERE h0vtstaff_eval_pa.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
            $second_scop=($obj->second_scop==null) ? 'null':$obj->second_scop;
            $sql="  INSERT INTO h0xtstaff_eval  
                             ( staff_cd,   
                             d_eval,   
                             eval_type,   
                             eval_section,   
                             second_scop,
                             second_eval,   
                             cd,   
                             doc )  
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->d_eval."',   
                               '".$obj->eval_type."',   
                               '".$obj->eval_section."',   
                               ".$second_scop.", 
                               '".$obj->second_eval."',  
                               '".$obj->cd."',
                               '".$obj->doc."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-11)，請聯絡系統管理員</p>";
                break;
            }
        }
		$sql="DELETE FROM h0xt_autobiography_rec WHERE h0xt_autobiography_rec.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
		$sql="SELECT 
				h0bt_autobiography_rec.staff_cd,
				h0bt_autobiography_rec.des_01,
				h0bt_autobiography_rec.des_02,
				h0bt_autobiography_rec.des_03,
				h0bt_autobiography_rec.des_04,
				h0bt_autobiography_rec.des_05,
				h0bt_autobiography_rec.des_06,
				h0bt_autobiography_rec.des_07,
				h0bt_autobiography_rec.des_08,
				h0bt_autobiography_rec.des_09,
				h0bt_autobiography_rec.des_10,
				h0bt_autobiography_rec.des_11,
				h0bt_autobiography_rec.des_12,
				h0bt_autobiography_rec.des_13,
				h0bt_autobiography_rec.des_14
		
              FROM h0bt_autobiography_rec  
              WHERE h0bt_autobiography_rec.staff_cd = '".$_SESSION["proc_edit_id"]."' ";
        $result=pg_query($sql);
        while($obj=pg_fetch_object($result)){
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
                             des_14 )  
                      VALUES ( '".$obj->staff_cd."',   
                               '".$obj->des_01."',   
                               '".$obj->des_02."',   
                               '".$obj->des_03."',   
                               '".$obj->des_04."',   
                               '".$obj->des_05."',   
                               '".$obj->des_06."',   
                               '".$obj->des_07."',   
                               '".$obj->des_08."',   
                               '".$obj->des_09."',   
                               '".$obj->des_10."',   
                               '".$obj->des_11."',   
                               '".$obj->des_12."',   
                               '".$obj->des_13."',   
                               '".$obj->des_14."' ) ";
            if(pg_query($sql)){
                continue;
            }else{
                $init_html.="<p>無法進行初始化(1-12)，請聯絡系統管理員</p>";
                break;
            }
        }
        
    }else{
        $init_html="<p>無法進行初始化(2,".$_SESSION["proc_edit_id"].")，請聯絡系統管理員</p>";
    }
    $init_html.="<p>已完成初始化作業，請返回主選單以開始進行履歷資料的維護</p>";
}else{
    $init_html=<<<HTML
        <p><b><font size="4px">履歷資料初始作業</font></b></p><br />
        <p>&nbsp;&nbsp;&nbsp;&nbsp;若個人尚未有正式之履歷資料，此作業將新增記錄供個人填寫自己的履歷資料。</p><br />
        <p>&nbsp;&nbsp;&nbsp;&nbsp;如果本校已有您個人的正式履歷資料，此作業將複製個人正式履歷表中各項資料，供個人修改。</p><br />
        <p>&nbsp;&nbsp;&nbsp;&nbsp;若履歷資料已完成填寫尚在等待人事單位的核實，此作業將刪除您填寫的各項記錄，而複製已經由人事單位核實的各項資料。</p><br />
        <p>&nbsp;&nbsp;&nbsp;&nbsp;確定要執行您個人履歷資料的初始作業嗎？</p>
        <p>
            <a id="init_y" class="form_button" href="hp_sketch_proc_main.php">
                <span>確定進行資料初始化</span>
            </a>
            <a class="form_button control_" href="hp_sketch_proc_main.php">
                <span>取消並返回功能表</span>
            </a>
            <br /><br />
        </p>
HTML;
}
if($_POST["ajax"]=="Y"){
    echo $init_html;
}
return $init_html;
?>