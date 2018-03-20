

(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = 	{
					"required":{    			// Add your regex rules here, you can take telephone as an example
						"regex":"none",
						"alertText":"* 此為必填欄位",
						"alertTextCheckboxMultiple":"* 請選擇一個選項",
						"alertTextCheckboxe":"* 請勾選一個選項"},
					"length":{
						"regex":"none",
						"alertText":"*字元須介於 ",
						"alertText2":" 到 ",
						"alertText3": " 個之間"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"* Checks allowed Exceeded"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"* Please select ",
						"alertText2":" options"},	
					"confirm":{
						"regex":"none",
						"alertText":"* 兩個欄位所填資料不一樣"},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ \#]+$/",
						"alertText":"* 電話格式錯誤"},	
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"* E-mail格式錯誤"},	
					"date1":{
                         "regex":"/^[0-1]{1}[0-9]{2}[0-1]{1}[0-9]{1}[0-3]{1}[0-9]{1}$/",
                         "alertText":"* 錯誤的日期格式，必須為民國年月日yyymmdd，如0991201"},
                    "date2":{
                         "regex":"/^[0-1]{1}[0-9]{2}[0-1]{1}[0-9]{1}$/",
                         "alertText":"* 錯誤的日期格式，必須為民國年月yyymm，如09912"},
                    "date3":{
                         "regex":"/^[0-1]{1}[0-9]{2}$/",
                         "alertText":"* 錯誤的日期格式，必須為民國年yyy，如099"},
					"onlyNumber":{
						"regex":"/^[0-9]+$/",
						"alertText":"* 只能是數字"},
 					"_id":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"* 不合法的身分證字號格式",
                        "alertText2":" (第一個字母須為大寫)"},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"* 只能是大小寫英文字母及數字"},	
					"ajaxUser":{
						"file":"validateUser.php",
						"extraData":"name=eric",
						"alertTextOk":"* This user is available",	
						"alertTextLoad":"* Loading, please wait",
						"alertText":"* This user is already taken"},	
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"* This name is already taken",
						"alertTextOk":"* This name is available",	
						"alertTextLoad":"* Loading, please wait"},		
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \'\-]+$/",
						"alertText":"* 只能是英文字母"},
					"validate2fields":{
    					"nname":"validate2fields",
    					"alertText":"* You must have a firstname and a lastname"}	
					}	
					
		}
	}
})(jQuery);

$(document).ready(function() {	
	$.validationEngineLanguage.newLang()
});