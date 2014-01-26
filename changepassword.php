<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
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
    	<a href="main.php" data-icon="delete">Cancel</a>
		<h1>เปลี่ยนรหัสผ่าน</h1>
        
	</div><!-- /header -->



	<div data-role="content"  >	
    <form name="admin" id="admin" action="controllers.php" method="post">
    	
    	<ul data-role="listview" data-inset="true" >
        	
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <label for="oldpassword">รหัสผ่านเดิม:</label>
            <input type="password" name="oldpassword" id="oldpassword" value="" placeholder="รหัสผ่านเดิม" required="required"/>
          </div>
        </li>
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <label for="newpassword">รหัสผ่านใหม่:</label>
            <input type="password" name="newpassword" id="newpassword" value="" placeholder="รหัสผ่านใหม่" required="required"/>
          </div>
        </li>
        
        <li> 
          <div data-role="fieldcontain" class="ui-hide-label">
            <label for="conpassword">ยืนยันรหัสผ่านใหม่:</label>
            <input type="password" name="conpassword" id="conpassword" value="" placeholder="ยืนยันรหัสผ่านใหม่" required="required"/>
          </div>
        </li>
        
           
        </ul>
        
        
        <input type="hidden" name="task" id="task" value="updatepassword" />
        <input type="submit" value="บันทึก" data-theme="b" />
     </form>
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>