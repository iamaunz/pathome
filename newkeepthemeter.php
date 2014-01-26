<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}

require_once 'include/DB_Functions.php';
$db = new DB_Functions();
$output = $db->selectDataByid("Tb_rentpermonth"," id, waterpermonth	,chargepermonth ,water,charge"," AND `ref_id_room` = '".$_GET['id']."' AND	`year` = '".$_SESSION['year']."' AND `month` ='".$_SESSION['month']."' ");

$outputroom = $db->selectDataByid('Tb_room',' waterperunitGov,chargeperunitGov ',' AND `id` = '.$_GET['id'].' ');
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
    
</head>

<body>

<div data-role="page">

	<div data-role="header"  data-theme="b" data-position="fixed" >
    	<a href="room.php?month=<?=$_SESSION['month']?>&year=<?=$_SESSION['year']?>" data-icon="delete">Cancel</a>
		<h1>ห้อง <?php echo $_GET['room']; ?></h1>
     
	</div><!-- /header -->



	<div data-role="content"  >	
    <form name="admin" id="admin" action="controllers.php" method="post">
    	<h2>จํานวนหน่วย</h2>
    	<ul data-role="listview" data-inset="true" >
        	
        <li> 
        <?php if($outputroom[0]['waterperunitGov']==0){?>
		<div data-role="fieldcontain" class="ui-hide-label">
            <label for="wa1">น้ำ: มิเตอร์ส่วนตัว</label>
            <input type="text" name="waterpermonth" id="waterpermonth" value="<?php echo  $output[0]['waterpermonth'] ?>" placeholder="หน่วย"/>
		</div>
		
		<?php }else{ ?>
		
		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="wa2">น้ำ: มิเตอร์องค์การ</label>
            <input type="text" name="water" id="water" value="<?php echo  $output[0]['water'] ?>" placeholder="บาท"/>
		</div>
		<?php } ?>
        </li>
        
        <li> 
		<?php if($outputroom[0]['chargeperunitGov']==0){?>
		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="el1">ไฟ: มิเตอร์ส่วนตัว</label>
			<input type="text" name="chargepermonth" id="chargepermonth" value="<?php echo  $output[0]['chargepermonth'] ?>" placeholder="หน่วย"/>
		</div>
		
		<?php }else{ ?>

		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="el2">ไฟ: มิเตอร์องค์การ</label>
            <input type="text" name="charge" id="charge" value="<?php echo  $output[0]['charge'] ?>" placeholder="บาท"/>
		</div>
		<?php } ?>
        </li>
        
           
        </ul>
        <input type="hidden" name="ref_id_room" id="ref_id_room" value="<?php echo $_GET['id'];?>" />
        <input type="hidden" name="id" id="id" value="<?php echo $output[0]['id'];?>">
        <input type="hidden" name="apartmentId" id="apartmentId" value="<?php echo  $_SESSION['apartmentId'] ;?>">
        <input type="hidden" name="task" id="task" value="addmeter" />
        <input type="submit" value="บันทึก" data-theme="b" />
     </form>
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>