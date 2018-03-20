<?php
session_start();
include("inc/conn.php");
define('FPDF_FONTPATH','fpdf/font/');
require_once ('fpdf/fpdf.php');
require_once ('fpdf/fpdf_tpl.php');
require_once ('fpdf/chinese-unicode.php');
require_once ('fpdf/fpdi.php');
include('inc/hp_work_check_function.php');


$yyymm_beg=$_GET['yyymm_beg'];
$yyymm_end=$_GET['yyymm_end'];
$staff_cd=$_GET['staff_cd'];

$pdf = new FPDI();
$pdf->AddUniCNShwFont('uni');
$pdf->Open();
$pdf->addPage();
$pdf->SetFont('uni','',20);
$pdf->Cell(40);
$pdf->Cell(110,14,"國立中正大學職員平時考核紀錄表附表", 0, 1, "C");

$sql="SELECT h0btbasic_per.staff_cd,h0btbasic_per.c_name,h0etchange.unit_cd,h0rtunit_.unit_name
      FROM h0btbasic_per,h0etchange,h0rtunit_
	  WHERE( h0btbasic_per.staff_cd=h0etchange.staff_cd) and
	  ( h0etchange.unit_cd=h0rtunit_.unit_cd) and
	  ( h0btbasic_per.is_current='1')AND
	  ( h0etchange.is_current in('Y','y')) AND
	  (h0btbasic_per.dist_cd='OFF' OR h0btbasic_per.dist_cd='UMI') and
	  (h0btbasic_per.staff_cd='".$staff_cd."')";
	  
	  if(pg_query($sql))
	  {
	  $result=pg_query($sql);
	  $data=pg_fetch_array($result);
	  }
	  else
	  {
	  echo "資料庫語法失敗";
	  }
$pdf->SetFont('uni','',14);
$pdf->Cell(65);
$pdf->Cell(15,8,"期間 : ".dateFormat($yyymm_beg)."  至  ".dateFormat($yyymm_end));
$pdf->Ln();
$pdf->SetFont('uni','',12);
$pdf->Cell(15,8,"身分證號碼/統一證號 : ".idFormat($data['staff_cd']));
$pdf->Cell(60);	  
$pdf->Cell(15,8,"中文姓名：".$data['c_name']);
$pdf->Cell(30);	
$pdf->Cell(15,8,"單位：".$data['unit_name']);
$pdf->Ln();

$pdf->SetFont('uni','B',14);
$pdf->Cell(25,8,"工作年月",1,0,"C");
$pdf->Cell(15,8,"序號",1,0,"C");
$pdf->Cell(150,8,"重要工作項目",1,0,"C");
$pdf->Ln();
$pdf->SetFont('uni','',12);
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
          (h0bt_work_check_rec.staff_cd>='".$staff_cd."') AND
		  (h0bt_work_check_rec.staff_cd<='".$staff_cd."') AND
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
	  
	   while($data=pg_fetch_array($result))
	  {   
	     for($i=0;$split_string=mb_substr(n_to_w(trim($data['work_item'])),$i,35,"UTF8");$i=$i+35){
	      $pdf->Cell(25,8,dateFormat($data['work_yyymm']),"T,L,B,R",0,"C");
	      $pdf->Cell(15,8,$data['seri_no'],"T,L,B,R",0,"C");
          $pdf->Cell(0,8,$split_string,"T,L,B,R",1,"L");
          $split_string="";
          }
	  }
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('uni','',14);
$pdf->Cell(15,8,"填表人：");
$pdf->Cell(90);
$pdf->Cell(15,8,"單位主管：");	
$pdf->Output();
?>