function adminTeacherAndStaffManagement() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/admin_unit.php?dist_type=OFF", true);
  xhttp.send();
}

function adminTechStaffManagement() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/admin_unit.php?dist_type=WOR", true);
  xhttp.send();
}


function adminMakeICFile() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/ic.php", true);
  xhttp.send();
}

function adminResumeForm() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp_sketch_rtp.php?func=proc", true);
  xhttp.send();
}

function adminResumeToPDF() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("main_content").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("POST", "php/hp_sketch_rtp_ pdf.php", true);
  xhttp.send();
}


function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " w3-red";
}

/********************************************************************************/


/*
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
                    ajaxRequest.open("POST","php/hp_sketch_rtp_ajax.php",true);
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
                    pdf_link.innerHTML+="<br><a href='php/hp_sketch_proc_main.php?pid="+value+"'><font size='3'>履歷資料修改</font></a></center>";
                }else{
                    pdf_link.innerHTML="";
                }
            }
        
*/
