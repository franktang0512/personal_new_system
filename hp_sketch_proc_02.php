<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
include_once("inc/conn.php");
include_once("hp_sketch_proc_lib.php");

    $sql="SELECT * FROM h0xtedu_bg WHERE staff_cd='".$_SESSION['proc_edit_id']."' ORDER BY edu_bg_d_end ASC";
    if($result=pg_query($sql)){
        $row_html="";
        while($obj=pg_fetch_object($result)){
            
            foreach($obj as $key=>$value){
                $obj->$key=trim($value);
            }
            
            $edu_nation_o=cohs("SELECT * FROM h0rtnation_",$obj->edu_nation);
            $edu_status_o=cohs("SELECT * FROM h0btedu_status_",$obj->edu_status);
            $edu_deg_cd_o=cohs("SELECT * FROM h0btedu_deg_",$obj->edu_deg_cd);
            $edu_grp_cd_o=cohs("SELECT * FROM h0btedu_grp_",$obj->edu_grp_cd);
            $specialty_cd_o=cohs("SELECT * FROM h0btspecialyt_",$obj->specialty_cd,"0000000");
            $specialty_cd1_o=cohs("SELECT * FROM h0btspecialyt_",$obj->specialty_cd1,"0000000");
            $specialty_cd2_o=cohs("SELECT * FROM h0btspecialyt_",$obj->specialty_cd2,"0000000");
            $is_edu_o=coh("Y:是,N:否",$obj->is_edu);

            
            $row_html.=<<<HTML
                    <div class="row_set">
                          <p>
                             <label>修業學校→</label> 
                                <input type="text" title="修業學校" name="edu_school" id="edu_school" value="{$obj->edu_school}" /> 
                          </p> 
                          <p> 
                             <label>系所名稱→</label> 
                                <input type="text" title="系所名稱" name="edu_dept" id="edu_dept" value="{$obj->edu_dept}" />
                          </p>
                          <p>
                             <label>修業國別→</label> 
                                <select title="修業國別" class="validate[required]" name="edu_nation" id="edu_nation">
                                    {$edu_nation_o}
                                </select>* 
                          </p> 
                          <p> 
                             <label>修業年、月→</label> 
                                自<input type="text" class="validate[required,custom[date2]]" title="修業年月起" size="5" name="edu_bg_d_start" id="edu_bg_d_start" value="{$obj->edu_bg_d_start}" />*
                                至<input type="text" class="validate[required,custom[date2]]" title="修業年月迄" size="5" name="edu_bg_d_end" id="edu_bg_d_end" value="{$obj->edu_bg_d_end}" />*
                                <br /><span class="tips">輸入為民國年、月，格式為yyymm，如: 09912 即為民國99年12月。</span>
                          </p>
                          <p>
                             <label>修業別→</label> 
                                <select title="修業別" class="validate[required]" name="edu_status" id="edu_status">
                                    {$edu_status_o}
                                </select>* 
                          </p>
                          <p>
                             <label>教育程度→</label> 
                                <select title="教育程度" class="validate[required]" name="edu_deg_cd" id="edu_deg_cd">
                                    {$edu_deg_cd_o}
                                </select>*
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span> 
                          </p>
                          <p>
                             <label>教育類別→</label> 
                                <select title="教育類別" class="validate[required]" name="edu_grp_cd" id="edu_grp_cd">
                                    {$edu_grp_cd_o}
                                </select>* 
                          </p>
                          <p>
                             <label>學術專長1→</label>
                             <select title="學術專長1" class="validate[required]" name="specialty_cd" id="specialty_cd">
                                 {$specialty_cd_o}
                             </select>*
                             <input type="text"/><input class="search_btn" type="button" value="查詢">
                          </p>
                          <p>
                             <label>學術專長2→</label> 
                                <select title="學術專長2" class="validate[required]" name="specialty_cd1" id="specialty_cd1">
                                    {$specialty_cd1_o}
                                </select>* 
                                <input type="text"/><input class="search_btn" type="button" value="查詢">
                          </p> 
                          <p>
                             <label>學術專長3→</label> 
                                <select title="學術專長3" class="validate[required]" name="specialty_cd2" id="specialty_cd2">
                                    {$specialty_cd2_o}
                                </select>* 
                                <input type="text"/><input class="search_btn" type="button" value="查詢">
                          </p>
                          <p>
                             <label>是否為最高學歷→</label> 
                                <select title="是否為最高學歷" name="is_edu" id="is_edu">
                                    {$is_edu_o}
                                </select>
                          </p>
                          <p>
                             <label>證書日期文號→</label> 
                                <input type="text" title="證書日期文號" name="edu_doc" id="edu_doc" value="{$obj->edu_doc}" /> 
                          </p>
                      </div>
HTML;
            
        }     
     
        if($row_html==""){
            $edu_nation_o=cohs("SELECT * FROM h0rtnation_","","999");
            $edu_status_o=cohs("SELECT * FROM h0btedu_status_","","1");
            $edu_deg_cd_o=cohs("SELECT * FROM h0btedu_deg_","","00");
            $edu_grp_cd_o=cohs("SELECT * FROM h0btedu_grp_","","A");
            $specialty_cd_o=cohs("SELECT * FROM h0btspecialyt_","","0000000");
            $specialty_cd1_o=cohs("SELECT * FROM h0btspecialyt_","","0000000");
            $specialty_cd2_o=cohs("SELECT * FROM h0btspecialyt_","","0000000");
            $is_edu_o=coh("N:否,Y:是");
            $row_html="<span id='no_row'>目前沒有資料，請按下方「新增」按鈕來新增資料</span>";
        }
            $edu_nation_o=cohs("SELECT * FROM h0rtnation_","","999");
            $edu_status_o=cohs("SELECT * FROM h0btedu_status_","","1");
            $edu_deg_cd_o=cohs("SELECT * FROM h0btedu_deg_","","00");
            $edu_grp_cd_o=cohs("SELECT * FROM h0btedu_grp_","","A");
		    $specialty_cd_o=cohs("SELECT * FROM h0btspecialyt_","","0000000");
            $specialty_cd1_o=cohs("SELECT * FROM h0btspecialyt_","","0000000");
            $specialty_cd2_o=cohs("SELECT * FROM h0btspecialyt_","","0000000");


        $init_html=<<<HTML
            <p><b><font size="4px">學歷資料</font></b></p>
            <div>
                    <div id="row_blank" style="display:none;">
                              <br />
                              <p>
                                 <label>修業學校→</label> 
                                    <input type="text" title="修業學校" name="edu_school" id="edu_school" value="" /> 
                              </p> 
                              <p> 
                                 <label>系所名稱→</label> 
                                    <input type="text" title="系所名稱" name="edu_dept" id="edu_dept" value="" />
                              </p>
                              <p>
                                 <label>修業國別→</label> 
                        <select class="too_much validate[required]" title="修業國別" name="edu_nation" id="edu_nation">{$edu_nation_o}</select>
                              </p>
                              <p> 
                                 <label>修業年、月→</label> 
                                    自<input type="text" class="validate[required,custom[date2]]" title="修業年月起" size="5" name="edu_bg_d_start" id="edu_bg_d_start" value="00101" />*
                                    至<input type="text" class="validate[required,custom[date2]]" title="修業年月迄" size="5" name="edu_bg_d_end" id="edu_bg_d_end" value="99912" />*
                                    <br /><span class="tips">輸入為民國年、月，格式為yyymm，如: 09912 即為民國99年12月。</span>
                              </p>
                              <p>
                                 <label>修業別→</label> 
                                    <select title="修業別" class="validate[required]" name="edu_status" id="edu_status">
                                        {$edu_status_o}
                                    </select>*
                              </p>
                              <p>
                                 <label>教育程度→</label> 
                                    <select title="教育程度" class="validate[required]" name="edu_deg_cd" id="edu_deg_cd">
                                        {$edu_deg_cd_o}
                                    </select>*
                                    <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span> 
                              </p>
                              <p>
                                 <label>教育類別→</label> 
                                    <select title="教育類別" class="validate[required]" name="edu_grp_cd" id="edu_grp_cd">
                                        {$edu_grp_cd_o}
                                    </select>* 
                              </p>
                              <p>
                                 <label>學術專長1→</label> 
								 <select title="學術專長1" class="validate[required]" name="specialty_cd" id="specialty_cd">
                                    {$specialty_cd_o}
                                </select>*
                               <input type="text"/><input class="search_btn" type="button" value="查詢">
                             </p>
                              <p>
                                 <label>學術專長2→</label>
                                <select title="學術專長2" class="validate[required]" name="specialty_cd1" id="specialty_cd1">
                                    {$specialty_cd1_o}
                                </select>*
                                <input type="text"/><input class="search_btn" type="button" value="查詢">
                              </p> 
                              <p>
                                 <label>學術專長3→</label>
                                     <select title="學術專長2" class="validate[required]" name="specialty_cd1" id="specialty_cd1">
                                    {$specialty_cd2_o}
                                </select>*
                                <input type="text"/><input class="search_btn" type="button" value="查詢">
                              </p>
                              <p>
                                 <label>是否為最高學歷→</label> 
                                    <select title="是否為最高學歷" name="is_edu" id="is_edu">
                                        <option value='N'>否</option>
                                        <option value='Y'>是</option>
										
										
                                    </select>
                              </p>
                              <p>
                                 <label>證書日期文號→</label> 
                                    <input type="text" title="證書日期文號" name="edu_doc" id="edu_doc" value="" /> 
                              </p>
                      </div>
                      <div style="display:none;">
                        <select class="too_much validate[required]" title="修業國別" name="edu_nation" id="edu_nation">{$edu_nation_o}</select>
                        <select class="too_much validate[required]" title="學術專長1" name="specialty_cd" id="specialty_cd">{$specialty_cd_o}</select>
                        <select class="too_much validate[required]" title="學術專長2" name="specialty_cd1" id="specialty_cd1">{$specialty_cd1_o}</select> 
                        <select class="too_much validate[required]" title="學術專長3" name="specialty_cd2" id="specialty_cd2">{$specialty_cd2_o}</select>
                      </div>
                <form class="proc_form" method="POST">     
                    <p> 
                        身分證號碼/統一證號：{$_SESSION["proc_edit_id"]}&nbsp;&nbsp;&nbsp;中文姓名：{$_SESSION["proc_edit_cname"]}                           
                    </p>
                    <fieldset> 
                      <div id="rows">
                        {$row_html}
                      </div>
                      <div id="submit_button">
                            <a class='form_button' id="new_row"><span>新增</span></a>
                            <a class='form_button form_sub' id='sub_form'><span>儲存</span></a>
                            <a class="form_button control_" href="hp_sketch_proc_main.php">
                                <span>返回功能表</span>
                            </a>
                      </div>
                      <div id="confirmbox">
                        <h2>請確認</h2>
                        <p id="confirm_msg"></p>
                        <button id="confirm">確定</button>&nbsp;&nbsp;<button class="close">取消</button>
                      </div>
                   </fieldset>
                   <input type="hidden" name="total_rows" id="total_rows" value="" /> 
                   <input type='hidden' name="form_sent" id="form_sent" value="p02" />
                </form>
            </div>
        

HTML;
    }

if($_POST["ajax"]=="Y"){
    $init_js=<<<HTML
    <script type='text/javascript'>
        function refresh(){
            var found=$(".row_set","#rows");
            if(found.length!=0){
                $(".row_set:even").css("background-color","#ddf");
                $(".row_set:odd").css("background-color","#dfd");
            }else{
                $("#rows").html("<span id='no_row'>目前沒有資料，請按下方「新增」按鈕來新增資料</span>");
            }
        }
        $(document).ready(function(){
            refresh();
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
            var to_del;
            var func="";
            var e_id="";
            $("input:checkbox").live("click",function(){           
                if(this.checked){
                    var to_show=$(this).val();
                    $("#"+to_show).clone().insertAfter(this).show();
                    $(this).remove();
                }
            });
            $("#new_row").live("click",function(){
                if($("#no_row"))
                    $("#no_row").remove();
                $("#row_blank").clone().attr("class","row_set").removeAttr("id").appendTo("#rows").fadeIn(300);
                refresh();
            });
            $(".search_btn").live("click",function(){
              $.ajax({
                 url:"hp_sketch_proc_02_ajax.php",
                 type:"GET",
                 data:{search_string:$(this).prev().val()},
                 error:function(xhr){
                     alert("ajax error!!");
                 },
                 context:this,
                 success:function(response){
                 $(this).prev().prev().html(response); 
                 }
              });
            });
            $(".del").live("click",function(){
                to_del=$(this).parents(".row_set");
                func="del";
                $("#confirm_msg").text("確定放棄這筆資料嗎?(註：按下儲存前不會真的刪除這筆資料)");
                if($.browser.msie){
                    $("#confirmbox").show(200).focus();
                    $('body').animate({scrollTop:$('#confirmbox').offset().top}, 'slow');   
                }else
                    $("#confirmbox").overlay().load();
            });
            $(".form_sub").live("click",function(){
                $.validationEngine.closePrompt('.formError',true);
                func="save";
                $("#confirm_msg").text("確定要儲存這些資料嗎?(註：按下儲存後，先前放棄的資料將會被刪除)");
                if($.browser.msie){
                    $("#confirmbox").show(200).focus();
                    $('body').animate({scrollTop:$('#confirmbox').offset().top}, 'slow');   
                }else
                    $("#confirmbox").overlay().load();
            });
            $("#confirm").live("click",function(){
                if($.browser.msie)
                    $("#confirmbox").hide(200);
                else
                    $("#confirmbox").overlay().close();
                switch(func){
                    case "del":
                        to_del.fadeOut(500,function(){ 
                            $(this).remove();
                            refresh(); 
                        });
                    break;
                    
                    case　"save":
                        var index=0;
                        $(".row_set").each(function(){
                            index++;
                            $(this).find("input:text,input:checkbox,select").each(function(){
                                var _name=$(this).attr("id");
                                _name=_name.split("--");
                                _name=_name[0]+"--"+index;
                                $(this).attr({id:_name,name:_name});
                            });                                
                        });  
                        if($.browser.msie){
                            $("#total_rows").val(index);
                            var _data=$(".proc_form").serialize();
                            $.ajax({ data:_data, url:"hp_sketch_proc_ajax.php" });                            
                        }else{
                            if($(".proc_form").validationEngine({returnIsValid:true})){
                                $("#total_rows").val(index);
                                var _data=$(".proc_form").serialize();
                                $.ajax({ data:_data, url:"hp_sketch_proc_ajax.php" });
                            }else{
                                setTimeout(function(){
                                    $.validationEngine.closePrompt('.formError',true);
                                },5000);
                            }
                        }
                    break;
                }
                func="";
            });
        });
    </script>
HTML;
    $init_html.=$init_js;
    echo $init_html;
}
return $init_html;
?>