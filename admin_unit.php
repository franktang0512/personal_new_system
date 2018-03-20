<?php
include('inc/header.php');

extract($_SESSION);
if (!isset($id) || $_SESSION["basic_dist_cd"]!="ADMIN") { 
	//未登入返回index
    header("Location:index.php");
}
include('admin_.php');
extract($_GET);
$sql="";
if ($dist_type == "WOR"){
$sql="SELECT h0rtunit_.unit_cd,h0rtunit_.unit_name,count(h0btbasic_per.staff_cd) as total_cnt,SUM((case when h0btbasic_per.path=null then 0 when h0btbasic_per.path='' then 0 ELSE 1 end)) AS num FROM h0btbasic_per,h0etchange,h0rtunit_ WHERE ( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and ( h0rtunit_.unit_cd = h0etchange.unit_cd ) and ( ( h0btbasic_per.is_current = '1' ) AND ( h0etchange.is_current in ('Y','y') ) and( h0etchange.dist_cd = '8'  ) ) GROUP BY h0rtunit_.unit_cd, h0rtunit_.unit_name ORDER BY h0rtunit_.unit_cd ASC";
}else{
$sql="SELECT h0rtunit_.unit_cd,h0rtunit_.unit_name,count(h0btbasic_per.staff_cd) as total_cnt,SUM((case when h0btbasic_per.path=null then 0 when h0btbasic_per.path='' then 0 ELSE 1 end)) AS num FROM h0btbasic_per,h0etchange,h0rtunit_ WHERE ( h0etchange.staff_cd = h0btbasic_per.staff_cd ) and ( h0rtunit_.unit_cd = h0etchange.unit_cd ) and ( ( h0btbasic_per.is_current = '1' ) AND ( h0etchange.is_current in ('Y','y') ) and( h0etchange.dist_cd not in( '8','2')  ) ) GROUP BY h0rtunit_.unit_cd, h0rtunit_.unit_name ORDER BY h0rtunit_.unit_cd ASC";	
}
$result = pg_query($sql);
	
$item_content = '
<div id="main_content">
<p align="center">
<font color="#0033CC" size="5">
<strong>中正大學各行政、教學單位';
if($dist_type == "WOR"){
	$item_content.='(技工友管理介面)';
}else{
	$item_content.= '(教職員管理介面)';
}
$item_content.='
</strong>
</font></p>
<table style="margin-bottom: 25px; " width="90%" border="10" align="center">
<tr>
<th width="30%" align="center" bgcolor="yellow">單位代碼/名稱</th>
<th width="10%" align="center" bgcolor="yellow">總人數</th>
<th width="10%" align="center" bgcolor="yellow">上傳人數</th>
<th width="30%" align="center" bgcolor="yellow">單位代碼/名稱</th>
<th width="10%" align="center" bgcolor="yellow">總人數</th>
<th width="10%" align="center" bgcolor="yellow">上傳人數</th>
</tr>';
while($row =pg_fetch_array($result)){
	if($row['total_cnt'] != $row['num']){
		$item_content.='
		<tr>
			<td width="30%">
			<a onclick="teaProfUpgrade()" href="admin_pic.php?dist_type='.$dist_type.'&g_unit_cd='.trim($row['unit_cd']).'&g_unit='.trim($row['unit_name']).'">
			'.$row['unit_cd'].$row['unit_name'].'
			</a>
			</td>
			
			<td width="10%" align="right">
			<font color= red>'.$row['total_cnt'].'
			</font>
			</td>
			<td width="10%" align="right">
			<font color= red>'.$row['num'].'
			</font>
			</td>';

	}else{
		$item_content.='
		<tr>
			<td width="30%">
			<a onclick="teaProfUpgrade()"href="admin_pic.php?dist_type='.$dist_type.'&g_unit_cd='.trim($row['unit_cd']).'&g_unit='.trim($row['unit_name']).'">
			'.$row['unit_cd'].$row['unit_name'].'
			</a>
			</td>			
			<td width="10%" align="right">
			<font>'.$row['total_cnt'].'
			</font>
			</td>
			<td width="10%" align="right">
			<font>'.$row['num'].'
			</font>
			</td>';
		
	}		
	//注意此處的td標籤結束後為了讓下一筆資料能在同一列先不做tr標籤閉合
	if($row =pg_fetch_array($result)){
		
		if($row['total_cnt'] != $row['num']){
			//繼續下一個資料的td呈現
			$item_content.='
				<td width="30%"><a href="admin_pic.php?dist_type='.$dist_type.'&g_unit_cd='.trim($row['unit_cd']).'&g_unit='.trim($row['unit_name']).'">'.$row['unit_cd'].$row['unit_name'].'</a></td>
				<td width="10%" align="right">
				<font color= red>'.$row['total_cnt'].'
				</font>
				</td>
				<td width="10%" align="right">
				<font color= red>'.$row['num'].'
				</font>
				</td>
			</tr>';
			//此處才對tr標籤作閉合後換下一列，不然一列只會出現一筆資料
		}else{
			//繼續下一個資料的td呈現
			$item_content.='
				<td width="30%"><a href="admin_pic.php?dist_type='.$dist_type.'&g_unit_cd='.trim($row['unit_cd']).'&g_unit='.trim($row['unit_name']).'">'.$row['unit_cd'].$row['unit_name'].'</a></td>
				<td width="10%" align="right">
				<font>'.$row['total_cnt'].'
				</font>
				</td>
				<td width="10%" align="right">
				<font>'.$row['num'].'
				</font>
				</td>
			</tr>';
			//此處才對tr標籤作閉合後換下一列，不然一列只會出現一筆資料
		}
	}
}
$item_content.='
</table>
</div>';
$content = $slide_menu . $item_content;
echo $content;
include('inc/footer.php');
?>