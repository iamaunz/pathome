<?php 

//echo "Month:".$_GET['month']." Year:".$_GET['year'];

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

//$output = $db->selectDataByid('Tb_room',' * ',' AND `id` = '.$_GET['id'].' ');
//$rentper = $db->getMeter($_GET['id'],$_GET['month'],$_GET['year']);
//$rentperlast = $db->getMeterLastMonth($_GET['id'], $_GET['month']-1); //-- เลขหลัง

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

//$result = $db->showRentPerMonth($_GET['year'],$_GET['month'],$_GET['id'],'','');
$result = $db->getAllRoom();
//print_r($result);

$room_net = 0;
$elect_net = 0;
$water_net = 0;
$exRoomName = "";
for($idx = 0; $idx < count($result); $idx++){
	//echo $idx.": ".$result[$idx]['id']."<br>";
	$roomID = $result[$idx]['id'];
	
	$output = $db->selectDataByid('Tb_room',' * ',' AND `id` = '.$roomID.' ');
	$meter = $db->getMeterTwoLastMonthDESC($roomID, $_GET['month'], $_GET['year']);
	$cmonth = $meter[0];
	$pmonth = $meter[1];
	
	$chkMonth = $db->checkMeterWithMonth($roomID, $_GET['month'], $_GET['year']);
	
	if(count($chkMonth) > 0){
		//-- หาค่าห้องรวมต่อเดือน
		$room_net += $output[0]['rent'];
	
		//-- หาค่าไฟรวมต่อเดือน
		if($output[0]['chargeperunitGov']==1){
			$total_elec = $cmonth['charge'];
		}else{
			$elec_pre_month = $pmonth['chargepermonth'];
			$elec_cur_month = $cmonth['chargepermonth'];
			$elec_unit = $elec_cur_month - $elec_pre_month;
			$price_per_unit = $output[0]['chargeperunit'];
			$total_elec = $elec_unit * $price_per_unit;
		}
		$elect_net += $total_elec;
		//echo "ELE:".$elect_net."<br>";
	
		//-- หาค่าน้ำรวมต่อเดือน
		if($output[0]['waterperunitGov']==1){
			$total_wate = $cmonth['water'];
		}else{
			$wate_pre_month = $pmonth['waterpermonth'];
			$wate_cur_month = $cmonth['waterpermonth'];
			$wate_unit = $wate_cur_month - $wate_pre_month;
		
			if($wate_unit < 6){ //--ขั้นต่ำน้ำ 4 หน่วย
				$wate_unit = 5; 
			}					
			$price_per_wunit = $output[0]['waterperunit'];
			$total_wate = $price_per_wunit * $wate_unit;
		}	
		$water_net += $total_wate;
	}else{
		//echo "ROOM NAME: ".$result[$idx]['roomName']."<br>";
		$exRoomName = $exRoomName.", ".$result[$idx]['roomName'];
	}
	
}

$html = '
<table>
		<tr>
			<td colspan="2" valign="bottom" align="center" width="100%"><h1>สรุปยอดค่าใช้จ่ายน้ำและไฟ</h1></td>
		</tr>
		<tr>
			<td colspan="2" valign="bottom" align="center" width="100%"><h5>เดือน'.$month[$_GET['month']].' '.$_GET['year'].'</h5></td>
		</tr>
		<tr>
			<td colspan="2" valign="bottom" align="center" width="100%">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" valign="bottom" align="center" width="100%"><hr></td>
		</tr>
		<tr>
			<td valign="bottom" align="left" width="20%">ค่าน้ำทุกห้องรวม&nbsp;</td>
			<td valign="bottom" align="right" width="80%">'.number_format($water_net,2).'&nbsp;บาท</td>
		</tr>
		<tr>
			<td valign="bottom" align="left" width="20%">ค่าไฟทุกห้องรวม&nbsp;</td>
			<td valign="bottom" align="right" width="80%">'.number_format($elect_net,2).'&nbsp;บาท</td>
		</tr>
		<tr>
			<td valign="bottom" align="left" width="20%">ค่าเช่ารวม&nbsp;</td>
			<td valign="bottom" align="right" width="80%">'.number_format($room_net,2).'&nbsp;บาท</td>
		</tr>
		<tr>
			<td valign="bottom" align="left" width="20%">รายรับทั้งหมดรวม&nbsp;</td>
			<td valign="bottom" align="right" width="80%">'.number_format($elect_net + $water_net + $room_net,2).'&nbsp;บาท</td>
		</tr>
		<tr>
			<td colspan="2" valign="bottom" align="center" width="100%">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" valign="bottom" align="center" width="100%"><hr></td>
		</tr>
		<tr>
			<td colspan="2" valign="bottom" align="center" width="100%"><u>หมายเหตุ</u> รายงานดังกล่าวอาจยังไม่รวมห้องเหล่านี้ '.$exRoomName.'</td>
		</tr>
</table>
<hr style="background-color:#fff;border:#000 1px dotted;border-style: none none dotted;color:#fff;">
';

//echo $html;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



//Close and output PDF document
$pdf->Output('Summary_Report.pdf', 'I');

?>


