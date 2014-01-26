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
    <script src="js/script.js"></script>
</head>

<body>
<div data-role="page">


	<div data-role="content"  >	
<?php

	if (isset($_POST["task"]) && $_POST["task"] != '') {
    	require_once 'include/DB_Functions.php';
    	$db = new DB_Functions();
		

	 		switch ($_POST["task"]) {
		 
		 		case"login":
							
							
						$username = $_POST['username'];
						$password = md5($_POST['password']);
						$result = $db->getLogin($username,$password);
						if($result != '0'){
							$_SESSION['userId'] = $result['id'] ;
							$_SESSION['userName'] = $result['name'] ;
									 
							echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=main.php\">";
						}else{
										
							echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
						}		
									
				break; 
				
				case"addapartment":
					$name = $_POST['name'];
					$level = $_POST['level'];
					$data = array(
							"name"=>"$name",
							"level"=>"$level",
							"status"=>"1",
					);
					$result = $db->insertData('Tb_apartment',$data);
					if($result){
						
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=apartment.php\">";
					}else{
										
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=apartment.php\">";
					}	
					
				break;
				
				case"updatepartment":
					$name = $_POST['name'];
					$level = $_POST['level'];
					$id = $_POST['id'];
					
					$data = array(
							"name"=>"$name",
							"level"=>"$level",
							"status"=>"1",
					);
					$where ="id = ".$id;
					$result = $db->updateData('Tb_apartment',$data,$where);
					if($result){
						
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=apartment.php\">";
					}else{
										
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=apartment.php\">";
					}
				
				break;
				
				case"addroom":
					$apartment 			= $_POST['apartment'];
					$level 				= $_POST['level'];
					$roomNo 			= $_POST['roomNo'];
					$roomName 			= $_POST['roomName'];
					$rent 				= $_POST['rent'];
					$waterperunit 		= $_POST['waterperunit'];
					$chargeperunit 		= $_POST['chargeperunit'];
					$waterperunitGov 	= $_POST['waterperunitGov'];
					$chargeperunitGov 	= $_POST['chargeperunitGov'];
					$status 			= $_POST['status'];
					$data = array(
							"apartment"=>"$apartment",
							"level"=>"$level",
							"roomNo"=>"$roomNo",
							"roomName"=>"$roomName",
							"rent"=>"$rent",
							"waterperunit"=>"$waterperunit",
							"chargeperunit"=>"$chargeperunit",
							"waterperunitGov"=>"$waterperunitGov",
							"chargeperunitGov"=>"$chargeperunitGov",
							"status"=>"$status",
							
					);
					$result = $db->insertData('Tb_room',$data);
					if($result){
						
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=room.php\">";
					}else{
										
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=newroom.php\">";
					}	
				break;
				
				case"updateroom":
					$apartment 			= $_POST['apartment'];
					$level 				= $_POST['level'];
					$roomNo 			= $_POST['roomNo'];
					$roomName 			= $_POST['roomName'];
					$rent 				= $_POST['rent'];
					$waterperunit 		= $_POST['waterperunit'];
					$chargeperunit 		= $_POST['chargeperunit'];
					$waterperunitGov 	= $_POST['waterperunitGov'];
					$chargeperunitGov 	= $_POST['chargeperunitGov'];
					$status 			= $_POST['status'];
					$id 				= $_POST['id'];
					$data = array(
							"apartment"=>"$apartment",
							"level"=>"$level",
							"roomNo"=>"$roomNo",
							"roomName"=>"$roomName",
							"rent"=>"$rent",
							"waterperunit"=>"$waterperunit",
							"chargeperunit"=>"$chargeperunit",
							"waterperunitGov"=>"$waterperunitGov",
							"chargeperunitGov"=>"$chargeperunitGov",
							"status"=>"$status",
							
					);
					$where ="id = ".$id;
					$result = $db->updateData('Tb_room',$data,$where);
					if($result){
						
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=room.php\">";
					}else{
										
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=newroom.php\">";
					}
				
				break;
				
				case"addmeter":
					$year 			= $_SESSION['year'];
					$month			= $_SESSION['month'];
					$ref_id_room 	= $_POST['ref_id_room'];
					$waterpermonth 	= $_POST['waterpermonth'];
					$chargepermonth = $_POST['chargepermonth'];
					$water 			= $_POST['water'];
					$charge 		= $_POST['charge'];
					$apartmentId 		= $_POST['apartmentId'];
					
					$id 			= $_POST['id'];
					
					$data = array(
							"ref_id_room"=>"$ref_id_room",
							"year"=>"$year",
							"month"=>"$month",
							"waterpermonth"=>"$waterpermonth",
							"chargepermonth"=>"$chargepermonth",
							"water"=>"$water",
							"charge"=>"$charge",
							"status"=>"1",
							
					);
					if($id){
					$where ="id = ".$id;
					$result = $db->updateData('Tb_rentpermonth',$data,$where);
					
					}else{
					$result = $db->insertData('Tb_rentpermonth',$data);	
					}
					if($result){
						
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=room.php?month=".$month."&year=".$year."\">";
					}else{
										
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=room.php?month=".$month."&year=".$year."\">";
					}	
					
				break;
				
				case"updatemeter":
					$rent 			= $_POST['rent'];
					$charge			= $_POST['charge'];
					$water 			= $_POST['water'];
					$etc 			= $_POST['etc'];
					$id 			= $_POST['id'];
					
					$data = array(
					
							"rent"=>"$rent",
							"charge"=>"$charge",
							"water"=>"$water",
							"etc"=>"$etc",
							"status"=>"2",
							
					);
					$where ="id = ".$id;
					$result = $db->updateData('Tb_rentpermonth',$data,$where);
					if($result){
						
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=room.php\">";
					}else{
										
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=newroom.php\">";
					}
				
				
				break;
				
				case"updatepassword":
						$oldpassword 			= md5($_POST['oldpassword']);
						$newpassword			= md5($_POST['newpassword']);
						$conpassword 			= md5($_POST['conpassword']);
					
					
			$chk = $db->selectDataByid('Tb_user','password',' AND `id` ='. $_SESSION["userId"] );
		
				if($oldpassword == $chk[0]['password']){
						if($newpassword = $conpassword){
						$data = array(
						
								"password"=>"$newpassword",
								
						);
						$where ="id = ".$_SESSION["userId"];
						$result = $db->updateData('Tb_user',$data,$where);
						if($result){
							
							echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=main.php\">";
						}else{
											
							echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=changepassword.php\">";
						}
						}
				}
					
				break;
				
				case"addrenter":
					$firstname 	= $_POST['firstname'];
					$lastname	= $_POST['lastname'];
					$idcard 	= $_POST['idcard'];
					$tel 		= $_POST['tel'];
					$apartment 	= $_POST['apartment'];
					$level 		= $_POST['level'];
					$room 		= $_POST['room'];
					
					$data = array(
							"firstname"=>"$firstname",
							"lastname"=>"$lastname",
							"idcard"=>"$idcard",
							"tel"=>"$tel",
							"apartment"=>"$apartment",
							"level"=>"$level",
							"room"=>"$room",
							
					);
					$result = $db->insertData('Tb_tenant',$data);
					if($result){
						
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=renter.php\">";
					}else{
										
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=renter.php\">";
					}	
				
				break;
				
				case"updaterenter":
				
					$firstname 	= $_POST['firstname'];
					$lastname	= $_POST['lastname'];
					$idcard 	= $_POST['idcard'];
					$tel 		= $_POST['tel'];
					$apartment 	= $_POST['apartment'];
					$level 		= $_POST['level'];
					$room 		= $_POST['room'];
					$id 		= $_POST['id'];
					
					$data = array(
							"firstname"=>"$firstname",
							"lastname"=>"$lastname",
							"idcard"=>"$idcard",
							"tel"=>"$tel",
							"apartment"=>"$apartment",
							"level"=>"$level",
							"room"=>"$room",
							
					);
					$where ="id = ".$id;
					$result = $db->updateData('Tb_tenant',$data,$where);
					if($result){
							
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=renter.php\">";
					}else{
											
						echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=renter.php\">";
					}
				
				break;	
	 		}
		
	}
?>
		</div>
</div><!-- /page -->


</body>
</html>