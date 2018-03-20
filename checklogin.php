<?php
header("Content-Type:text/html;charset=utf-8");
	session_start();
	include("inc/conn.php");
	include("inc/func.php");

	// 註冊session值,因為教專系統也會直接呼叫人事系統的網頁,因此若這邊的
	// session變數有增減的話,則教專系統的/research/whitepage3.php也要同步增減
   /* $_SESSION("name");
	$_SESSION("id");
	$_SESSION("dist_cd");
	$_SESSION("basic_dist_cd");
	$_SESSION("title_cd");
	$_SESSION("prefix");
	$_SESSION("call_main");
	*/ 
	$_SESSION["call_main"]="person";

    echo "<div style='margin-top:200px; margin-right:auto; margin-left:auto; width:500px;'>";
	if($_POST["id"] == "ADMIN" && $_POST["pass"] == "ccuadmin"){
		// 如果是管理者,則不需從資料庫中取得密碼檢核
		$_SESSION["name"]="管理者";
	    $_SESSION["id"]=$_POST["id"];
	    $_SESSION["dist_cd"]="X";
        $_SESSION["basic_dist_cd"]=$_POST["id"]; // 後續menu.php會使用到
		$_SESSION["title_cd"]="X";
		$_SESSION["prefix"]="同仁您好";
		$auth=crypt("!ssap!");       
		header("Location:login_ok.php?op=$auth");
		
	}
	else{
		//2014/06/20 sso代簽入機制修改
				
		$pID = $_POST["id"];
		$pPass = $_POST["pass"];
		
		if( empty($_POST)  &&  isset($_SESSION['verifySso'])  &&  $_SESSION['verifySso']=='Y' ) {
			$pID = $_SESSION['sso_personid'];
		}else{									//  如果不是從 SSO 登入才需要驗證帳號密碼--1011027--hueyping
		     //防止SQL injection,先驗證帳號密碼--1011027
		 	Verify_ID($pID);
		 	Verify_Password($pPass);

	  }

		// 如果非管理者的話,則要從帳號檔中取得資料來檢核
		// 
		
		//將使用者輸入的密碼加密處理
		$pPass = encode($_POST["pass"]);
		
		$sql= "SELECT password FROM x00tpseudo_uid_ WHERE staff_cd= '".$pID."'";
		$result =pg_query($sql);
		$numOfrow =pg_num_rows($result);
		if ($numOfrow <= 0){
			// 若權限檔中查無此使用者,則出現錯誤訊息
			$errmsg = "查無您所輸入的使用者帳號,請重新輸入";			
		}
		else{
			
			// 若權限檔中有查到該使用者,則比對密碼是否正確
			$row=pg_fetch_array($result);
			
			//2011/10/31 sso代簽入機制修改,從sso過來的不需要驗證密碼
			$checkPass = false;
			if( empty($_POST)  AND  isset($_SESSION['verifySso'])  AND  $_SESSION['verifySso']=='Y' ) {
				$checkPass = true;
			} else {
                $password=$row['password'];
				if(chop($password) == chop($pPass))
					$checkPass = true;
				else
					$checkPass = true;//暫時讓密碼驗證失效
			}
       		if($checkPass){
       			// 密碼比對正確,則再查詢人事基本資料檔,看是否有此資料
				$sql2="SELECT h0btbasic_per.staff_cd, 
                              h0btbasic_per.c_name,
                              h0etchange.dist_cd, 
                              h0etchange.title_cd, 
                              h0rtdist_.basic_dist_cd,
                              h0btbasic_per.is_current 
                         FROM h0btbasic_per,
                              h0etchange, 
                              h0rtdist_ 
                        WHERE (h0etchange.staff_cd = h0btbasic_per.staff_cd) 
                          AND (h0rtdist_.dist_cd = h0etchange.dist_cd )
						  AND (h0rtdist_.basic_dist_cd = h0btbasic_per.dist_cd)
                          AND (h0etchange.is_current in ('y','Y'))
                          AND (h0btbasic_per.staff_cd='".$pID."' OR h0btbasic_per.resident='".$pID."')";
				$result2 =pg_query($sql2);
				$numOfrow2 = pg_num_rows($result2);
				if ($numOfrow2 <= 0){
					// 若人事基本資料檔中查無此使用者,則出現錯誤訊息
					$errmsg = "查無您的人事基本資料,此系統僅提供本校教職員工使用!!";
				}
				else{
					// 若人事基本資料檔中有此使用者之資料,則要再判斷是否在職
					$row2=pg_fetch_array($result2);
					if($row2['is_current']==1){
						// 在職
						$_SESSION["name"]=$row2['c_name'];
						$_SESSION["id"]=$row2['staff_cd'];
						$_SESSION["dist_cd"]=$row2['dist_cd'];
                        $_SESSION["temp_dist_cd"]=$_SESSION["dist_cd"];
						$_SESSION["basic_dist_cd"]=$row2['basic_dist_cd'];
						$_SESSION["title_cd"]=$row2['title_cd'];

						if (($_SESSION["basic_dist_cd"]=="TEA" && $_SESSION["dist_cd"]!='5') || $_SESSION["basic_dist_cd"]=="PRO" || $_SESSION["basic_dist_cd"]=="PRT")
							$_SESSION["prefix"]="老師您好";
						else	
							$_SESSION["prefix"]="同仁您好";	 	   					

						$auth=crypt("!ssap!");
						header("Location:login_ok.php?op=$auth");
					}
					else{
						// 非在職
						$errmsg = "此系統僅提供本校在職之教職員工使用!!";
					}
				}
			}
			else{
				// 密碼比對錯誤
				$errmsg = "密碼輸入錯誤,請重新輸入";
			}
		}
	}

	// 錯誤訊息顯示
	echo "您所輸入的帳號為：<font color=red>".$_POST["id"]."</font><br><br>";
	echo "您所輸入的密碼為：<font color=red>".$_POST["pass"]."</font><br><br>";
	echo "帳號和密碼確認結果";
	echo $errmsg."<br><br>";
	echo "<a href=\"index.php\">回上一頁</a>&nbsp;&nbsp;&nbsp;";
	echo "<a href=\"http://mis.cc.ccu.edu.tw/account/common/query_pwd.php\" target=\"_blank\">密碼查詢</a>";
	echo "</div>";
	header("Refresh: 1; url=index.php");
	
		////////  檢查 ID 是否正確: 只含大寫英文和數字
	function Verify_ID($pID)
	{
		if( preg_match("/^[A-Z0-9]{10}$/", $pID) )  return;
		else {
			echo "帳號必須為10碼英數字!";
			header("Refresh: 1; url=index.php");
			
			// die("帳號必須為10碼英數字!");

		}
	}
	/////////  檢查密碼是否正確: 只含大小寫英文和數字以及部分的特殊字元!@$^_-
	function Verify_Password($pPass)
	{
	  if( preg_match("/^[a-zA-Z0-9!@\$\^_-]{5,15}$/", $pPass) )  return;
	  else{
		echo "密碼必須5-15碼英數字及部分的特殊字元!@$^_-";
		header("Refresh: 1;url=index.php");
		// die("");
	  }
	    
		
	}