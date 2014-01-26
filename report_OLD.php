<?php 
session_start();

if(!$_SESSION['userName']){
	echo"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=index.php\">";
}

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

	
	
	$result =  $db->selectData(' Tb_apartment','*','  ');
	
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
   <!-- <script language="javascript">
		$(document).ready(function() {
			
			/*$('#room').live('click',function(){
					//alert('xxx');
					var month = $('#month').val();
					var year = $('#year').val();
					$(this).attr('href','room.php?month='+month+'&year='+year);
				});*/
			$(this).delegate('#room','click',function(){
					var month = $('#month').val();
					var year = $('#year').val();
					$(this).attr('href','room.php?month='+month+'&year='+year);
				});
				
			$('#apartment').live('change',function(){
				//alert('ddd');
				var id = $(this).val();
				$('#showLevel').load('process.php?task=showLevel&id='+id);
			
				//$('#level').append('<option value="foo" selected="selected">Foo</option>');
			});
			
		});
	</script>-->
    
</head>

<body>

<div data-role="page">

	<div data-role="header"  data-theme="b" >
    	 	<a href="main.php" data-icon="delete">Cancel</a>
         
		<h1>รางาน</h1>
        
       
	</div><!-- /header -->



	<div data-role="content"  >	
    
      
    	<ul data-role="listview" data-inset="true">
        <?php while($rs = mysql_fetch_array($result)){?>
            <li>
            
            <h3>อาคาร <?php echo $rs['name'];?></h3>
				<p><strong>เช่า:</strong>
                <?php $output = $db->selectDataByid('Tb_room',' count(id) AS total ',' AND `apartment` = '.$rs['id'].' AND `status` =1 ');
				echo number_format($output[0]['total']);
				 ?>
                </p>
				<p><strong>ว่าง:</strong>
                <?php $output = $db->selectDataByid('Tb_room',' count(id) AS total ',' AND `apartment` = '.$rs['id'].' AND `status` =0 ');
				echo number_format($output[0]['total']);
				 ?>
                </p>
				
            </li><!--<span class="ui-li-count">0</span>-->
         <?php } ?>  
        </ul>
     
        
        
	</div><!-- /content -->



	
</div><!-- /page -->


</body>
</html>