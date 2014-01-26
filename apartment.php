<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
if($_GET['id']){
	$output = $db->selectDataByid('Tb_apartment','id,name,level',' AND `status` = 1 AND id = '.$_GET['id'].' ');
}
	
	$result = $db->selectData('Tb_apartment','id,name,level',' AND `status` = 1 ');

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

	<div data-role="header"  data-theme="b" >
    	<a href="main.php" data-icon="delete">Cancel</a>
		<h1>อาคาร</h1>
	</div><!-- /header -->



	<div data-role="content"  >	
   
    	<ul data-role="listview" data-inset="true">
        	<?php   while($rs = mysql_fetch_array($result)){?>
            <li><a href="dialogapartment.php?id=<?php echo $rs['id'] ;?>&name=<?php echo $rs['name'] ;?>"><?php echo $rs['name'] ;?><span class="ui-li-count"><?php echo $rs['level'] ;?> ชั้น</span></a></li>
           	<?php }  ?>
        </ul>
        
        <form name="admin" id="admin" method="post" action="controllers.php">
        <h2>เพิ่มข้อมูล</h2>
        <div data-role="fieldcontain" class="ui-hide-label">
            <label for="name">ชื่ออาคาร:</label>
            <input type="text" name="name" id="name" value="<?php echo $output[0]['name'];?>" placeholder="ชื่ออาคาร"/>
        </div>
        <h2>จำนวนชั้น</h2>
        
        <select name="level" id="level" data-native-menu="false">
        	<?php for($i=1;$i<10;$i++){?>
           	<option value="<?=$i?>" <?php echo($output[0]['level']== $i)?"selected":"" ?> ><?=$i?></option>
           	<?php } ?>
        </select>
        <input type="hidden" name="task" value="<?php echo($_GET['id'])?"updatepartment":"addapartment"; ?>" />
        <?php if($_GET['id']){?>
        <input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
        <?php } ?>
        <input type="submit" value="บันทึก" data-theme="b" />
       </form>
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>