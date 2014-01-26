<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
/*if($_GET['id']){
	$output = $db->selectDataByid('Tb_apartment','id,name,level',' AND `status` = 1 AND id = '.$_GET['id'].' ');
}*/
	if($_GET['year']!=''&&$_GET['month']!=''){
		$_SESSION['year']= $_GET['year'];
		$_SESSION['month']=$_GET['month'];
	}
	
	//$result = $db->selectData('Tb_room','id,roomName','  ');

	
	$result = $db->showRentPerMonth($_SESSION['year'],$_SESSION['month'],$_SESSION['apartmentId'],$_SESSION['levekauto'],'');
	
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
    	<a href="main.php" data-icon="delete">Cancel</a>
		<h1>ห้องพัก</h1>
        <a href="newroom.php" data-icon="plus" data-iconpos="right">New</a>
	</div><!-- /header -->



	<div data-role="content"  >	
  
    	<label for="search-basic">ค้นหา</label>
		<input type="search" name="search" id="search" value="" />
    
         <label for="apartmentroomfilter">อาคาร</label>

         <select name="apartmentfilter" id="apartmentroomfilter" >
        	<option value="">-เลือก-</option>
        	<?php while($rsApartment = mysql_fetch_array($resultApartment)){?>
           	<option value="<?=$rsApartment['id']?>" <?php echo($rsApartment['id']==$_SESSION['apartmentId'] )?"selected":"" ?>  ><?=$rsApartment['name']?></option>
           	<?php } ?>
        </select>
        
         <label for="select-choice-0">ชั้น</label>
     	<?=$_SESSION['leveltotal']?>
         <div id="showLevelroomfilter">
        <select name="levelfilter" id="levelfilter" >
        	<option value="">-เลือก-</option>
        	<?php 
			if($_SESSION['apartmentId']){
				$resultLevel = $db->selectDataByid('Tb_apartment','level',' AND id='.$_SESSION['apartmentId']);
				$x = $resultLevel[0]['level']  ;
				}else{
				$x = 10 ;
				}
			for($i=1;$i<=$x;$i++){?>
           	<option value="<?=$i?>" <?php echo($i==$_SESSION['levekauto'] )?"selected":"" ?> ><?=$i?></option>
           	<?php } ?>
        </select>
        
        </div> 
        	<?php //echo "===>". $_SESSION['apartmentId']."<==";?>
        <br>
        <div id="loaddata">
    	<ul data-role="listview" data-inset="true"  >
        	<?php   while($rs = mysql_fetch_array($result)){?>
            <li>
            
            <a href="dialog.php?roomName=<?=$rs['roomName']?>&id=<?=$rs['idRoom']?>&status=<?=$rs['status']?>&apartmentID=<?=$rs['apartmentID']?>" data-rel="dialog" data-transition="pop">
            <h3>อาคาร <?=$rs['name']?> ชั้น <?=$rs['level']?> ห้อง <?=$rs['roomName']?></h3>
				<p><strong>สถานะการเช่า:</strong> <?php echo ($rs['statusRoom']==1)?"เช่า":"ว่าง" ;?></p>
				<span class="ui-li-count">
                <?php 
				if($rs['status']==2){
					echo"ชำระแล้ว";
				}else if($rs['status']==1){
					echo"รอชำระ";
				}else{
					echo"รอเก็บมิเตอร์";
				}
				?>
                </span>
            </a></li>
           	<?php }  ?>
        </ul>
        </div>
	</div><!-- /content -->


<input type="hidden" id="hiyear" value="<?=$_SESSION['year']?>" />
<input type="hidden" id="himonth" value="<?=$_SESSION['month']?>" />
	
</div><!-- /page -->


 </body>
</html>