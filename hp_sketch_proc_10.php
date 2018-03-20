<?php
session_start();
if(!isset($_SESSION["id"])){
    echo "無效的操作，請先登入";
    exit();
}
//include_once("inc/conn.php");
include_once("inc/conn.php");
include_once("hp_sketch_proc_lib.php");


    $sql="SELECT * FROM h0xtchange_qual WHERE staff_cd='".$_SESSION['proc_edit_id']."' ";
    if($result=pg_query($sql)){
        $row_html="";
        while($obj=pg_fetch_object($result)){
            
            foreach($obj as $key=>$value){
                $obj->$key=trim($value);
            }
            $torga_cd_o=cohs("SELECT torga_cd,torga_name FROM h0rtorga_ WHERE torga_cd LIKE '%".$obj->torga_cd."%'",$obj->torga_cd);
            $unit_cd_o=cohs("SELECT unit_cd,unit_name FROM h0rtunit_",$obj->unit_cd);
            $tt="SELECT h0rttilte_.title_cd,h0rttilte_.title_name,h0rttilte_.put_title_cd,h0rtpub_title.put_title_name 
                    FROM h0rttilte_,h0rtpub_title 
                WHERE (h0rtpub_title.put_title_cd =* h0rttilte_.put_title_cd) ORDER BY h0rttilte_.title_cd ASC";
            $title_cd_o=cohs($tt,$obj->title_cd);
            $pub_cd_o=cohs("SELECT pub_cd,pub_name FROM h0etpub_rank_",$obj->pub_cd);
            $duty_cd_o=cohs("SELECT duty_cd,duty_name FROM h0etduty_",$obj->duty_cd);
            $out_reason_cd_o=cohs("SELECT reason_cd,reason_name FROM h0etchg_reason_",$obj->out_reason_cd);
            $qual_cd_o=cohs("SELECT qual_cd,qual_name FROM h0etqual_",$obj->qual_cd);
            $pub_qual_cd_o=cohs("SELECT pub_cd,pub_name FROM h0etpub_rank_",$obj->pub_qual_cd);
            $boss_level_o=coh("1:一級主管,2:二級主管,0:非主管",$obj->boss_level);

           
            $row_html.=<<<HTML
            <div id="load"></div>
                    <div class="row_set">
                          <p>
                             <label>任職起日→</label> 
                                <input type="text" title="任職起日" class="validate[required,custom[date1]]" name="d_start" id="d_start" value="{$obj->d_start}" />* 
                          </p>
                          <p>
                             <label>任職迄日→</label> 
                                <input type="text" title="任職迄日" class="validate[optional,custom[date1]]" name="d_end" id="d_end" value="{$obj->d_end}" /> 
                          </p>                          
                          <p>
                             <label>任職機關查詢→</label>
                             <input class="search_word" type="text" name="search_word" onchange="createquerystring(this)"/>
                             <input id="btn" type="button" value="查詢" onclick="search_value()"/>
                             <div class="sel_parent">
                             <label>任職機關→</label>
                             <select title="任職機關" name="torga_cd" id="torga_cd" class="torga_cd">
                             {$torga_cd_o}
                             </select>
                             </div>
                          </p>
                          <p>
                             <label>任職單位(非現職機關免填)→</label> 
                                <select title="任職單位" name="unit_cd" id="unit_cd">
                                    {$unit_cd_o}
                                </select> 
                          </p>
                          <p>
                             <label>職稱→</label> 
                                <select title="職稱" name="title_cd" id="title_cd">
                                    {$title_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>部定官職等→</label> 
                                <select title="部定官職等" name="pub_cd" id="pub_cd">
                                    {$pub_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>主管級別→</label> 
                                <select title="主管級別" name="boss_level" id="boss_level">
                                    {$boss_level_o}
                                </select>
                          </p>
                          <p>
                             <label>職系→</label> 
                                <select title="職系" name="duty_cd" id="duty_cd">
                                    {$duty_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>任職文號→</label> 
                                <input type="text" title="任職文號" name="doc" id="doc" value="{$obj->doc}" />
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span>
                          </p>
                          <p>
                             <label>免職文號→</label> 
                                <input type="text" title="免職文號" name="end_doc" id="end_doc" value="{$obj->end_doc}" />
                          </p>                       
                          <p>
                             <label>異動原因→</label> 
                                <select title="異動原因" name="out_reason_cd" id="out_reason_cd">
                                    {$out_reason_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>銓敘核定文號→</label> 
                                <input type="text" title="銓敘核定文號" name="qual_doc" id="qual_doc" value="{$obj->qual_doc}" /> 
                          </p>                           
                          <p>
                             <label>銓敘審定結果→</label> 
                                <select title="銓敘審定結果" name="qual_cd" id="qual_cd">
                                    {$qual_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>銓敘審定官職等→</label> 
                                <select title="銓敘審定官職等" name="pub_qual_cd" id="pub_qual_cd">
                                    {$pub_qual_cd_o}
                                </select>
                          </p>                            
                          <p>
                             <label>俸級→</label> 
                                <input type="text" title="俸級" name="lev" id="lev" value="{$obj->lev}" /> 
                          </p>
                          <p>
                             <label>俸點→</label> 
                                <input type="text" title="俸點" name="point" id="point" value="{$obj->point}" /> 
                          </p> 
                          <p>
                             <label>銓敘生效日期→</label> 
                                <input type="text" title="銓敘生效日期" class="validate[optional,custom[date1]]" name="d_execute" id="d_execute" value="{$obj->d_execute}" /> 
                          </p>  
                                                                             
                      </div>
HTML;
            
        }
        if($row_html==""){
            $torga_cd_o=cohs("SELECT torga_cd,torga_name FROM h0rtorga_ WHERE torga_cd LIKE '%".$obj->torga_cd."%'");
            $unit_cd_o=cohs("SELECT unit_cd,unit_name FROM h0rtunit_");
            $tt="SELECT h0rttilte_.title_cd,h0rttilte_.title_name,h0rttilte_.put_title_cd,h0rtpub_title.put_title_name 
                    FROM h0rttilte_,h0rtpub_title 
                WHERE (h0rtpub_title.put_title_cd =* h0rttilte_.put_title_cd) ORDER BY h0rttilte_.title_cd ASC";
            $title_cd_o=cohs($tt);
            $pub_cd_o=cohs("SELECT pub_cd,pub_name FROM h0etpub_rank_");
            $duty_cd_o=cohs("SELECT duty_cd,duty_name FROM h0etduty_");
            $out_reason_cd_o=cohs("SELECT reason_cd,reason_name FROM h0etchg_reason_");
            $qual_cd_o=cohs("SELECT qual_cd,qual_name FROM h0etqual_");
            $pub_qual_cd_o=cohs("SELECT pub_cd,pub_name FROM h0etpub_rank_");
            $boss_level_o=coh("1:一級主管,2:二級主管,0:非主管");
            $row_html="<span id='no_row'>目前沒有資料，請按下方「新增」按鈕來新增資料</span>";
        }     
        
        $init_html=<<<HTML
            <p><b><font size="4px">經歷與現職(任免、銓敘審定)</font></b></p>
            <div>
                    <div id="row_blank" style="display:none;">
                              <br />
                          <p>
                             <label>任職起日→</label> 
                                <input type="text" title="任職起日" class="validate[required,custom[date1]]" name="d_start" id="d_start" />* 
                          </p>
                          <p>
                             <label>任職迄日→</label> 
                                <input type="text" title="任職迄日" class="validate[optional,custom[date1]]" name="d_end" id="d_end" /> 
                          </p>                          
                          <p>
                             <label>任職機關查詢→</label>
                              <input class="search_word" type="text" name="search_word" onchange="createquerystring(this)"/>
                              <input id="btn" type="button" value="查詢" onclick="search_value()"/>
                            <div class="sel_parent">
                             <label>任職機關→</label> 
                                <select title="任職機關" name="torga_cd" class="torga_cd" id="torga_cd">
                                    {$torga_cd_o}
                                </select> 
                                </div>
                          </p>
                          <p>
                             <label>任職單位(非現職機關免填)→</label> 
                                <select title="任職單位" name="unit_cd" id="unit_cd">
                                    {$unit_cd_o}
                                </select> 
                          </p>
                          <p>
                             <label>職稱→</label> 
                                <select title="職稱" name="title_cd" id="title_cd">
                                    {$title_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>部定官職等→</label> 
                                <select title="部定官職等" name="pub_cd" id="pub_cd">
                                    {$pub_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>主管級別→</label> 
                                <select title="主管級別" name="boss_level" id="boss_level">
                                    {$boss_level_o}
                                </select>
                          </p>
                          <p>
                             <label>職系→</label> 
                                <select title="職系" name="duty_cd" id="duty_cd">
                                    {$duty_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>任職文號→</label> 
                                <input type="text" title="任職文號" name="doc" id="doc" />
                                <span style='margin-left:385px;'><input type='button' class='del' value='X' title='放棄此筆記錄' /></span>
                          </p>
                          <p>
                             <label>免職文號→</label> 
                                <input type="text" title="免職文號" name="end_doc" id="end_doc" />
                          </p>                       
                          <p>
                             <label>異動原因→</label> 
                                <select title="異動原因" name="out_reason_cd" id="out_reason_cd">
                                    {$out_reason_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>銓敘核定文號→</label> 
                                <input type="text" title="銓敘核定文號" name="qual_doc" id="qual_doc" value="{$obj->qual_doc}" /> 
                          </p>                           
                          <p>
                             <label>銓敘審定結果→</label> 
                                <select title="銓敘審定結果" name="qual_cd" id="qual_cd">
                                    {$qual_cd_o}
                                </select>
                          </p>
                          <p>
                             <label>銓敘審定官職等→</label> 
                                <select title="銓敘審定官職等" name="pub_qual_cd" id="pub_qual_cd">
                                    {$pub_qual_cd_o}
                                </select>
                          </p>                            
                          <p>
                             <label>俸級→</label> 
                                <input type="text" title="俸級" name="lev" id="lev" /> 
                          </p>
                          <p>
                             <label>俸點→</label> 
                                <input type="text" title="俸點" name="point" id="point" /> 
                          </p> 
                          <p>
                             <label>銓敘生效日期→</label> 
                                <input type="text" title="銓敘生效日期" class="validate[optional,custom[date1]]" name="d_execute" id="d_execute" /> 
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
                   <input type='hidden' name="form_sent" id="form_sent" value="p10" />
                </form>
            </div>
        

HTML;
    }

if($_POST["ajax"]=="Y"){
    $init_js=<<<HTML
    <script type='text/javascript'>
       var xmlHttp;
       var querystring;
       var search_word;
       function createXMLHttpRequest(){
        if(window.ActiveXObject){
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        else if(window.XMLHttpRequest){
            xmlHttp=new XMLHttpRequest();
        }       
       }
       
       function search_value(){
        createXMLHttpRequest();
        var url="hp_sketch_proc_10_ajax.php";
        xmlHttp.open("POST",url,true);
        xmlHttp.onreadystatechange=handleStateChange;
        xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
        xmlHttp.send(querystring);
       }
       
       function createquerystring(arugment){
        search_word=arugment.value;
        querystring="search_word="+search_word;
       }
       
       function handleStateChange(){
            if(xmlHttp.readyState==4){
              if(xmlHttp.status==200){
                 printoption();
              }
           }
        }
       function printoption(){
               for(var i=0;i<$('.search_word').length;i++){
                 if($('.search_word:eq('+i+')').val()==search_word){
                   $('.torga_cd:eq('+i+')').remove();
                   $('.sel_parent:eq('+i+')').append($('<select></select>').attr({name: 'torga_cd',id: 'torga_cd'}).attr('class','torga_cd'));
                   $('.torga_cd:eq('+i+')').html(xmlHttp.responseText);
                  }
              }
       } 
    
        
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