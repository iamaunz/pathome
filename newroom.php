<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
if($_GET['id']){
	$output = $db->selectDataByid('Tb_room',' * ',' AND `id` = '.$_GET['id'].' ');
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
    	<a href="room.php?month=<?=$_SESSION['month']?>&year=<?=$_SESSION['year']?>" data-icon="delete">Cancel</a>
    	<?php
    	if($output[0]['roomNo'] == "")
    		echo "<h1>เพิ่มห้องพัก</h1>";
    	else
    		echo "<h1>แก้ไขข้อมูลห้องพัก</h1>";
    	?>
		
        
	</div><!-- /header -->



	<div data-role="content"  >	
    <form name="admin" method="post" action="controllers.php">
    	<ul data-role="listview" data-inset="true" >
        	
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <label for="roomNo">เลขที่ห้อง:</label>
            <input type="text" name="roomNo" id="roomNo" value="<?=$output[0]['roomNo']?>" placeholder="เลขที่ห้อง"/>
          </div>
        </li>
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <label for="roomName">ชื่อห้อง:</label>
            <input type="text" name="roomName" id="roomName" value="<?=$output[0]['roomName']?>" placeholder="ชื่อห้อง"/>
          </div>
        </li>
        </ul>
        
        <ul data-role="listview" data-inset="true" >
        <li> 
        	<div data-role="fieldcontain" class="ui-hide-label">
            	<label for="rent">ค่าเช่า:</label>
            	<input type="text" name="rent" id="rent" value="<?=$output[0]['rent']?>" placeholder="ค่าเช่า"/>
        	</div>
        </li>
        <li> 
        	<div data-role="fieldcontain" class="ui-hide-label">
            	<label for="waterperunit">ค่าน้ำต่อหน่วย:</label>
                <label>
                <input type="checkbox" name="waterperunitGov" id="watergov" value="1" data-role="none"  <?=($output[0]['waterperunitGov'] == '1')?"checked":"" ?> /> ค่าน้ำองค์การ </label>
            	<input type="text" name="waterperunit" id="waterperunit" value="<?=$output[0]['waterperunit']?>" placeholder="ค่าน้ำต่อหน่วย"  />
        	</div>
        </li>
        
        <li> 
        	<div data-role="fieldcontain" class="ui-hide-label">
            	<label for="chargeperunit">ค่าไฟต่อหน่วย:</label>
                <label><input type="checkbox" name="chargeperunitGov" id="charggov" value="1" data-role="none" <?=($output[0]['chargeperunitGov'] == '1')?"checked":""?> /> ค่าไฟองค์การ</label>
            	<input type="text" name="chargeperunit" id="chargeperunit" value="<?=$output[0]['chargeperunit']?>" placeholder="ค่าไฟต่อหน่วย"  />
        	</div>
        </li>
           
        </ul>
        
        <h2>เลือกอาคาร</h2>
        <select name="apartment" id="apartment" data-native-menu="false" >
        	<option value="">-เลือก-</option>
        	<?php while($rsApartment = mysql_fetch_array($resultApartment)){?>
           	<option value="<?=$rsApartment['id']?>" <?=($output[0]['apartment']==$rsApartment['id'])?"selected":""?>  ><?=$rsApartment['name']?></option>
           	<?php } ?>
        </select>
        
        <h2>เลือกชั้น</h2>
        <div id="showLevel">
        <select name="level" id="level" data-native-menu="false">
        	<option value="">-เลือก-</option>
            <option value="0" <?=($output[0]['level']=='0')?"selected":""?>>ไม่ระบุ</option>
            <?php 
    				echo "xxx:".$output[0]['level'];
					if($output[0]['level']){
						$outputLevel = $db->selectDataByid('Tb_apartment',' level ',' AND `id` = '.$output[0]['apartment'].' ');
						for($i=1;$i<=$outputLevel[0]['level'];$i++ ){
						?>
                     		<option value="<?=$i?>" <?=($output[0]['level']==$i)?"selected":""?>><?=$i?></option>
                    	<?php }
					} ?>
        </select>
        </div>
        <h2>สถานะการเช่า</h2>
        <div data-role="fieldcontain">
				
				<select name="status" id="status" data-role="slider">
					<option value="0" <?php echo($output[0]['status']==0)?"selected":""?> >Off</option>
					<option value="1" <?php echo($output[0]['status']==1)?"selected":""?>>On</option>
				</select>
		</div>
        <input type="hidden" name="task" value="<?=($_GET['id'])?"updateroom":"addroom"?>" />
        <?php if($_GET['id']){?>
        <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>" />
        <?php } ?>
        <input type="submit" value="บันทึก" data-theme="b" />
        </form>
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>