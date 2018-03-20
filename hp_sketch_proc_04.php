<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
include_once("inc/conn.php");
include_once("hp_sketch_proc_lib.php");

    $sql="SELECT * FROM h0xtprof_qual WHERE staff_cd='".$_SESSION['proc_edit_id']."' ORDER BY d_qual ASC";
    if($result=pg_query($sql)){
        $row_html="";
        while($obj=pg_fetch_object($result)){
            
            foreach($obj as $key=>$value){
                $obj->$key=trim($value);
            }
            
            $qual_school_o=cohs("SELECT * FROM h0rtschool_",$obj->qual_school,"","0","2");
            $qual_dist_o=coh("1:專門著作,2:文憑送審,3:資歷送審,4:技術性著作,5:藝術性著作",$obj->qual_dist);
            $qual_title_o=coh("T01:教授,T02:副教授,T03:講師,T04:助教,T05:助理教授",$obj->qual_title);

            
            $row_html.=<<<HTML
                    <div class="row_set">
                          <p>
                             <label>送審年月→</label> 
                                <input type="text" title="送審年月" class="validate[required,custom[date2]]" name="d_qual" id="d_qual" value="{$obj->d_qual}" />* 
                          </p> 
                          <p>
                             <label>送審類別→</label> 
                                <select title="送審類別" class="validate[required]" name="qual_dist" id="qual_dist">
                                    {$qual_dist_o}
                                </select>* 
                          </p>
                          <p>
                             <label>送審資格→</label> 
                                <select title="送審資格" name="qual_title" id="qual_title">
                                    {$qual_title_o}
                                </select>
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span>
                          </p>  
                          <p>
                             <label>送審學校→</label> 
                                <select title="送審學校" class="validate[required]" name="qual_school" id="qual_school">
                                    {$qual_school_o}
                                </select>* 
                          </p>
                          <p>
                             <label>教師證書字號→</label> 
                                <input type="text" title="教師證書字號" name="teach_doc" id="teach_doc" value="{$obj->teach_doc}" /> 
                          </p>
                          <p>
                             <label>起資日期→</label> 
                                <input type="text" title="起資日期" class="validate[optional,custom[date2]]" name="d_salary_start" id="d_salary_start" value="{$obj->d_salary_start}" /> 
                          </p>
                      </div>
HTML;
            
        }     
     
        if($row_html==""){
            $qual_school_o=cohs("SELECT * FROM h0rtschool_","","","0","2");
            $qual_dist_o=coh("1:專門著作,2:文憑送審,3:資歷送審,4:技術性著作,5:藝術性著作");
            $qual_title_o=coh("T01:教授,T02:副教授,T03:講師,T04:助教,T05:助理教授");
            $row_html="<span id='no_row'>目前沒有資料，請按下方「新增」按鈕來新增資料</span>";
        } 
        
        $init_html=<<<HTML
            <p><b><font size="4px">教師資格</font></b></p>
            <div>
                    <div id="row_blank" style="display:none;">
                              <br />
                              <p>
                                 <label>送審年月→</label> 
                                    <input type="text" title="送審年月" class="validate[required,custom[date2]]" name="d_qual" id="d_qual" />* 
                              </p> 
                              <p>
                                 <label>送審類別→</label> 
                                    <select title="送審類別" class="validate[required]" name="qual_dist" id="qual_dist">
                                        {$qual_dist_o}
                                    </select>* 
                              </p>
                              <p>
                                 <label>送審資格→</label> 
                                    <select title="送審資格" name="qual_title" id="qual_title">
                                        {$qual_title_o}
                                    </select>
                                    <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span>
                              </p>  
                              <p>
                                 <label>送審學校→</label> 
                                    <select title="送審學校" class="validate[required]" name="qual_school" id="qual_school">
                                        {$qual_school_o}
                                    </select>* 
                              </p>
                              <p>
                                 <label>教師證書字號→</label> 
                                    <input type="text" title="教師證書字號" name="teach_doc" id="teach_doc" /> 
                              </p>
                              <p>
                                 <label>起資日期→</label> 
                                    <input type="text" title="起資日期" class="validate[optional,custom[date2]]" name="d_salary_start" id="d_salary_start" /> 
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
                   <input type='hidden' name="form_sent" id="form_sent" value="p04" />
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