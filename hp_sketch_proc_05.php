<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
include_once("inc/conn.php");
include_once("hp_sketch_proc_lib.php");

    $sql="SELECT * FROM h0xtskill_per WHERE staff_cd='".$_SESSION['proc_edit_id']."' ";
    if($result=pg_query($sql)){
        $row_html="";
        while($obj=pg_fetch_object($result)){
            
            foreach($obj as $key=>$value){
                $obj->$key=trim($value);
            }
            
            $skill_cd_o=cohs("SELECT * FROM h0btskill_",$obj->skill_cd);
           
            $row_html.=<<<HTML
                    <div class="row_set">
                          <p>
                             <label>專長→</label> 
                                <select title="專長" class="validate[required]" name="skill_cd" id="skill_cd">
                                    {$skill_cd_o}
                                </select>* 
                          </p>
                          <p>
                             <label>證照名稱→</label> 
                                <input type="text" title="證照名稱" name="doc_name" id="doc_name" value="{$obj->doc_name}" /> 
                          </p>
                          <p>
                             <label>生效日期→</label> 
                                <input type="text" title="生效日期" class="validate[optional,custom[date1]]" name="d_effect" id="d_effect" value="{$obj->d_effect}" />
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span> 
                          </p> 
                          <p>
                             <label>證件日期文號→</label> 
                                <input type="text" title="證件日期文號" name="doc" id="doc" value="{$obj->doc}" /> 
                          </p> 
                          <p>
                             <label>認證機關→</label> 
                                <input type="text" title="認證機關" name="validate_orga" id="validate_orga" value="{$obj->validate_orga}" /> 
                          </p>
                          <p>
                             <label>專長描述→</label> 
                                <input type="text" title="專長描述" name="skill_desc" id="skill_desc" value="{$obj->skill_desc}" /> 
                          </p>    
                      </div>
HTML;
            
        }
        if($row_html==""){
            $skill_cd_o=cohs("SELECT * FROM h0btskill_");
            $row_html="<span id='no_row'>目前沒有資料，請按下方「新增」按鈕來新增資料</span>";
        }     
        
        $init_html=<<<HTML
            <p><b><font size="4px">專長記錄</font></b></p>
            <div>
                    <div id="row_blank" style="display:none;">
                              <br />
                              <p>
                                 <label>專長→</label> 
                                    <select title="專長" class="validate[required]" name="skill_cd" id="skill_cd">
                                        {$skill_cd_o}
                                    </select>* 
                              </p>
                              <p>
                                 <label>證照名稱→</label> 
                                    <input type="text" title="證照名稱" name="doc_name" id="doc_name" /> 
                              </p>
                              <p>
                                 <label>生效日期→</label> 
                                    <input type="text" title="生效日期" class="validate[optional,custom[date1]]" name="d_effect" id="d_effect" />
                                    <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span> 
                              </p> 
                              <p>
                                 <label>證件日期文號→</label> 
                                    <input type="text" title="證件日期文號" name="doc" id="doc" /> 
                              </p> 
                              <p>
                                 <label>認證機關→</label> 
                                    <input type="text" title="認證機關" name="validate_orga" id="validate_orga" /> 
                              </p>
                              <p>
                                 <label>專長描述→</label> 
                                    <input type="text" title="專長描述" name="skill_desc" id="skill_desc" /> 
                              </p>    
                      </div>
                      <div style="display:none;">
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
                   <input type='hidden' name="form_sent" id="form_sent" value="p05" />
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