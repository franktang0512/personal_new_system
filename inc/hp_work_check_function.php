<?php
 function search_query($yyymm_beg,$yyymm_end)
{ 
$sql="SELECT h0etchange.unit_cd FROM h0btbasic_per,h0etchange,h0rtunit_
	  WHERE( h0btbasic_per.staff_cd=h0etchange.staff_cd) and
	  ( h0etchange.unit_cd=h0rtunit_.unit_cd) and
	  ( h0btbasic_per.is_current='1')AND
	  ( h0etchange.is_current in('Y','y')) AND
	  (h0btbasic_per.dist_cd='OFF' OR h0btbasic_per.dist_cd='UMI') and
	  (h0btbasic_per.staff_cd='".$_SESSION['id']."')";
	  
	  if(pg_query($sql))
	  {
	  $result=pg_query($sql);
	  $data=pg_fetch_array($result);
	  }
	  else
	  {
	  echo "資料庫語法失敗";
	  }

$sql="SELECT h0bt_work_check_rec.staff_cd,
           h0btbasic_per.c_name,
		   h0etchange.unit_cd,
		   h0rtunit_.unit_name,
		   h0rttilte_.title_name,
		   h0bt_work_check_rec.work_yyymm,
		   h0bt_work_check_rec.seri_no,
		   h0bt_work_check_rec.work_item,
		   h0bt_work_check_rec.confirm_yn
	  FROM h0bt_work_check_rec,
          h0btbasic_per,
          h0etchange,
          h0rtdist_,
          h0rttilte_,
          h0rtunit_
      WHERE(h0bt_work_check_rec.staff_cd=h0btbasic_per.staff_cd) and
          (h0bt_work_check_rec.staff_cd=h0etchange.staff_cd) and
          (h0etchange.dist_cd=h0rtdist_.dist_cd) and
          (h0btbasic_per.dist_cd=h0rtdist_.basic_dist_cd) and
          (h0etchange.title_cd=h0rttilte_.title_cd) and
          (h0etchange.unit_cd=h0rtunit_.unit_cd) and
          ((h0etchange.unit_cd>='".$data['unit_cd']."') AND
          (h0etchange.unit_cd<='".$data['unit_cd']."') AND
          (h0bt_work_check_rec.staff_cd>='".$_SESSION['id']."') AND
		  (h0bt_work_check_rec.staff_cd<='".$_SESSION['id']."') AND
		  (h0bt_work_check_rec.work_yyymm>='".$yyymm_beg."') AND
		  (h0bt_work_check_rec.work_yyymm<='".$yyymm_end."') AND
		  (h0btbasic_per.dist_cd='OFF' OR
		  h0btbasic_per.dist_cd='UMI') AND
		  h0etchange.is_current in('Y','y') AND
		  h0btbasic_per.is_current='1')";
		  
	   if(pg_query($sql))
	  {
	    $result=pg_query($sql);
		
	  }
	   else
	  {
	    echo "資料庫語法失敗!";
	  }
      if(pg_num_rows($result)!=0)
      {
      ?>
      <a href="hp_work_check_pdf.php?yyymm_beg=<?php echo $yyymm_beg;?>&yyymm_end=<?php echo $yyymm_end;?>&staff_cd=<?php echo $_SESSION['id'];?>" target="_blank">產生平時考核記錄表</a>
      <table align="left" width=100%>
	  <thead>
	  <tr>
	    <th width=15%>工作年月</th>
	    <th width=10%>序號</th>
	    <th width=35%>重要工作項目</th>
	    <th width=25%>人事單位確認</th>
		<th width=15%>功能</th>
	 </tr>
	</thead>
      
      
<?php
	   while($data=pg_fetch_array($result))
	  {	  
?>
	   <tr>
	      <td><div align="center"><?php echo dateFormat($data['work_yyymm']);?></div></td>
		  <td><div align="center"><?php echo $data['seri_no'];?></div></td>
		  <td><div align="left"><textarea cols="30" rows="5" readonly><?php echo trim($data['work_item']);?></textarea></div></td>
		  <td><div align="center"><?php echo $data['confirm_yn'];?></div></td>
			  <td><div align="center">
			  <a <?php if($data['confirm_yn']!="Y") echo "href='javascript:delete_data({$data['work_yyymm']},{$data['seri_no']},{$yyymm_beg},{$yyymm_end})'";?>>刪除</a>
			  <a <?php if($data['confirm_yn']!="Y") echo "href='javascript:update_data({$data['work_yyymm']},{$data['seri_no']},{$yyymm_beg},{$yyymm_end})'";?>>修改</a>
			  </div></td>
	  </tr>
<?php
	  }
	   echo "</table>";
       }
        else
       {
        echo "<h1 style='color:red; text-align:center;'>查無資料!</h1>";
       }

}
function dateFormat($d){
		if(!$d)
			return "　";
	    $year=substr($d,0,3);
	    $month=substr($d,3,2);
	    $dates = $year."/".$month;
	    return $dates;
	}
function idFormat($id){
   $id=substr($id,0,5)."*****";
   return $id;    
}

 function test_database()
{   
       $sql="SELECT*FROM h0bt_work_check_rec";
	   
       if(pg_query($sql))
	  {
	    $result=pg_query($sql);	    
	 
	  }
	   else
	  {
	    echo "資料庫語法失敗";
	  }
	    echo "<table>";
	   while($data=pg_fetch_array($result))
	  {
	   echo "<tr>";
         for($i=0;$i<pg_num_fields($result);$i++)
	    {
	      echo "<td>".$data[$i]."</td>";
	    }
	      echo "</tr>";
	  }
	   echo "</table>";
}

  function delete_record()
{
      $sql='DELETE FROM h0bt_work_check_rec WHERE staff_cd="'.$_SESSION['id'].'"';
      $result=pg_query($sql);
  
}
 function n_to_w($strs, $types = '0'){  // narrow to wide , or wide to narrow
    $nt = array(
        "(", ")", "[", "]", "{", "}", ".", ",", ";", ":",
        "-", "?", "!", "@", "#", "$", "%", "&", "|", "\\",
        "/", "+", "=", "*", "~", "`", "'", "\"", "<", ">",
        "^", "_",
        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j",
        "k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
        "u", "v", "w", "x", "y", "z",
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J",
        "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T",
        "U", "V", "W", "X", "Y", "Z",
        " "
    );
    $wt = array(
        "（", "）", "〔", "〕", "｛", "｝", "﹒", "，", "；", "：",
        "－", "？", "！", "＠", "＃", "＄", "％", "＆", "｜", "＼",
        "／", "＋", "＝", "＊", "～", "、", "、", "＂", "＜", "＞",
        "︿", "＿",
        "０", "１", "２", "３", "４", "５", "６", "７", "８", "９",
        "ａ", "ｂ", "ｃ", "ｄ", "ｅ", "ｆ", "ｇ", "ｈ", "ｉ", "ｊ",
        "ｋ", "ｌ", "ｍ", "ｎ", "ｏ", "ｐ", "ｑ", "ｒ", "ｓ", "ｔ",
        "ｕ", "ｖ", "ｗ", "ｘ", "ｙ", "ｚ",
        "Ａ", "Ｂ", "Ｃ", "Ｄ", "Ｅ", "Ｆ", "Ｇ", "Ｈ", "Ｉ", "Ｊ",
        "Ｋ", "Ｌ", "Ｍ", "Ｎ", "Ｏ", "Ｐ", "Ｑ", "Ｒ", "Ｓ", "Ｔ",
        "Ｕ", "Ｖ", "Ｗ", "Ｘ", "Ｙ", "Ｚ",
        "　"
    );
 
    if ($types == '0'){
        // narrow to wide
        $strtmp = str_replace($nt, $wt, $strs);
    }else{
        // wide to narrow
        $strtmp = str_replace($wt, $nt, $strs);
    }
    return $strtmp;
}
?>