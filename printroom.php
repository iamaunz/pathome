<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}
require_once 'include/DB_Functions.php';
$db = new DB_Functions();




require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');



//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('freeserif', '', 14);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content

$output = $db->selectDataByid('Tb_room',' * ',' AND `id` = '.$_GET['id'].' ');
//$rentper = $db->getMeter($_GET['id'],$_GET['month'],$_GET['year']);
//$rentperlast = $db->getMeterLastMonth($_GET['id'], $_GET['month']-1); //-- เลขหลัง

if($_GET['month'] == "1"){
	$meter = $db->getMeterTwoLastMonthDESC($_GET['id'], 13, $_GET['year']);
}else{
	$meter = $db->getMeterTwoLastMonthDESC($_GET['id'], $_GET['month'], $_GET['year']);
}

//$meter = $db->getMeterTwoLastMonthDESC($_GET['id'], $_GET['month'], $_GET['year']);
$cmonth = $meter[0];
$pmonth = $meter[1];

$chkMonth = $db->checkMeterWithMonth($_GET['id'], $_GET['month'], $_GET['year']);

$month = array("1"=>"มกราคม",
			   "2"=>"กุมภาพันธ์",
			   "3"=>"มีนาคม",
			   "4"=>"เมษายน",
			   "5"=>"พฤษภาคม",
			   "6"=>"มิถุนายน",
			   "7"=>"กรกฎาคม",
			   "8"=>"สิงหาคม",
			   "9"=>"กันยายน",
			   "10"=>"ตุลาคม",
			   "11"=>"พฤศจิกายน",
			   "12"=>"ธันวาคม"
			   );
			   
$month_sh = array("1"=>"มค",
			   "2"=>"กพ",
			   "3"=>"มีค",
			   "4"=>"เมย",
			   "5"=>"พค",
			   "6"=>"มิย",
			   "7"=>"กค",
			   "8"=>"สค",
			   "9"=>"กย",
			   "10"=>"ตค",
			   "11"=>"พย",
			   "12"=>"ธค"
			   );

$cur_month = $_GET['month'];
$pre_month = $_GET['month'] - 1;
if($pre_month < 1){
	$pre_month = 12;
}

if(count($chkMonth)==0){
	$recieptID = "-";
}else{
	$recieptID = $_GET['year'].$cmonth['id'];
}

$html = '
<table>
		<tr>
			<td valign="bottom" align="left" width="15%"><h3>เลขที่ห้อง</h3></td>
			<td valign="bottom" align="left" width="35%"><h2>'.$_GET['room'].'</h2></td>
			<td valign="bottom" align="right" width="25%"><h3>เลขที่&nbsp;&nbsp;&nbsp;</h3></td>
			<td valign="bottom" align="left" width="25%">'.$recieptID.'</td>
		</tr>
		
		<tr>
			<td valign="bottom" align="left"><h3>ประจำเดือน</h3></td>
			<td valign="bottom" align="left">'.$month[$_GET['month']].'</td>
			<td valign="bottom" align="right"><h3>วันที่&nbsp;&nbsp;&nbsp;</h3></td>
			<td valign="bottom" align="left">'.date('d/m/Y').'</td>
		</tr>
		
<tr>
			<td colspan="4">
			<hr>
					<table>
						<tr>
							<td width="3%" align="left"><b><u>ที่</u></b></td>
							<td width="22%" align="left"><b><u>รายการ</u></b></td>
							<td width="14%" align="right"><b><u>หน่วย '.$month_sh[$pre_month].'</u></b></td>
							<td width="14%" align="right"><b><u>หน่วย '.$month_sh[$cur_month].'</u></b></td>
							<td width="16%" align="right"><b><u>จำนวนที่ใช้</u></b></td>
							<td width="16%" align="right"><b><u>ราคาต่อหน่วย</u></b></td>
							<td width="15%" align="right"><b><u>รวม</u></b></td>	
						</tr>
						<tr>
							<td align="left">1</td>
							<td align="left">ค่าห้อง+ค่าเคเบิ้ล</td>
							<td align="right">-</td>
							<td align="right">-</td>
							<td align="right">1</td>
							<td align="right">'.number_format($output[0]['rent'],2).'</td>
							<td align="right">'.number_format($output[0]['rent'],2).'</td>	
						</tr>
						
						<tr>
							<td>2</td>';
							if(count($chkMonth)==0){ //-- ถ้ายังไม่เก็บหน่วยเดือนนี้ ให้แสดงค่าว่างทั้งหมด
								if($output[0]['chargeperunitGov']==1){
									$html .= '<td align="left">ค่าไฟ(องค์การ)</td>
										  <td align="right">-</td>
										  <td align="right">-</td>
									  	  <td align="right">-</td>
									  	  <td align="right">0</td>
										  <td align="right">0</td>';
								}else{
									$html .= '<td align="left">ค่าไฟ</td>
										  <td align="right">-</td>
										  <td align="right">-</td>
									  	  <td align="right">-</td>
									  	  <td align="right">0</td>
										  <td align="right">0</td>';
								}
							}else{
								if($output[0]['chargeperunitGov']==1){
									$html .= '<td align="left">ค่าไฟ(องค์การ)</td>
										  <td align="right">-</td>
										  <td align="right">-</td>
									  	  <td align="right">-</td>
									  	  <td align="right">-</td>
										  <td align="right">'.number_format($cmonth['charge'],2).'</td>';
									$total_elec = $cmonth['charge'];
								}else{
									$elec_pre_month = $pmonth['chargepermonth'];
									$elec_cur_month = $cmonth['chargepermonth'];
									$elec_unit = $elec_cur_month - $elec_pre_month;
									$price_per_unit = $output[0]['chargeperunit'];
									$total_elec = $elec_unit * $price_per_unit;
									$html .= '
										  <td align="left">ค่าไฟ</td>
										  <td align="right">'.$elec_pre_month.'</td>
										  <td align="right">'.$elec_cur_month.'</td>
										  <td align="right">'.number_format($elec_unit,0).'</td>
										  <td align="right">'.number_format($price_per_unit,2).'</td>
										  <td align="right">'.number_format($total_elec,2) .'</td>';
								}
							}
			
		$html .= '</tr>
			      <tr>
						<td>3</td>';
						if(count($chkMonth)==0){
							if($output[0]['waterperunitGov']==1){
								$html .= '<td align="left">ค่าน้ำ (องค์การ)</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">0</td>
									  <td align="right">0</td>';
							}else{
								$html .= '<td align="left">ค่าน้ำ</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">0</td>
									  <td align="right">0</td>';
							}
						}else{
							if($output[0]['waterperunitGov']==1){
								$html .= '<td align="left">ค่าน้ำ (องค์การ)</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">'.number_format($cmonth['water'],2).'</td>';
								$total_wate = $cmonth['water'];
							}else{
								$wate_pre_month = $pmonth['waterpermonth'];
								$wate_cur_month = $cmonth['waterpermonth'];
								$wate_unit = $wate_cur_month - $wate_pre_month;
								if($wate_unit < 6){ $wate_unit = 5; }
							
								$price_per_wunit = $output[0]['waterperunit'];
								$total_wate = $price_per_wunit * $wate_unit;

								$html .= '<td align="left">ค่าน้ำ</td>									  
									  <td align="right">'.$wate_pre_month.'</td>
									  <td align="right">'.$wate_cur_month.'</td>
									  <td align="right">'.number_format($wate_unit,0).'</td>
									  <td align="right">'.number_format($price_per_wunit, 2) .'</td>
									  <td align="right">'.number_format($total_wate, 2).'</td>	';
							}
						}
		
		$total_other = $cmonth['etc'];	
		$total_price = $output[0]['rent'] + $total_elec + $total_wate + $total_other;				
		$html .= '</tr>
						<tr>
						<td>4</td>
						<td>อื่นๆ</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align="right">'.number_format($total_other,2).'</td>	
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					</table>
			<hr>	
			</td>
		</tr>
		<tr>
			<td colspan="4" align="right">
			<b>รวมทั้งสิ้น</b>&nbsp;'.number_format($total_price,2).' <b>บาท</b>
			<hr>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="left" width="40%"><b>ผู้รับเงิน</b><hr></td>
			<td colspan="2" width="20%"></td>
			<td align="left" width="40%"><b>ผู้เช่า</b><hr></td>
			
		</tr>
</table>
<hr style="background-color:#fff;border:#000 1px dotted;border-style: none none dotted;color:#fff;">
<br>
<br>
หมายเหตุ1: จดหน่วยวันที่ 25 ของทุกเดือน<br>
หมายเหตุ2: กรุณาจ่ายเงินวันที่ 27-3 (ไม่เกินวันที่ 5)
<br>
<br>
<br>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');
?>


