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
$result = $db->showRentPerMonth($_GET['year'],$_GET['month'],$_GET['id'],'','');

while($rs = mysql_fetch_array($result)){

$output = $db->selectDataByid('Tb_room',' * ',' AND `id` = '.$rs['idRoom'].' ');
$rentper = $db->getMeter($rs['idRoom'],$_GET['month'],$_GET['year']); //-- เลขก่อน
$rentperlast = $db->getMeterLastMonth($rs['idRoom'], $_GET['month']-1); //-- เลขหลัง

//echo "ID ROOM".$rs['idRoom'];
			
// A4 = 2480
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
$html = '
<table>
		<tr>
			<td valign="bottom" align="left" width="15%"><h3>เลขที่ห้อง</h3></td>
			<td valign="bottom" align="left" width="35%">'.$rs['roomName'].'</td>
			<td valign="bottom" align="right" width="25%"><h3>เลขที่&nbsp;&nbsp;&nbsp;</h3></td>
			<td valign="bottom" align="left" width="25%">'.date('Ym').$rentper[0]['id'].'</td>
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
							<td width="14%" align="right"><b><u>เลขหลัง</u></b></td>
							<td width="14%" align="right"><b><u>เลขก่อน</u></b></td>
							<td width="16%" align="right"><b><u>จำนวนที่ใช้</u></b></td>
							<td width="16%" align="right"><b><u>ราคาต่อหน่วย</u></b></td>
							<td width="15%" align="right"><b><u>รวม</u></b></td>	
						</tr>
						<tr>
							<td align="left">1</td>
							<td align="left">ค่าห้อง</td>
							<td align="right">-</td>
							<td align="right">-</td>
							<td align="right">1</td>
							<td align="right">'.number_format($output[0]['rent'],2).'</td>
							<td align="right">'.number_format($output[0]['rent'],2).'</td>	
						</tr>
						
						<tr>
							<td>2</td>';
							if($output[0]['chargeperunitGov']==1){
								$html .= '<td align="left">ค่าไฟ(องค์การ)</td>
										  <td align="right">-</td>
										  <td align="right">-</td>
									  	  <td align="right">-</td>
									  	  <td align="right">-</td>
										  <td align="right">'.number_format($rentper[0]['charge'],2).'</td>';	
							}else{
								$html .= '
										  <td align="left">ค่าไฟ</td>
										  <td align="right">'.$rentper[0]['chargepermonth'].'</td>
										  <td align="right">'.$rentperlast[0]['chargepermonth'].'</td>
										  <td align="right">'.number_format(($rentper[0]['chargepermonth']- $rentperlast[0]['chargepermonth']),0).'</td>
										  <td align="right">'.number_format($output[0]['chargeperunit'],2).'</td>
										  <td align="right">'.number_format((($rentper[0]['chargepermonth']- $rentperlast[0]['chargepermonth']) *$output[0]['chargeperunit'] ),2) .'</td>';
							}
			
		$html .= '</tr>
			      <tr>
						<td>3</td>';
						if($output[0]['waterperunitGov']==1){
							$html .= '<td align="left">ค่าน้ำ (องค์การ)</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">-</td>
									  <td align="right">'.number_format($rentper[0]['water'],2).'</td>';	
						}else{
							$html .= '<td align="left">ค่าน้ำ</td>
									  <td align="right">'.$rentper[0]['waterpermonth'].'</td>
									  <td align="right">'.$rentperlast[0]['waterpermonth'].'</td>
									  <td align="right">'.number_format(($rentper[0]['waterpermonth']-$rentperlast[0]['waterpermonth']),0).'</td>
									  <td align="right">'.number_format($output[0]['waterperunit'],2) .'</td>
									  <td align="right">'.number_format(($rentper[0]['waterpermonth'] - $rentperlast[0]['waterpermonth'])* $output[0]['waterperunit'],2).'</td>	';
						}
							
		$html .= '</tr>
						<tr>
						<td>4</td>
						<td>อื่นๆ</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td align="right">'.number_format($rentperlast[0]['etc'],2).'</td>	
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					</table>
			<hr>	
			</td>
		</tr>
		
		<tr>
			<td colspan="4" align="right">
			<b>รวมทั้งสิ้น</b>&nbsp;'.number_format(($rentperlast[0]['etc']+(($rentper[0]['waterpermonth'] - $rentperlast[0]['waterpermonth'])* $output[0]['waterperunit']) + ((($rentper[0]['chargepermonth']- $rentperlast[0]['chargepermonth']) *$output[0]['chargeperunit'] )))+$output[0]['rent']+$rentper[0]['water']+$rentper[0]['charge'],2).' <b>บาท</b>
			<hr>
			</td>
		</tr>
		
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

//echo $html ;
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
 }


//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');
?>


