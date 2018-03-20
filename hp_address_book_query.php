<?php
	session_start();
	if( !isset($_SESSION["id"]) ) {//還沒登入或已經登出的情況,返回index
		header("Location:index.php");
	}
	/*
 	 *2009/11/06
 	 *v1.01
 	 */
    include("inc/conn.php");
	include("inc/unlogin.php");
	function DBC()
	{
		$strBadChar = "',%,^,&,?,<,>,[,],{,},\,;,:,=," . chr(34) . "," . chr(0) . "," . chr(32) . "\"";
    	$arrBadChar = split(",",$strBadChar);
		$arrLength = count($arrBadChar);
		$error=false;
		foreach(func_get_args() as $strChar) {
			$tempChar = $strChar;
    		for($i=0;$i<$arrLength;$i++)
			{
        		$pos = strpos($tempChar,$arrBadChar[$i]);
        		if($pos!==false){
					$error=true;
					break 2;
        		}
    		}
		}
		if($error===true)
			return false;
		else
			return true;
	}
	$options="<option value='' selected>請選擇其服務單位</option>";
	$query=pg_query("SELECT h0rtunit_.unit_cd, h0rtunit_.unit_name FROM h0rtunit_ WHERE h0rtunit_.unit_use='Y' ORDER BY h0rtunit_.unit_cd ASC");
	while($data=pg_fetch_array($query)){
		$options.="<option value='".$data['unit_cd']."'>".$data['unit_name']."</option>";
	}
	$ename="<option value='' selected>請選擇其姓名</option>";
	
	$query=pg_query("SELECT DISTINCT h0evbasic_union.c_name FROM h0evbasic_union WHERE (h0evbasic_union.unit_cd >= '0000') AND (h0evbasic_union.unit_cd <= 'ZZZZ') ORDER BY h0evbasic_union.c_name ASC");
	while($data=pg_fetch_array($query)){
		$ename.="<option value='".$data['c_name']."'>".$data['c_name']."</option>";
		// echo "-----------------";
	}
	
	if(isset($_POST['unit'])&&isset($_POST['e_name'])){
	
		//if(DBC($_POST['unit'],$_POST['e_name'])){
			if($_POST['unit']!="" && $_POST['e_name']==""){
				$options="<option value=''>請選擇其服務單位</option>";
				$query=pg_query("SELECT h0rtunit_.unit_cd, h0rtunit_.unit_name FROM h0rtunit_ WHERE h0rtunit_.unit_use='Y' ORDER BY h0rtunit_.unit_cd ASC");
				while($data=pg_fetch_array($query)){
					$options.=($data['unit_cd']==$_POST['unit']) ? "<option value='".$data['unit_cd']."' selected>".$data['unit_name']."</option>" : "<option value='".$data['unit_cd']."'>".$data['unit_name']."</option>";
				}
				$ename="<option value='' selected>請選擇其姓名</option>";
				$query=pg_query("SELECT DISTINCT h0evbasic_union.c_name FROM h0evbasic_union WHERE (h0evbasic_union.unit_cd = '".$_POST['unit']."') ORDER BY h0evbasic_union.c_name ASC");
				if(pg_num_rows($query)<1)
					$ename="<option value='' selected>查無資料</option>";
				else{
					while($data=pg_fetch_array($query)){
						$ename.="<option value='".$data['c_name']."'>".$data['c_name']."</option>";
					}
				}
			}
			elseif($_POST['e_name']!=""){
					$unit_cd=$_POST['unit'];
					$e_name=$_POST['e_name'];
					$sql="SELECT h0btbasic_per.staff_cd, h0btbasic_per.c_name, h0btbasic_per.sex, h0btbasic_per.ext, h0btbasic_per.pem_addr, h0btbasic_per.phone2, h0rtunit_.unit_name, h0rttilte_.title_name ";
					$sql.="FROM h0btbasic_per, h0evbasic_union, h0rtunit_, h0rttilte_ WHERE (h0btbasic_per.staff_cd = h0evbasic_union.staff_cd) ";
					$sql.="AND (h0evbasic_union.title_cd = h0rttilte_.title_cd) AND (h0evbasic_union.unit_cd = h0rtunit_.unit_cd) AND ((h0evbasic_union.c_name = '".$e_name."') AND ";
					$sql.=($unit_cd!="") ? "(h0evbasic_union.unit_cd = '".$unit_cd."'))" : "(h0evbasic_union.unit_cd >= '0000') AND (h0evbasic_union.unit_cd <= 'ZZZZ'))";
					$query=pg_query($sql) or die($sql);
					if(pg_num_rows($query)<1){
						$result_address="查無資料!";
					}else{
						while($data=pg_fetch_array($query)){
							$sex=($data['sex']=="1")? "男":"女";
							$result_address.="<tr><!--hr width='600px'-->
													<td>單位：</td>
													<td>".$data['unit_name']."</td>
											  </tr>
											  <tr>
													<td>職稱：</td>
													<td>".$data['title_name']."</td>
											 </tr>
											 
											 <tr>
													<td>姓名：</td>
													<td>".$data['c_name']."&nbsp;</td>
											 </tr>
											 <tr>
											 <td>性別：</td>
											 <td>".$sex."</td>
											 </tr>";
							$result_address.="<tr>
												<td>學校分機：</td>
												<td>".$data['ext']."&nbsp;&nbsp;&nbsp;&nbsp;</td>
											  </tr>
											  <tr>
												<td>聯絡電話：</td>
												<td>".$data['phone2']."&nbsp;&nbsp;&nbsp;&nbsp;</td>
											  </tr>
											  <tr>
												  <td>電子郵件：</td>
												  <td>".$data['pem_addr']."</td>
											  </tr>";
						}
					}
			}
		//}else{
		//	$msg="請輸入合法的字元";
		//}
	}
?>
<div id="maincontent">
<div style= "width: 100%; background-color: #eee;border: 1px solid #333; padding:3 5 0 5; margin: 0px;">
<div class="spacer"></div>
<div class="row">
<span class="left">主選單>通訊錄查詢</span>
</div>
<div class="spacer"></div>
</div>
<form name="search" id="search" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<center>
	<br />
	<h2>國立中正大學教職員工通訊錄查詢作業</h2>
	<br />
	<div style="/*width:300px;text-align:left;*/">
	<table style="width:100%">
		<tr>
			<td colspan="2">
				請輸入其單位與姓名
			</td>
		<tr>
		<tr>
			<td>
				單位：
			</td>
			<td>
				<select id="unit" name="unit" size="1" onChange="javascript:changeUnit(this.value);void(0);"><?php echo $options;?></select>
			</td>
		<tr>
		<tr>
			<td>
				姓名：
			</td>
			<td>
				<select id="e_name" name="e_name" size="1"><?php echo $ename;?></select>
			</td>
		<tr>
		<tr>
			<td colspan="2">
				<p><input type="submit" value="查詢"></p>
			</td>
		<tr>
	</table>
	<script type='text/javascript'>
			function changeUnit(val){
				if(val!=""){
					document.getElementById("e_name").value=="";
					document.getElementById("search").submit();
				}
			}
	</script>
	</div>
	<p><font color="#ff0000"><?php echo $msg;?></font></p>
	</center><div id="rr" style="font-color:#000000;font-size:16px;font-weight:bold;">
		<table style="width: 100%;">
			<?php echo $result_address;?>
			
		</table>
	</div>
	
<!--	<script language="javascript">
//		var aa=0;
//		if(aa==0){
//			document.getElementById("rr").innerHTML = "";
//			aa=aa+1;
//		}
//		alert(aa);
		
		
//	</script>
!-->
</form>
</div>
