<?php
session_start();
	if (isset($_GET["task"]) && $_GET["task"] != '') {
    	require_once 'include/DB_Functions.php';
    	$db = new DB_Functions();
		

	 		switch ($_GET["task"]) {
		 
		 		case"showLevel":
						$id	 = $_GET["id"];
						
						//echo"=>".$id;	
						$result = $db->selectDataByid('Tb_apartment','level',' AND id='.$id);
						
						$_SESSION['leveltotal'] = $result[0]['level'] ;
						?>
                     	<div class="ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-c">
                       	<span class="ui-btn-inner ui-btn-corner-all">
                        <select name="level" id="level" style="width:100%; border:0; height:30px; background-color:#F9F9F9;" >
                        	<option value="0">ไม่ระบุ</option>
							<?php for($i=1;$i<=$result[0]['level'];$i++){?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php } ?>
                        </select>
                        </span>
                     </div>
                        <?php
								
				break; 
				
				case"showRoom":
						$apartment	 = $_GET["apartment"];
						$level	 = $_GET["level"];
							/*	echo "dddd";*/
				//echo"=>".$id;	
						$result = $db->selectData('Tb_room','id,roomName',' AND apartment='.$apartment.' AND level ='.$level );
						
						
						?>
                     	<div class="ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-c">
                       	<span class="ui-btn-inner ui-btn-corner-all">
                        <select name="room" id="room" style="width:100%; border:0; height:30px; background-color:#F9F9F9;" >
                        	<option value="0">ไม่ระบุ</option>
							<?php while($rsRoom = mysql_fetch_array($result)){?>
                            <option value="<?=$rsRoom['id']?>"><?=$rsRoom['roomName']?></option>
                            <?php } ?>
                        </select>
                        </span>
                     </div>
                        <?php
								
				break; 
				
				
		 		case"showLevelfilter":
						$id	 = $_GET["id"];
						//echo"=>".$id;	
						$result = $db->selectDataByid('Tb_apartment','level',' AND id='.$id);
						
						?>
                     	<div class="ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-c">
                       	<span class="ui-btn-inner ui-btn-corner-all">
                        <select name="levelfilter" id="levelfilter" style="width:100%; border:0; height:30px; background-color:#F9F9F9;" >
                        	<option value="0">ไม่ระบุ</option>
							<?php for($i=1;$i<=$result[0]['level'];$i++){?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php } ?>
                        </select>
                        </span>
                     </div>
                        <?php
								
				break; 
				
				case"showreportmonth":
						$year =($_GET['year'])?$_GET['year']:''; 
						$month =($_GET['month'])?$_GET['month']:''; 
							echo "=> ".$month  ." => ". $year  ;
						?>
                        <ul class="ui-listview ui-listview-inset ui-corner-all ui-shadow">
                        		<li class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-count ui-corner-top ui-btn-up-c"><div class="ui-btn-inner ui-li ui-corner-top"><div class="ui-btn-text">
                                
                                <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"></span>
                                
                                </li>
                        
                        </ul>
                        <?php 
				break; 
				
				case"showDataload":
						//echo $_GET['idam'].'=>'.$_GET['idlv'].'=>'.$_GET['year'].'=>'.$_GET['month'].'=>'.$_GET['txt'];
						$idAm =($_GET['idam'])?$_GET['idam']:''; 
						$idlv =($_GET['idlv'] && $_GET['idlv'] !='undefined')?$_GET['idlv']:''; 
						$year =($_GET['year'])?$_GET['year']:''; 
						$month =($_GET['month'])?$_GET['month']:''; 
						$txt =($_GET['txt'])?$_GET['txt']:''; 
						$_SESSION['levekauto'] = $idlv  ;
						$result = $db->showRentPerMonth($year,$month,$idAm ,$idlv,$txt);
						?>
                        
                        <ul class="ui-listview ui-listview-inset ui-corner-all ui-shadow">
        	<?php   while($rs = mysql_fetch_array($result)){?>
            <li class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-count ui-corner-top ui-btn-up-c"><div class="ui-btn-inner ui-li ui-corner-top"><div class="ui-btn-text">
            <a href="dialog.php?roomName=<?=$rs['roomName']?>&id=<?=$rs['idRoom']?>&status=<?=$rs['status']?>&apartmentID=<?=$rs['apartmentID']?>" data-rel="dialog" data-transition="pop"class="ui-link-inherit">
            <h3 class="ui-li-heading">อาคาร <?=$rs['name']?> ชั้น <?=$rs['level']?> ห้อง <?=$rs['roomName']?></h3>
				<p><strong>สถานะการเช่า:</strong> <?php echo ($rs['statusRoom']==1)?"เช่า":"ว่าง" ;?></p>
				<span class="ui-li-count ui-btn-up-c ui-btn-corner-all">
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
            </a>
            </div>
            <span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
            </div></li>
           	<?php }  ?>
        </ul>
                        <?php
				break; 
				
	 		}
		
	}
?>
		