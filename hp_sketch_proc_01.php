<?php
header("Content-Type:text/html; charset=utf-8");
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
//include_once("inc/conn.php");
include_once("inc/conn.php");
include_once("hp_sketch_proc_lib.php");

    $sql="SELECT * FROM h0xtbasic_per WHERE h0xtbasic_per.staff_cd='".$_SESSION['proc_edit_id']."'";
    if($result=pg_query($sql) or die("error")){
        $obj=pg_fetch_object($result);
        
        foreach($obj as $key=>$value){
            $obj->$key=trim($value);
        }
        
        $sex_o=coh("1:男,2:女",$obj->sex);
        $marriage_cd_o=coh("y:已婚,n:未婚,x:已婚單身",$obj->marriage_cd);
        $disable_con_o=coh("0:無,1:極重度,2:重度,3:中度,4:輕度",$obj->disable_con);
        $abor_dist_o=coh("0:非原住民,1:平地,2:山地",$obj->abor_dist);
        $loan_remark_o=coh("1:曾獲配公教貸款,2:曾配購公教住宅,3:未曾獲配公教貸款或配購公教住宅",$obj->loan_remark);
        
        $n_cd_o=cohs("SELECT * FROM h0rtnation_",$obj->n_cd);
        $disable_cd_o=cohs("SELECT * FROM h0btdiable_",$obj->disable_cd);
        $abor_cd_o=cohs("SELECT * FROM h0btabor_",$obj->abor_cd,"00");
        $kind_cd_o=cohs("SELECT * FROM h0btmil_kind",$obj->kind_cd,"0");
        $service_cd_o=cohs("SELECT * FROM h0btmil_service_",$obj->service_cd,"0");
        $rank_cd_o=cohs("SELECT * FROM h0btmil_rank",$obj->rank_cd,"00");
        $mil_subj_cd_o=cohs("SELECT * FROM h0btmil_subj_",$obj->mil_subj_cd,"00");
        
        $init_html=<<<HTML
          <p><b><font size="4px">個人基本資料</font></b></p>
			<div>
				<form class="proc_form" method="POST">

					<fieldset>
						<div style="background-color:#ddf;">
							<p>
								<label>身分證號碼/統一證號→</label>
								<input type="text" title="身分證號碼/統一證號" name="staff_cd" id="staff_cd" value="{$obj->staff_cd}" readonly="readonly" />
							</p>
							<p>
								<label>中文姓名→</label>
								<input type="text" title="中文姓名" name="c_name" id="c_name" value="{$obj->c_name}" />*
							</p>
							<p>
								<label>英文姓名→</label>
								<input type="text" title="英文姓名" class="validate[optional,custom[onlyLetter]]" name="e_name" id="e_name" maxlength="30" value="{$obj->e_name}" />
							</p>
							<p>
								<label>性別→</label>
								<select name="sex" class="validate[required]" title="性別" id="sex">
									{$sex_o}
								</select>*
								<label>婚姻狀況→</label>
								<select name="marriage_cd" title="婚姻狀況" id="marriage_cd">
									{$marriage_cd_o}
								</select>
							</p>
							<p>
								<label>國籍→</label>
								<select name="n_cd" title="國籍" id="n_cd" class="validate[required]">
									{$n_cd_o}
								</select>
							</p>
							<p>
								<label>護照號碼→</label>
								<input type="text" title="護照號碼" class="validate[optional,custom[noSpecialCaracters]]" name="passport" id="passport" value="{$obj->passport}" />
							</p>
							<p>
								<label>到職日期→</label>
								<input type='text' name="d_join" class="validate[optional,custom[date1]]" title="到職日期" id="d_join" value="{$obj->d_join}" />
							</p>
							<p>
								<label>出生日期→</label>
								<input type='text' name="d_birth" class="validate[optional,custom[date1]]" title="出生日期" id="d_birth" value="{$obj->d_birth}" />
								<br />(日期格式請以民國年輸入，輸入格式為 yyymmdd，如0991231)
							</p>
							<p>
								<label>↓戶籍住所↓</label>
								<input type='text' name="root_addr" title="戶籍住所" id="root_addr" value="{$obj->root_addr}" size="80" />
							</p>
							<p>
								<label>↓現居住所↓</label>
								<input type='text' name="now_addr" title="現居住所" id="now_addr" value="{$obj->now_addr}" size="80" />
							</p>
							<p>
								<label>現居住所電話→</label>
								<input type='text' name="phone" title="現居住所電話" class="validate[optional,custom[telephone]]" id="phone" value="{$obj->phone}" />
								<br/>(請填市話，格式如05-2720411#11111)
							</p>
							<p>
								<label>個人手機號碼→</label>
								<input type='text' name="phone2" class="validate[optional,custom[telephone]]" title="個人手機號碼" id="phone2" value="{$obj->phone2}" />
							</p>
							<p>
								<label>個人E_mail→</label>
								<input type='text' name="pem_addr" class="validate[optional,custom[email]]" title="個人E_mail" id="pem_addr" value="{$obj->pem_addr}" />*
							</p>
							<hr />
							<p>
								<label>緊急聯絡人→</label>
								<input type='text' name="intancy_per" class="validate[required]" title="緊急聯絡人" id="intancy_per" value="{$obj->intancy_per}" />*
							</p>
							<p>
								<label>與緊急聯絡人關係→</label>
								<input type='text' name="relationship" class="validate[required]" title="與緊急聯絡人關係" id="relationship" value="{$obj->relationship}" />*
							</p>
							<p>
								<label>緊急聯絡人電話→</label>
								<input type='text' name="intancy_tel" class="validate[required]" title="緊急聯絡人電話" id="intancy_tel" value="{$obj->intancy_tel}" />*
								<br />(請填市話，格式如05-2720411#11111)
							</p>
							<p>
								<label>緊急聯絡人手機→</label>
								<input type='text' name="intancy_tel_2" class="validate[required]" title="緊急聯絡人手機" id="intancy_tel_2" value="{$obj->intancy_tel_2}" />*
							</p>
							<hr />
							<p>
								<label>身心障礙種類→</label>
								<select name="disable_cd" title="身心障礙種類" id="disable_cd" class="validate[required]">
									{$disable_cd_o}
								</select>
							</p>
							<p>
								<label>身心障礙程度→</label>
								<select name="disable_con" title="身心障礙程度" id="disable_con" class="validate[required]">
									{$disable_con_o}
								</select>
							</p>
							<hr />
							<p>
								<label>原住民身分別→</label>
								<select name="abor_dist" title="原住民身分別" id="abor_dist" class="validate[required]">
									{$abor_dist_o}
								</select>
								<label>原住民族別→</label>
								<select name="abor_cd" class="validate[required]" title="原住民族別" id="abor_cd" class="validate[required]">
									{$abor_cd_o}
								</select>*
							</p>
							<hr />
							<p>
								<label>公教貸款_配購公教住宅註記→</label>
								<select name="loan_remark" title="公教貸款_配購公教住宅註記" id="loan_remark">
									{$loan_remark_o}
								</select>
							</p>
							<hr />
							<p>
								<label>役別→</label>
								<select name="kind_cd" class="validate[required]" title="役別" id="kind_cd">
									{$kind_cd_o}
								</select>*
								<label>軍種→</label>
								<select name="service_cd" class="validate[required]" title="軍種" id="service_cd">
									{$service_cd_o}
								</select>*
							<p/>
							<p>
								<label>軍階→</label>
								<select name="rank_cd" class="validate[required]" title="軍階" id="rank_cd">
									{$rank_cd_o}
								</select>*
								<label>兵科→</label>
								<select name="mil_subj_cd" class="validate[required]" title="兵科" id="mil_subj_cd">
									{$mil_subj_cd_o}
								</select>*
							</p>
							<p>
								<label>兵役期間自</label>
								<input type='text' class="validate[optional,custom[date1]]" name="d_mil_start" title="兵役期間自" id="d_mil_start" value="{$obj->d_mil_start}" />
								<label>至</label>
								<input type='text' class="validate[optional,custom[date1]]" name="d_mil_end" title="至" id="d_mil_end" value="{$obj->d_mil_end}" />
								<br />(日期格式請以民國年輸入，輸入格式為 yyymmdd，如0991231。免服兵役者,兵役期間起迄請填0000000。)
							</p>
							<p>
								<label>退伍令字號→</label>
								<input type='text' name="mil_dis_doc" title="退伍令字號" id="mil_dis_doc" value="{$obj->mil_dis_doc}" />
							</p>
						</div>

						<hr />

						<div id="submit_button">
							<a class='form_button form_sub' id='sub_form'><span>填寫完畢</span></a>
							<a class="form_button control_" href="hp_sketch_proc_main.php">
								<span>取消並返回功能表</span>
							</a>
						</div>
						<div id="confirmbox">
							<h2>請確認</h2>
							<p id="confirm_msg"></p>
							<button id="confirm">確定</button>&nbsp;&nbsp;
							<button class="close">取消</button>
						</div>
						<input type='hidden' name="form_sent" id="form_sent" value="p01" />

					</fieldset>
				</form>
			</div>
        

HTML;
    }

if($_POST["ajax"]=="Y"){
    $init_js=<<<HTML
    <script type='text/javascript'>
		if($("#d_mil_start").attr("value")=='' || $("#d_mil_start").attr("value")=='0'){
			$("#d_mil_start").val("0000000"); 
		}
	
		if($("#d_mil_end").attr("value")=='' || $("#d_mil_end").attr("value")=='0'){
			$("#d_mil_end").val("0000000"); 
		}
		
        if($.browser.msie){
            $("#confirmbox").overlay({
                closeOnClick: false,
                load: false
            });
            $(".close").live("click",function(){
                $("#confirmbox").hide(200);
            });
        }else{
            $("#confirmbox").overlay({
                top:260,
            	mask: {
            		color: '#fff',
            		loadSpeed: 200,
            		opacity: 0.9
            	},
                closeOnClick: false,
                load: false
            }); 
        }
        $("#confirm").live("click",function(){
            if($.browser.msie)
                $("#confirmbox").hide(200);
            else
                $("#confirmbox").overlay().close();
            if($(".proc_form").validationEngine({returnIsValid:true})){
                var _data=$(".proc_form").serialize();
                $.ajax({ data:_data, url:"hp_sketch_proc_ajax.php" });
            }else{
                setTimeout(function(){
                    $.validationEngine.closePrompt('.formError',true);
                },5000);
            }
        });
        $(".form_sub").live('click',function(){
            $.validationEngine.closePrompt('.formError',true);
            $("#confirm_msg").text("確定要儲存這些資料嗎?");
            if($.browser.msie){
                $("#confirmbox").show(200).focus();
                $('body').animate({scrollTop:$('#confirmbox').offset().top}, 'slow');   
            }else
                $("#confirmbox").overlay().load();
        });
    </script>
HTML;
    $init_html.=$init_js;
    echo $init_html;
}
return $init_html;
?>