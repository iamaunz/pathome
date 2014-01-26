<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

	
	$result = $db->selectData(' Tb_tenant','*','  ');

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
		<h1>ผู้เช่า</h1>
        <a href="newrenter.php" data-icon="plus" data-iconpos="right">New</a>
	</div><!-- /header -->



	<div data-role="content"  >	
    
    	<ul data-role="listview" data-inset="true" data-filter="true">
        	<?php while($rs = mysql_fetch_array($result)){?>
            <li><a href="newrenter.php?id=<?php echo $rs['id'] ;?>"><?php echo $rs['firstname'] ." &nbsp;&nbsp; ".$rs['lastname'] ?></a></li>
           	<?php }  ?>
        </ul>
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>