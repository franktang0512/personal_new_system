function checkForm()
{
	// 初步檢查使用者輸入的帳號及密碼是否正確
	var user = document.form1.temp_id.value;
	var pass = document.form1.pass.value;
	
	// 如果帳號or密碼空白,則顯示錯誤訊息,否則將帳號存入cookie中,以方便下次登入時直接呈現
	if (user == ''){
		alert('請輸入您的帳號！');
		return false;
        }
	else if (pass ==''){
		alert('為了資訊安全起見，請勿使用空白密碼！');
		return false;
	}
	else{
		set_procookie('persys_cookie',document.forms[0].id.value);
		return true;
	}
}
     
function sf(){
	// 系統開啟時,要將游標預設停在帳號or密碼欄位上
	var user = get_cookie('persys_cookie');
	
	// 一開始先預設停在帳號欄位
	document.form1.temp_id.focus();
	
	if (user != null){
		// 若帳號先前已有輸入,則預設停在密碼欄位上
		document.form1.id.value = user;
		var temp = user.substr(0,4);
		var templen = user.length - 4;
		var i;
		for(i = 1;i <= templen;i++){
			temp +=  '*' ;
		}
		document.form1.temp_id.value = temp;
		document.form1.pass.focus(); 
	}
}

function star(){
	// 將使用者所輸入的帳號轉成大寫,且前四碼保留明碼,後面以星號(*)取代	
	var c = document.form1.temp_id.value.length;
	var i;
	var ls_flag = 1;	// 預設字串中沒有*號
	var temp;
	var ls_data = '';
	
	if(c <= 4){
		var temp = document.form1.temp_id.value.toUpperCase()
		document.form1.id.value = temp;
		document.form1.temp_id.value = temp;
	}
	else{
		// 檢查看字串中有沒有*號
		for(i = 1;i <= c;i++){
			temp = document.form1.temp_id.value.charAt(i-1);
			if(temp == '*'){
				// 表示字串中有*號
				ls_flag = 2;
			}	
		}
		
		if(ls_flag==1){	
			// 表示字串中沒有*號		
			document.form1.id.value = document.form1.temp_id.value.toUpperCase();
			document.form1.temp_id.value = document.form1.temp_id.value.toUpperCase();
			for(i = 1;i <= c;i++){
				temp = document.form1.temp_id.value.charAt(i-1);
				if (i > 4){
					ls_data = ls_data + '*';
				}
				else{
					ls_data = ls_data + temp;
				}
			}
			document.form1.temp_id.value = ls_data;
		}
		else{
			// 表示字串中有*號
			// 因為使用者可能刪除某個字元,或在字串中增加某個字元,就目前而言,無法得知使用者的操作內容,因此只能就
			// 帳號長度不一樣時,才觸發此段程式			
			if(document.form1.temp_id.value.length != document.form1.id.value.length){
				temp = document.form1.temp_id.value.charAt(c-1);
				temp = temp.toUpperCase();
				document.form1.id.value += temp;
				temp = document.form1.id.value.substr(0,4);
				temp = temp.toUpperCase();
				for(i = 4;i < c;i++){
					temp +=  '*' ;
				}
				document.form1.temp_id.value = temp;
			}
		}
	}
	
	// 將cookie的值清除
	delete_cookie('persys_cookie');
}

function key_end(){
	// 將使用者所輸入的帳號轉成大寫,且前四碼保留明碼,後面以星號(*)取代	
	var c = document.form1.temp_id.value.length;
	var i;
	var ls_flag = 1;	// 預設字串中沒有*號
	var temp;
	var ls_data = '';
	
	for(i = 1;i <= c;i++){
		temp = document.form1.temp_id.value.charAt(i-1);
		if(temp == '*'){
			// 表示字串中有*號
			ls_flag=2;
		}	
	}
	
	if(ls_flag==1){
		// 表示字串中沒有*號	
		document.form1.id.value = document.form1.temp_id.value.toUpperCase();
		document.form1.temp_id.value = document.form1.temp_id.value.toUpperCase();
		for(i = 1;i <= c;i++){
			temp = document.form1.temp_id.value.charAt(i-1);
			if (i > 4){
				ls_data = ls_data + '*';
			}
			else{
				ls_data = ls_data + temp;
			}
		}
		document.form1.temp_id.value = ls_data;
	}
}

var today = new Date();
var end_day = new Date();
var mspermonth = 24 * 3600 * 1000 * 31;
end_day.setTime(today.getTime() + mspermonth);

function set_procookie(cookiename,cookievalue){
	// 將資料存入cookie中,以方便下次使用時直接取出
	document.cookie=cookiename +"=" + cookievalue +"; expires=" + end_day.toGMTString();
}

function get_cookie(key){
	// 將儲存在cookie中的值取出
	var search = key + "=";
	
	begin= document.cookie.indexOf(search);
	
	if(begin != -1){
		begin += search.length;
		end = document.cookie.indexOf(";",begin);
		if(end == -1){
			end = document.cookie.length;
		}
		return document.cookie.substring(begin,end);		
	}
}

function delete_cookie(cookie_name){
	// 將cookie的值清除
	today.setTime(today.getTime() - 1);
	document.cookie = cookie_name += "=; expires=" + today.toGMTString();
}

function MM_reloadPage(init){  
	// 設定網頁之大小
	if (init==true) with (navigator){
		if ((appName=="Netscape")&&(parseInt(appVersion)==4)){
    			document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; 
    		}
    	}
	else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH){
		location.reload();
	}
}
MM_reloadPage(true);

function ToUpperCase()
{
	var temp = document.form1.temp_id.value.toUpperCase()
	document.form1.id.value = temp;
	document.form1.temp_id.value = temp;
}