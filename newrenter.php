<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
if($_GET['id']){
	$output = $db->selectDataByid('Tb_tenant',' * ',' AND `id` = '.$_GET['id'].' ');
}
	
	$resultApartment = $db->selectData('Tb_apartment','id,name,level',' AND `status` = 1 ');

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
</head>

<body>

<div data-role="page">

	<div data-role="header"  data-theme="b" data-position="fixed" >
    	<a href="renter.php" data-icon="delete">Cancel</a>
		<h1>ผู้เช่า</h1>
        
	</div><!-- /header -->



	<div data-role="content"  >	
     <form name="admin" method="post" action="controllers.php">
    	<ul data-role="listview" data-inset="true" >
        	
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <label for="firstname">ชื่อจริง:</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo $output[0]['firstname'];?>" placeholder="ชื่อจริง"/>
          </div>
        </li>
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <label for="lastname">นามสกุล:</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo $output[0]['lastname'];?>" placeholder="นามสกุล"/>
          </div>
        </li>
        <li> 
        	<div data-role="fieldcontain" class="ui-hide-label">
            	<label for="idcard">รหัสบัตรประชาชน:</label>
            	<input type="text" name="idcard" id="idcard" value="<?php echo $output[0]['idcard'];?>" placeholder="รหัสบัตรประชาชน"/>
        	</div>
        </li>
        <li> 
        	<div data-role="fieldcontain" class="ui-hide-label">
            	<label for="tel">เบอร์โทรศัพท์:</label>
            	<input type="text" name="tel" id="tel" value="<?php echo $output[0]['tel'];?>" placeholder="เบอร์โทรศัพท์"/>
        	</div>
        </li>
           
        </ul>
        
        <h2>เลือกอาคาร</h2>
        <select name="apartment" id="apartmentrent" >
        	<option value="">-เลือก-</option>
        	<?php while($rsApartment = mysql_fetch_array($resultApartment)){?>
           	<option value="<?=$rsApartment['id']?>" <?php echo($rsApartment['id']==$output[0]['apartment'])?"selected":"" ?>  ><?=$rsApartment['name']?></option>
           	<?php } ?>
        </select>
        <h2>จำนวนชั้น</h2>
        <div id="showLevelrent">
        <select name="level" id="level" data-native-menu="false">
        	<option value="">-เลือก-</option>
            <?php if($output[0]['level']){
				$resultLevel = $db->selectDataByid('Tb_apartment','level',' AND id='.$output[0]['apartment']);
				$x = $resultLevel[0]['level']  ;
				for($i=1;$i<=$x ;$i++){?>
           	<option value="<?=$i?>" <?php echo($i==$output[0]['level'] )?"selected":"" ?>><?=$i?></option>
           	<?php } 
			} ?>
        </select>
        </div>
        <h2>ห้อง</h2>
        <div id="showRoomrent">
        
        <select name="room" id="room" data-native-menu="false">
        	<?php
			if($output[0]['room']){
			$result = $db->selectData('Tb_room','id,roomName',' AND apartment='.$output[0]['apartment'].' AND level ='.$output[0]['level'] );
			?>
							<option value="0">ไม่ระบุ</option>
							<?php while($rsRoom = mysql_fetch_array($result)){?>
                            <option value="<?=$rsRoom['id']?>" <?php echo($rsRoom['id']==$output[0]['room'] )?"selected":"" ?>><?=$rsRoom['roomName']?></option>
                            <?php } 
			}?>
        </select>
        </div>
        <input type="hidden" name="task" value="<?=($_GET['id'])?"updaterenter":"addrenter"?>" />
        <?php if($_GET['id']){?>
        <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>" />
        <?php } ?>
        
        <input type="submit" value="บันทึก" data-theme="b" />
        
        </form>
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>