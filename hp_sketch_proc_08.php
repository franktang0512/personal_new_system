<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
//include_once("inc/conn.php");
include_once("inc/conn.php");
include_once("hp_sketch_proc_lib.php");

if($_SESSION["dist_cd"]!="TEA"){  //08_01

    $sql="SELECT * FROM h0xtstaff_study_train WHERE staff_cd='".$_SESSION['proc_edit_id']."' ";
    if($result=pg_query($sql)){
        $row_html="";
        while($obj=pg_fetch_object($result)){
            
            foreach($obj as $key=>$value){
                $obj->$key=trim($value);
            }

            $torga_cd_o=cohs("SELECT torga_cd,torga_name FROM h0rtorga_",$obj->torga_cd,"00");
            $country_hf_o=coh("H:國內,F:國外",$obj->country_hf,"H");
            $dist_o=coh("1:一般進修,2:學位進修,3:訓練課程",$obj->dist,"1");
            $how_o=coh("1:荐送(機關選送),2:自行參加(非機關選送)",$obj->how,"1");
            $degree_o=coh("1:博士,2:碩士,0:無",$obj->degree,"0");
           
            $row_html.=<<<HTML
                    <div class="row_set">
                          <p>
                             <label>起始日期→</label> 
                                <input type="text" title="起始日期" class="validate[required,custom[date1]]" name="d_start" id="d_start" value="{$obj->d_start}" />* 
                          </p>
                          <p>
                             <label>結束日期→</label> 
                                <input type="text" title="結束日期" class="validate[optional,custom[date1]]" name="d_end" id="d_end" value="{$obj->d_end}" /> 
                          </p>                          
                          <p>
                             <label>國內或國外→</label> 
                                <select title="國內或國外" name="country_hf" id="country_hf">
                                    {$country_hf_o}
                                </select> 
                          </p>
                          <p>
                             <label>進修/訓練區別→</label> 
                                <select title="進修/訓練區別" name="dist" id="dist">
                                    {$dist_o}
                                </select> 
                          </p>
                          <p>
                             <label>參加方式→</label> 
                                <select title="參加方式" name="how" id="how">
                                    {$how_o}
                                </select> 
                          </p>                          
                          <p>
                             <label>進修舉辦機構→</label> 
                                <input type="text" title="進修舉辦機構" name="orga" id="orga" value="{$obj->orga}" />
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span>                                 
                          </p>                          
                          <p>
                             <label>參加訓練機構→</label> 
                                <select title="參加訓練機構" name="torga_cd" id="torga_cd">
                                    {$torga_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>開課名稱_班別→</label> 
                                <input type="text" title="開課名稱_班別" name="class" id="class" value="{$obj->class}" /> 
                          </p>
                          <p>
                             <label>時數/學分數→</label> 
                                <input type="text" title="時數/學分數" class="validate[optional,custom[onlyNumber]]" name="hours_points" id="hours_points" value="{$obj->hours_points}" /> 
                          </p> 
                          <p>
                             <label>期別→</label> 
                                <input type="text" title="期別" class="validate[optional,custom[onlyNumber]]" name="phase" id="phase" value="{$obj->phase}" /> 
                          </p>
                          <p>
                             <label>學位別→</label> 
                                <select title="學位別" name="degree" id="degree">
                                    {$degree_o}
                                </select>
                          </p> 
                          <p>
                             <label>證件日期文號→</label> 
                                <input type="text" title="核定文號" name="doc" id="doc" value="{$obj->doc}" /> 
                          </p> 
                                                                             
                      </div>
HTML;
            
        }
        if($row_html==""){
            $torga_cd_o=cohs("SELECT torga_cd,torga_name FROM h0rtorga_","00");
            $country_hf_o=coh("H:國內,F:國外","H");
            $dist_o=coh("1:一般進修,2:學位進修,3:訓練課程","1");
            $how_o=coh("1:荐送(機關選送),2:自行參加(非機關選送)","1");
            $degree_o=coh("1:博士,2:碩士,0:無","0");
            $row_html="<span id='no_row'>目前沒有資料，請按下方「新增」按鈕來新增資料</span>";
        }     
        
        $init_html=<<<HTML
            <p><b><font size="4px">職員進修與訓練記錄</font></b></p>
            <div>
                    <div id="row_blank" style="display:none;">
                              <br />
                          <p>
                             <label>起始日期→</label> 
                                <input type="text" title="起始日期" class="validate[required,custom[date1]]" name="d_start" id="d_start" />* 
                          </p>
                          <p>
                             <label>結束日期→</label> 
                                <input type="text" title="結束日期" class="validate[optional,custom[date1]]" name="d_end" id="d_end" /> 
                          </p>                          
                          <p>
                             <label>國內或國外→</label> 
                                <select title="國內或國外" name="country_hf" id="country_hf">
                                    {$country_hf_o}
                                </select> 
                          </p>
                          <p>
                             <label>進修/訓練區別→</label> 
                                <select title="進修/訓練區別" name="dist" id="dist">
                                    {$dist_o}
                                </select> 
                          </p>
                          <p>
                             <label>參加方式→</label> 
                                <select title="參加方式" name="how" id="how">
                                    {$how_o}
                                </select> 
                          </p>                          
                          <p>
                             <label>進修舉辦機構→</label> 
                                <input type="text" title="進修舉辦機構" name="orga" id="orga" value="" />
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span>                                 
                          </p>                          
                          <p>
                             <label>參加訓練機構→</label> 
                                <select title="參加訓練機構" name="torga_cd" id="torga_cd">
                                    {$torga_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>開課名稱_班別→</label> 
                                <input type="text" title="開課名稱_班別" name="class" id="class" value="" /> 
                          </p>
                          <p>
                             <label>時數/學分數→</label> 
                                <input type="text" title="時數/學分數" class="validate[optional,custom[onlyNumber]]" name="hours_points" id="hours_points" /> 
                          </p> 
                          <p>
                             <label>期別→</label> 
                                <input type="text" title="期別" class="validate[optional,custom[onlyNumber]]" name="phase" id="phase" /> 
                          </p>
                          <p>
                             <label>學位別→</label> 
                                <select title="學位別" name="degree" id="degree">
                                    {$degree_o}
                                </select>
                          </p> 
                          <p>
                             <label>證件日期文號→</label> 
                                <input type="text" title="核定文號" name="doc" id="doc" /> 
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
                   <input type='hidden' name="form_sent" id="form_sent" value="p08_01" />
                </form>
            </div>
        

HTML;
    }

}else{  //08_02
    $sql="SELECT * FROM h0xtprof_study WHERE staff_cd='".$_SESSION['proc_edit_id']."' ";
    if($result=pg_query($sql)){
        $row_html="";
        while($obj=pg_fetch_object($result)){
            
            foreach($obj as $key=>$value){
                $obj->$key=trim($value);
            }

            $n_cd_o=cohs("SELECT n_cd,n_name FROM h0rtnation_",$obj->n_cd);
            $country_hf_o=coh("H:國內,F:國外",$obj->country_hf,"H");
            $dist_o=coh("1:進修,2:研究,3:講學,4:休假研究,5:考查",$obj->dist,"1");
           
            $row_html.=<<<HTML
                    <div class="row_set">
                          <p>
                             <label>進修/研究種類→</label> 
                                <select title="進修/研究種類" class="validate[required]" name="dist" id="dist">
                                    {$dist_o}
                                </select>* 
                          </p>
                          <p>
                             <label>起始核定日期→</label> 
                                <input type="text" title="起始核定日期" class="validate[required,custom[date1]]" name="d_ok_start" id="d_ok_start" value="{$obj->d_ok_start}" />* 
                          </p>                            
                          <p>
                             <label>實際結束日期→</label> 
                                <input type="text" title="實際結束日期" class="validate[optional,custom[date1]]" name="d_study_end_actual" id="d_study_end_actual" value="{$obj->d_study_end_actual}" /> 
                          </p>
                          <p>
                             <label>補助機關→</label> 
                                <input type="text" title="補助機關" name="subs_orga" id="subs_orga" value="{$obj->subs_orga}" />                                  
                          </p>                                                     
                          <p>
                             <label>國內或國外→</label> 
                                <select title="國內或國外" name="country_hf" id="country_hf">
                                    {$country_hf_o}
                                </select>
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span>                                 
                          </p>
                          <p>
                             <label>前往國家→</label> 
                                <select title="前往國家" name="n_cd" id="n_cd">
                                    {$n_cd_o}
                                </select> 
                          </p>
                          <p>
                             <label>前往學校/研究機構→</label> 
                                <input type="text" title="前往學校/研究機構" name="school" id="school" value="{$obj->school}" /> 
                          </p>
                          <p>
                             <label>研究進修計劃名稱→</label> 
                                <input type="text" title="研究進修計劃名稱" name="project_name" id="project_name" value="{$obj->project_name}" /> 
                          </p> 
                          <p>
                             <label>合約蓋章送回文號→</label> 
                                <input type="text" title="合約蓋章送回文號" name="doc" id="doc" value="{$obj->doc}" /> 
                          </p>                                                                         
                                                                            
                      </div>
HTML;
            
        }
        if($row_html==""){
            $n_cd_o=cohs("SELECT n_cd,n_name FROM h0rtnation_");
            $country_hf_o=coh("H:國內,F:國外","H");
            $dist_o=coh("1:進修,2:研究,3:講學,4:休假研究,5:考查","1");
            $row_html="<span id='no_row'>目前沒有資料，請按下方「新增」按鈕來新增資料</span>";
        }     
        
        $init_html=<<<HTML
            <p><b><font size="4px">教師研究與進修記錄</font></b></p>
            <div>
                    <div id="row_blank" style="display:none;">
                              <br />
                          <p>
                             <label>進修/研究種類→</label> 
                                <select title="進修/研究種類" class="validate[required]" name="dist" id="dist">
                                    {$dist_o}
                                </select>* 
                          </p>
                          <p>
                             <label>起始核定日期→</label> 
                                <input type="text" title="起始核定日期" class="validate[required,custom[date1]]" name="d_ok_start" id="d_ok_start" />* 
                          </p>                            
                          <p>
                             <label>實際結束日期→</label> 
                                <input type="text" title="實際結束日期" class="validate[optional,custom[date1]]" name="d_study_end_actual" id="d_study_end_actual" /> 
                          </p>
                          <p>
                             <label>補助機關→</label> 
                                <input type="text" title="補助機關" name="subs_orga" id="subs_orga" />                                  
                          </p>                                                     
                          <p>
                             <label>國內或國外→</label> 
                                <select title="國內或國外" name="country_hf" id="country_hf">
                                    {$country_hf_o}
                                </select>
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span>                                 
                          </p>
                          <p>
                             <label>前往國家→</label> 
                                <select title="前往國家" name="n_cd" id="n_cd">
                                    {$n_cd_o}
                                </select> 
                          </p>
                          <p>
                             <label>前往學校/研究機構→</label> 
                                <input type="text" title="前往學校/研究機構" name="school" id="school" /> 
                          </p>
                          <p>
                             <label>研究進修計劃名稱→</label> 
                                <input type="text" title="研究進修計劃名稱" name="project_name" id="project_name" /> 
                          </p> 
                          <p>
                             <label>合約蓋章送回文號→</label> 
                                <input type="text" title="合約蓋章送回文號" name="doc" id="doc" /> 
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
                   <input type='hidden' name="form_sent" id="form_sent" value="p08_02" />
                </form>
            </div>
        

HTML;
    }
    
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