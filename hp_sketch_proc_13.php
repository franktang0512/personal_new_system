<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
//include_once("inc/conn.php");
include_once("inc/conn.php");
include_once("hp_sketch_proc_lib.php");

	
	// echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF8'>";
	
    $sql="SELECT * FROM h0xt_autobiography_rec WHERE h0xt_autobiography_rec.staff_cd='".$_SESSION['proc_edit_id']."'";
    if($result=pg_query($sql)){
        $obj=pg_fetch_object($result);
        
        foreach($obj as $key=>$value){
         //   $obj->$key=trim($value);
        }
        
		
		/*
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
		*/
		
        $init_html=<<<HTML
            <p><b><font size="4px">簡要自述</font></b></p>
            <p>每一行最多可輸入80個半型的英文、數字(即 40  個中文字) ，最多輸入14行。</p>
			<p> 
				身分證號碼/統一證號：{$_SESSION["proc_edit_id"]}&nbsp;&nbsp;&nbsp;中文姓名：{$_SESSION["proc_edit_cname"]}&nbsp;                          
            </p>
            <div>
                <form class="proc_form" method="POST"> 
     
                   <fieldset> 
                    <div  style="background-color:#ddf;">
                          
						   <p>
                             <label>(01)</label> 
                             <input type="text"  title="第一行" value='{$obj->des_01}' name="desc01" id='desc01' maxlength="40" class="validate[required]"  />
                          </p>
						  
						  <p>
                             <label>(02)</label> 
                             <input type="text"  title="第二行" value='{$obj->des_02}' name="desc02" id='desc02' maxlength="40"/>
                          </p>
						  <p>
                             <label>(03)</label> 
                             <input type="text"  title="第三行" value='{$obj->des_03}' name="desc03" id='desc03' maxlength="40"/>
                          </p>
						  <p>
                             <label>(04)</label> 
                             <input type="text"  title="第四行" value='{$obj->des_04}' name="desc04" id='desc04' maxlength="40"/>
                          </p>
						  <p>
                             <label>(05)</label> 
                             <input type="text"  title="第五行" value='{$obj->des_05}' name="desc05" id='desc05' maxlength="40"/>
                          </p>
						  <p>
                             <label>(06)</label> 
                             <input type="text"  title="第六行" value='{$obj->des_06}' name="desc06" id='desc06' maxlength="40"/>
                          </p>
						  <p>
                             <label>(07)</label> 
                             <input type="text"  title="第七行" value='{$obj->des_07}' name="desc07" id='desc07' maxlength="40"/>
                          </p>
						  <p>
                             <label>(08)</label> 
                             <input type="text"  title="第八行" value='{$obj->des_08}' name="desc08" id='desc08' maxlength="40"/>
                          </p>
						  <p>
                             <label>(09)</label> 
                             <input type="text"  title="第九行" value='{$obj->des_09}' name="desc09" id='desc09' maxlength="40"/>
                          </p>
						  <p>
                             <label>(10)</label> 
                             <input type="text"  title="第十行" value='{$obj->des_10}' name="desc10" id='desc10' maxlength="40"/>
                          </p>
						  <p>
                             <label>(11)</label> 
                             <input type="text"  title="第十一行" value='{$obj->des_11}' name="desc11" id='desc11' maxlength="40"/>
                          </p>
						  <p>
                             <label>(12)</label> 
                             <input type="text"  title="第十二行" value='{$obj->des_12}' name="desc12" id='desc12' maxlength="40"/>
                          </p>
						  <p>
                             <label>(13)</label> 
                             <input type="text"  title="第十三行" value='{$obj->des_13}' name="desc13" id='desc13' maxlength="40"/>
                          </p>
						  <p>
                             <label>(14)</label> 
                             <input type="text"  title="第十四行" value='{$obj->des_14}' name="desc14" id='desc14' maxlength="40"/>
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
                        <button id="confirm">確定</button>&nbsp;&nbsp;<button class="close">取消</button>
                      </div>
                      <input type='hidden' name="form_sent" id="form_sent" value="p13" />
                    
                   </fieldset> 
                </form>
            </div>
        

HTML;
    }

	
if($_POST["ajax"]=="Y"){
    $init_js=<<<HTML
    <script type='text/javascript'>
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
                $.ajax({ 
					data:_data, 
					url:"hp_sketch_proc_ajax.php",
					success: function(response) {
						var rarr = response.split(":");
						if(rarr[0]==1)
							location.href= ('hp_sketch_proc_main.php'); 
						else
							alert(response);
					}
				});
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