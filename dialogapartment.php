<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" content="text/html; charset=UTF-8"> 
<title>Apartment</title>
<link rel="stylesheet" href="js/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="js/jquery.mobile-1.2.0.min.js"></script>
    
</head> 
<body> 

<div data-role="dialog">
	
		<div data-role="header" data-theme="d">
			<h1>ทำรายการอาคาร <?php echo $_GET['name'] ;?></h1>
		</div>

		<div data-role="content" data-theme="c">
      
        	
        	<a href="apartment.php?id=<?php echo $_GET['id'] ;?>" data-role="button" data-theme="c">แก้ไขข้อมูล</a>       
        	
			
			<a href="newkeepthemeter.php?id=<?php echo $_GET['id'] ;?>" data-role="button"  data-theme="c">ลบข้อมูล</a>     
             
			   
			<a href="dialog/index.html" data-role="button" data-rel="back" data-theme="b">ยกเลิก</a>    
		</div>
	</div>


</body>
</html>
