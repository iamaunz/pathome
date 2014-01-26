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
$pdf->SetFont('freeserif', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content

$output = $db->selectDataByid('Tb_room',' * ',' AND `id` = '.$_GET['id'].' ');
	
			$rentper = $db->getMeter($_GET['id'],$_GET['month'],$_GET['year']);
	
			$rentperlast = $db->getMeterLast($_GET['id']);
$html = '
<table>
		<tr>
			<td><h3>ใบเสร็จรับเงิน</h3></td>
			<td></td>
			<td><b>เลขที่:</b> &nbsp;'.date('Ym').$rentper[0]['id'].' </td>
		</tr>
		
		<tr>
			<td><b>เลขที่ห้อง</b> &nbsp;'. $_GET['room'].'</td>
			<td></td>
			<td><b>วันที่:</b> &nbsp;'.date('d/m/Y').'</td>
		</tr>
		
		<tr>
			<td colspan="3">
			<hr>
		
					<table>
						<tr>
							<td><b><u>ที่</u></b></td>
							<td><b><u>รายการ</u></b></td>
							<td><b><u>เลขอ่านครั้งหลัง</u></b></td>
							<td><b><u>เลขอ่านครั้งก่อน</u></b></td>
							<td><b><u>จำนวนที่ใช้</u></b></td>
							<td><b><u>ราคาต่อหน่วย</u></b></td>
							<td><b><u>รวม</u></b></td>	
						</tr>
						<tr>
							<td>1</td>
							<td>ค่าห้อง</td>
							<td>-</td>
							<td>-</td>
							<td>1</td>
							<td>'.number_format($output[0]['rent'],2).'</td>
							<td>'.number_format($output[0]['rent'],2).'</td>	
						</tr>
						
						<tr>
							<td>2</td>
							<td>ค่าไฟ</td>';
		if($output[0]['chargeperunitGov']==1){
		$html .= '			<td colspan="4" align="center"><b>ค่าไฟองค์การ</b></td>
							<td>'.number_format($rentper[0]['charge'],2).'</td>';	
		}else{
							
		$html .= '			<td>'.$rentper[0]['chargepermonth'].'</td>
							<td>'.$rentperlast[0]['chargepermonth'].'</td>
							<td>'.($rentper[0]['chargepermonth']- $rentperlast[0]['chargepermonth']).'</td>
							<td>'.number_format($output[0]['chargeperunit'],2).'</td>
							<td>'. number_format((($rentper[0]['chargepermonth']- $rentperlast[0]['chargepermonth']) *$output[0]['chargeperunit'] ),2) .'</td>';
			}
			
		$html .= '		</tr>
						
						<tr>
							<td>3</td>
							<td>ค่าน้ำ</td>';
		if($output[0]['waterperunitGov']==1){
		$html .= '			<td colspan="4" align="center"><b>ค่าน้ำองค์การ</b></td>
							<td>'.number_format($rentper[0]['water'],2).'</td>';	
		}else{
							
		$html .= '
							<td>'.$rentper[0]['waterpermonth'] .'</td>
							<td>'.$rentperlast[0]['waterpermonth'].'</td>
							<td>'.($rentper[0]['waterpermonth']-$rentperlast[0]['waterpermonth']).'</td>
							<td>'.number_format($output[0]['waterperunit'],2) .'</td>
							<td>'.number_format(($rentper[0]['waterpermonth'] - $rentperlast[0]['waterpermonth'])* $output[0]['waterperunit'],2).'</td>	';
		}
							
		$html .= '		</tr>
						
						<tr>
							<td>4</td>
							<td>อื่นๆ</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>'.number_format($rentperlast[0]['etc'],2).'</td>	
						</tr>
						
					</table>
			<hr>	
			</td>
		</tr>
		
		<tr>
			
			<td colspan="3" align="right">
			
			<b>รวมทั้งสิ้น</b>&nbsp;'.number_format(($rentperlast[0]['etc']+(($rentper[0]['waterpermonth'] - $rentperlast[0]['waterpermonth'])* $output[0]['waterperunit']) + ((($rentper[0]['chargepermonth']- $rentperlast[0]['chargepermonth']) *$output[0]['chargeperunit'] )))+$output[0]['rent']+$rentper[0]['water']+$rentper[0]['charge'],2).'
			<hr>
			</td>
		</tr>
		
		<tr>
			<td><b>ผู้รับเงิน</b><hr></td>
			<td></td>
			<td><b>ผู้เช่า</b><hr></td>
		</tr>
</table>
<hr>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');
?>


