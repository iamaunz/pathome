<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Apartment</title>
<link rel="stylesheet" href="js/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="js/jquery.mobile-1.2.0.min.js"></script>
    <script src="js/script.js"></script>
   <!-- <script language="javascript">
		$(document).ready(function() {
			
			/*$('#room').live('click',function(){
					//alert('xxx');
					var month = $('#month').val();
					var year = $('#year').val();
					$(this).attr('href','room.php?month='+month+'&year='+year);
				});*/
			$(this).delegate('#room','click',function(){
					var month = $('#month').val();
					var year = $('#year').val();
					$(this).attr('href','room.php?month='+month+'&year='+year);
				});
				
			$('#apartment').live('change',function(){
				//alert('ddd');
				var id = $(this).val();
				$('#showLevel').load('process.php?task=showLevel&id='+id);
			
				//$('#level').append('<option value="foo" selected="selected">Foo</option>');
			});
			
		});
	</script>-->
    
</head>

<body>

<div data-role="page">

	<div data-role="header"  data-theme="b" >
    	 <a href="changepassword.php" data-icon="gear" data-iconpos="left">ChangePassword</a>
         
		<h1>Apartment</h1>
        
        <a href="logout.php" data-icon="forward" data-iconpos="right">logout</a>
	</div><!-- /header -->



	<div data-role="content"  >	
    	<ul data-role="listview" data-inset="true">
            <li><a id="room" href="room.php">ห้องพัก</a> 
            <!--
            <?php 
            	$output = $db->selectDataByid('Tb_room',' count(id) AS total ','  AND `status` =0 ');
            	//$output = $db->getAllRoom();
            	$all = $db->getAllRoom();
			if($output[0]['total'] > 0){
			 ?>
            <span class="ui-li-count"><?php echo number_format($output[0]['total']);?></span>
            <?php } ?>
            -->
            <span class="ui-li-count"><?php echo count($all);?></span>
            </li><!--<span class="ui-li-count">0</span>-->
            <li><a href="renter.php">ผู้เช่า</a></li>
            <li><a href="apartment.php">อาคาร</a></li>
            <li><a id="report" href="report.php">รายงาน</a></li>
            <li><a id="print" href="print.php">พิมพ์ใบเสร็จ</a></li>
        </ul>
     
        <h2>รอบการชําระประจําเดือน</h2>
        <select name="month" id="month" data-native-menu="false">
           <option value="1" <?php echo(1 ==@date('m'))?"selected":""; ?> >มกราคม</option>
           <option value="2" <?php echo(2 ==@date('m'))?"selected":""; ?>>กุมภาพันธ์</option>
           <option value="3" <?php echo(3 ==@date('m'))?"selected":""; ?>>มีนาคม</option>
           <option value="4" <?php echo(4 ==@date('m'))?"selected":""; ?>>เมษายน</option>
           <option value="5" <?php echo(5 ==@date('m'))?"selected":""; ?>>พฤษภาคม</option>
           <option value="6" <?php echo(6 ==@date('m'))?"selected":""; ?>>มิถุนายน</option>
           <option value="7" <?php echo(7 ==@date('m'))?"selected":""; ?>>กรกฎาคม</option>
           <option value="8" <?php echo(8 ==@date('m'))?"selected":""; ?>>สิงหาคม </option>
           <option value="9" <?php echo(9 ==@date('m'))?"selected":""; ?>>กันยายน</option>
           <option value="10" <?php echo(10 ==@date('m'))?"selected":""; ?>>ตุลาคม</option>
           <option value="11" <?php echo(11 ==@date('m'))?"selected":""; ?>>พฤศจิกายน</option>
           <option value="12" <?php echo(12 ==@date('m'))?"selected":""; ?>>ธันวาคม</option>
        </select>
        
        <h2>ปี</h2>
         <select name="year" id="year" data-native-menu="false">
         <?php for($i=(@date('Y')+543)-5;$i<(@date('Y')+543)+5;$i++){?>
           <option value="<?php echo $i-543; ?>" <?php echo(($i-543)==@date('Y'))?"selected":""; ?> ><?php echo $i; ?></option>
          <?php } ?> 
        </select>
        
    	<!--
       <div id="showreportmonth"> 
        <ul data-role="listview" data-inset="true">
        	<li>ค่าน้ำรวมทุกห้องรวม<span class="ui-li-count"></span></li>
            <li>ค่าไฟรวมทุกห้องรวม<span class="ui-li-count"></span></li>
            <li>รายรับทั้งหมดรวม<span class="ui-li-count"></span></li>
            
        </ul>
       </div>
       -->
      
        
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>