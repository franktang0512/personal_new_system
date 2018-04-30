<?php
$title_cd = $_GET['title_cd'];
include("inc/conn.php");
$sql    = "SELECT h0rtunit_.unit_cd,h0rtunit_.unit_name,
                     count(h0btbasic_per.staff_cd) as total_cnt,
                     SUM((case when h0btbasic_per.path=null then 0 when h0btbasic_per.path='' then 0 ELSE 1 end)) AS num 
                     FROM h0btbasic_per,h0etchange,h0rtunit_ 
                    WHERE ( h0etchange.staff_cd = h0btbasic_per.staff_cd ) 
                      and ( h0rtunit_.unit_cd = h0etchange.unit_cd ) 
                      and ( ( h0btbasic_per.is_current = '1' ) 
                      AND ( h0etchange.is_current in ('Y','y') ) 
                       and( h0etchange.dist_cd not in( '8','2') ) )  
                  GROUP BY h0rtunit_.unit_cd, h0rtunit_.unit_name
                  ORDER BY h0rtunit_.unit_cd ASC";
$result = pg_query($sql);

$item_content .='
<link href="css/show_pic.css" rel="stylesheet" type="text/css" />
<div class="w3-container" style="width: 700px;">
   <div class="w3-bar w3-black">
      <button class="w3-bar-item w3-button tablink w3-red" onclick="openCity(event,\'title\')">依職稱瀏覽</button>
      <button class="w3-bar-item w3-button tablink" onclick="openCity(event,\'unit\')">依單位瀏覽</button>
   </div>   
   <div id="title" class="w3-container w3-border city" style="">
      <table width="200" border="1" align="center">
         <tr>
            <td><a href="pic_title_view.php?title_type=0">校長、副校長</a></td>
         </tr>
         <tr>
            <td><a href="pic_title_view.php?title_type=1">一級主管</a></td>
         </tr>
         <tr>
            <td><a href="pic_title_view.php?title_type=2">二級主管</a></td>
         </tr>
         <tr>
            <td><a href="pic_title_other.php?title_type=TEA">專任教師</a></td>
         </tr>
         <tr>
            <td><a href="pic_title_other.php?title_type=OFF">職員</a></td>
         </tr>
         <tr>
            <td><a href="pic_title_other.php?title_type=WOR">技工友</a></td>
         </tr>
         <tr>
            <td><a href="pic_title_other.php?title_type=UMI">專案工作人員</a></td>
         </tr>
      </table>
   </div>';
$item_content .='   
	<div id="unit" class="w3-container w3-border city" style="">
		<table border="1" align="center">
		   <tr>
			  <td width="67">
				 <div align="center">單位代碼</div>
			  </td>
			  <td width="174">
				 <div align="center">單位名稱</div>
			  </td>
			  <td width="67">
				 <div align="center">單位代碼</div>
			  </td>
			  <td width="174">
				 <div align="center">單位名稱</div>
			  </td>
		   </tr>';

while($row =pg_fetch_array($result)){
/*table shows here*/
$item_content .='
<tr>
	<td><a href="pic_unit_view.php?g_unit_cd='.trim($row['unit_cd']).'">'.$row['unit_cd'].'</a></td>
	<td><a href="pic_unit_view.php?g_unit_cd='.trim($row['unit_cd']).'">'.$row['unit_name'].'</a></td>

';
	$row =pg_fetch_array($result);
	if(!empty($row)){
		$item_content .='

			<td><a href="pic_unit_view.php?g_unit_cd='.trim($row['unit_cd']).'">'.$row['unit_cd'].'</a></td>
			<td><a href="pic_unit_view.php?g_unit_cd='.trim($row['unit_cd']).'">'.$row['unit_name'].'</a></td>
		</tr>
		';
	}else if(empty($row)){
		$item_content .='

			<td>'."&nbsp".'</td>
			<td>'."&nbsp".'</td>
		</tr>
		';
	}
}		 
$item_content .='
		</table>
	</div>
</div>';

?>