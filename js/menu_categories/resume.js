
            function createXmlHttpRequest(){
                if (window.XMLHttpRequest){
                    var oHttp = new XMLHttpRequest();
                    return oHttp;
                }
                else if (window.ActiveXObject)
                {
                    var versions = 
                    [
                        "MSXML2.XmlHttp.6.0",
                        "MSXML2.XmlHttp.3.0"
                    ];
                    for (var i = 0; i < versions.length; i++)
                    {
                        try
                        {
                            var oHttp = new ActiveXObject(versions[i]);
                            return oHttp;
                        }
                        catch (error)
                        {
                          //do nothing here
                        }
                    }
                }
                return null;
            }
            function ajax(unit_cd){
                var personnel=document.getElementById("per");
                var pdf_link=document.getElementById("pdf_link");
                pdf_link.innerHTML="";
                if(unit_cd != "----"){
                    personnel.innerHTML="資料載入中, 請稍候";
                    var ajaxRequest=createXmlHttpRequest();
                    function request_readyStateChange()
                    {
                        if (ajaxRequest.readyState == 4){
                            if (ajaxRequest.status == 200){
                                personnel.innerHTML=ajaxRequest.responseText;                    
                            }else
                                personnel.innerHTML="錯誤! 狀態:" + ajaxRequest.status;
                        }
                    }
                    var param="unit_cd="+unit_cd;
                    ajaxRequest.open("POST","hp_sketch_rtp_ajax.php",true);
                    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajaxRequest.setRequestHeader("Content-length", param.length);
                    ajaxRequest.setRequestHeader("Connection", "close");
                    ajaxRequest.onreadystatechange = request_readyStateChange;
                    ajaxRequest.send(param);
                }else{
                    personnel.innerHTML="請於上方選單中選擇單位";
                    pdf_link.innerHTML="";
                }
            }
                        function printLink(value){
                var p_id=document.getElementById("p_id");
                var pdf_link=document.getElementById("pdf_link");
                if(value!='--'){
                    pdf_link.innerHTML="<center><br/><font size='4'>點選下方連結來進行對 <b>"+p_id.options[p_id.selectedIndex].text+"</b> 的履歷資料修改</font>";
                    pdf_link.innerHTML+="<br><a href='hp_sketch_proc_main.php?pid="+value+"'><font size='3'>履歷資料修改</font></a></center>";
                }else{
                    pdf_link.innerHTML="";
                }
            }
        