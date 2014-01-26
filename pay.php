<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

if($_GET['id']){
	$output = $db->selectDataByid('Tb_room',' * ',' AND `id` = '.$_GET['id'].' ');
	
	$rentper = $db->getMeter($_GET['id'],$_GET['month'],$_GET['year']);
	
	//$rentperlast = $db->getMeterLast($_GET['id']);
	$rentperlast = $db->getMeterLastMonth($_GET['id'], $_GET['month']-1);
}

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
		<h1>ห้อง <?php echo $_GET['room']; ?></h1>
        
	</div><!-- /header -->



	<div data-role="content"  >	
    <?php #echo  print_r($rentper);?>
    <form name="admin" id="admin" action="controllers.php" method="post">
    	<h2>รายการ</h2>
    	<ul data-role="listview" data-inset="true" >
        	
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <p><h3>ค่าห้อง</h3></p>
			<p class="ui-li-aside">
            	<strong>
					<?php echo number_format($output[0]['rent'],2)?>
              <input type="hidden" name="rent" id="rent" value="<?php echo $output[0]['rent']; ?>" />
                </strong>
            </p>
          </div>
        </li>
        <li> 
          	<div data-role="fieldcontain" class="ui-hide-label">
          	<?php if($output[0]['chargeperunitGov']==1){ ?>
						<p><h3>ค่าไฟ(องค์การ)</h3></p>
						<p class="ui-li-aside">
               			<strong>
						<?php
							$sumCharge = $rentper[0]['charge'];
							echo number_format($sumCharge,2) 
						?>
            			</strong>
            			</p>       		
          	<?php }else{ ?>
            			<p><h3>ค่าไฟ</h3></p>
            			<p>
            			<strong>เดือนก่อน:</strong> <?php echo $rentperlast[0]['chargepermonth'] ;?>
                		<strong>เดือนนี้: </strong> <?php echo $rentper[0]['chargepermonth'] ;?>
               			</p>
               			<p class="ui-li-aside">
               			<strong>
						<?php 
							$sumCharge =  (($rentper[0]['chargepermonth']- $rentperlast[0]['chargepermonth']) *$output[0]['chargeperunit'] ) ;  
							echo number_format($sumCharge,2)
						?>
         				
            			</strong>
            			</p>
            <?php } ?>
            <input type="hidden" name="charge" id="charge" value="<?php echo $sumCharge; ?>" />
          	</div>
        </li>
        
        <li> 
			<div data-role="fieldcontain" class="ui-hide-label">
          	<?php if($output[0]['waterperunitGov']==1){ ?>
          				<p><h3>ค่าน้ำ(องค์การ)</h3></p>
          				<p class="ui-li-aside">
               			<strong>
						<?php
							$sumWater = $rentper[0]['water'];
							echo number_format($sumWater,2) 
						?>
            			</strong>
            			</p> 
          	<?php }else{ ?>
          				<p><h3>ค่าน้ำ</h3></p>
          				<p>
            			<strong>เดือนก่อน:</strong> <?php echo $rentperlast[0]['waterpermonth'] ;?>
                		<strong>เดือนนี้: </strong> <?php echo $rentper[0]['waterpermonth'] ;?>
            			</p>
            			<p class="ui-li-aside">
            			<strong>
						<?php 
							$unit_w = $rentper[0]['waterpermonth'] - $rentperlast[0]['waterpermonth'];
							if($unit_w < 5){ $unit_w = 4; }
							$sumWater = ($unit_w * $output[0]['waterperunit']);  
							echo number_format($sumWater,2);
						?>
            			</strong>
            			</p>
          	<?php } ?>
          	<input type="hidden" name="water" id="water" value="<?php echo $sumWater; ?>" />
          </div>
        </li>
        
        <li> 
        	<div data-role="fieldcontain" class="ui-hide-label">
            	<label for="etc">อื่นๆ:</label>
            	<input type="text" name="etc" id="etc" value="" placeholder="อื่นๆ"/>
        	</div>
        </li>
        
           
        </ul>
        
        <h2>ยอดเงินที่ต้องชําระ</h2>
        <ul data-role="listview" data-inset="true" >
        	
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <p>&nbsp;</p>
			<p class="ui-li-aside" id="sum"><strong>
         
			<?php echo number_format($output[0]['rent']+$sumCharge+$sumWater,2)?>
            
            
            </strong></p>
          </div>
        </li>
        </ul>
        
        <input type="hidden" name="id" id="id" value="<?php echo $rentper[0]['id'];?>" />
        <input type="hidden" name="task" id="task" value="updatemeter" />
        <input type="submit" value="บันทึก" data-theme="b" />
         
     </form>
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>