<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }

 
	
	
	public function getLogin($username,$password)
	{
			$sql = " SELECT id ,name FROM `Tb_user` WHERE `username` = '".$username."' AND `password` = '".$password."' AND `block` = '1' ";
			
			
			
			$run = mysql_query($sql);
			if($run){
				$rs = mysql_fetch_array($run);
				$result = $rs;
			}else{
				$result = 0;
			}
					
			return $result ;	
	}
	
	public function showRentPerMonth($yser,$month,$apartment,$level,$txt){
		$sql= " SELECT a.id AS idRoom, a.roomName, a.status AS statusRoom, b.status,c.id AS apartmentID ,c.name ,a.level
				FROM  `Tb_room` AS a
				LEFT JOIN  (SELECT * From `Tb_rentpermonth` WHERE year='".$yser."' AND month ='".$month."' ) AS b ON ( a.id = b.ref_id_room ) 
				LEFT JOIN `Tb_apartment` AS c ON (a.`apartment` = c.`id`)
				WHERE 1  ";
		$sql .=($apartment)?" AND a.`apartment`=  '".$apartment."' ":"";
		$sql .=($level)?" AND a.`level`=  '".$level."' ":"";
		$sql .=($txt)?" AND a.`roomName` like '%".$txt."%' ":"";
		$sql .="ORDER BY a.roomName";
		
		//echo "showRentPerMonth: ".$sql;
		$run = mysql_query($sql);
		if($run){
			$result = $run;
			//$result = $rs;
		}else{
			$result = 0;
		}
					
		return $result ;
	}
	
	public function getRentPerMonnth($month, $year, $apartmentid){
		$sql = "SELECT Tb_rentpermonth.ref_id_room as idRoom
				FROM `Tb_rentpermonth` 
				INNER JOIN Tb_room on Tb_rentpermonth.ref_id_room = Tb_room.id
				WHERE Tb_rentpermonth.month = '".$month."' 
				AND Tb_rentpermonth.year = '".$year."'
				AND Tb_room.apartment = '".$apartmentid."'
				ORDER BY Tb_room.roomName";
		//echo "xxx:".$sql;		
		//$sql = "SELECT ref_id_room as idRoom FROM `Tb_rentpermonth` WHERE month = '3' and year = '2013'";
		$run = mysql_query($sql);
		if($run){
			$result = $run;
			//$result = $rs;
		}else{
			$result = 0;
		}
					
		return $result ;
	}
	
	public function getAllRoom()
	{		
		//$sql = "SELECT id, roomName FROM `Tb_room` ";
		$sql = "SELECT Tb_room.id, roomName 
				FROM Tb_room
				INNER JOIN Tb_apartment on Tb_apartment.id = Tb_room.apartment
				WHERE Tb_apartment.status = 1";
		//echo "SQL: ".$sql;
		$result=array();
		$req = mysql_query($sql) or die("SQL Error: <br>".$sql."<br>".mysql_error());
		while($data= mysql_fetch_assoc($req)) {
			$result[]=$data;
		}
		return $result;
	}
	
	public function getMeter($id,$month,$year)
	{
		$result=array();
		  	$req = mysql_query("SELECT * FROM `Tb_rentpermonth` WHERE `ref_id_room` = '".$id."' AND `year` = '".$year."' AND `month` = '".$month."' ") or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
		  return $result;
	}
	
	public function getMeterLast($idroom){
			//echo "xxxx".$idroom."xxxx";
			//$sql = "SELECT * FROM `Tb_rentpermonth` WHERE 1 AND ref_id_room = '".$idroom."'  AND `status` = 2 ORDER BY `year` DESC ,`month` DESC LIMIT 1 ";
			$sql = "SELECT * FROM `Tb_rentpermonth` WHERE 1 AND ref_id_room = '".$idroom."' ORDER BY `year` DESC ,`month` DESC LIMIT 1 ";
			$result=array();
		  	$req = mysql_query($sql) or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	//echo "getMeterLast: ".$sql;
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
		  return $result;
	}
	
	public function getMeterLastMonth($idroom, $month){
			//$sql = "SELECT * FROM `Tb_rentpermonth` WHERE 1 AND ref_id_room = '".$idroom."'  AND `status` = 2 ORDER BY `year` DESC ,`month` DESC LIMIT 1";
			$sql = "SELECT * FROM `Tb_rentpermonth` WHERE 1 AND ref_id_room = '".$idroom."'  AND `month` = '".$month."' ORDER BY `year` DESC ,`month` DESC LIMIT 1";
			$result=array();
		  	$req = mysql_query($sql) or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
		  return $result;
	}
	
	public function getMeterTwoLastMonthDESC($idroom, $month, $year){
			$sql = "SELECT * FROM `Tb_rentpermonth` WHERE ref_id_room = '".$idroom."' AND MONTH <= ".$month." AND YEAR <= ".$year." order by year DESC, month DESC LIMIT 2";
			//echo "<br>SQL: ".$sql;
			$result=array();
		  	$req = mysql_query($sql) or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
		  return $result;
	}

	//-- เหมือนแบบบน แต่ใช้ในกรณีที่เป็นดือน ธันวา และ มกราในปีถัดไป
	public function getMeterTwoLastMonthBTYDESC($idroom, $year){
			$sql = "SELECT * 
					FROM `Tb_rentpermonth` 
					WHERE ref_id_room = '".$idroom."' 
					AND (month = 1 OR month = 12)
					AND (year = '".$year."'  OR year = '".($year-1)."')
					ORDER BY year DESC, month DESC
					";
			//$sql = "SELECT * FROM `Tb_rentpermonth` WHERE ref_id_room = '".$idroom."' AND MONTH <= ".$month." AND YEAR <= ".$year." order by year DESC, month DESC LIMIT 2";
			//echo "<br>SQL: ".$sql;
			$result=array();
		  	$req = mysql_query($sql) or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
		  return $result;
	}

	public function checkMeterWithMonth($idroom, $month, $year){
			$sql = "SELECT * FROM `Tb_rentpermonth` WHERE ref_id_room = '".$idroom."' AND MONTH = ".$month." AND YEAR = ".$year."";
			//echo "SQL: ".$sql;
			$result=array();
		  	$req = mysql_query($sql) or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
		  return $result;
	}
	
	public function getAllBuidling(){
			$sql = "SELECT * FROM Tb_apartment WHERE status = '1' ORDER BY name";
			$result=array();
		  	$req = mysql_query($sql) or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
			return $result;
	}

	
	public function selectData($mytable,$data,$where)
	{
			$result  ='';
			$sql =" SELECT $data FROM $mytable WHERE 1 $where AND status = 1";
		
			//echo $sql;exit;
			$run = mysql_query($sql);
			if($run){
				$result = $run;
				//$result = $rs;
			}else{
				$result = 0;
			}
					
			return $result ;
	}
	
	public function selectDataByid($mytable,$data,$where){
			$result=array();
		  	$req = mysql_query("SELECT $data FROM $mytable WHERE 1 $where ") or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
		  return $result;
	}
		
	public function insertData($mytable,$data)
	{
		$result = $this->insert($mytable, $data);
		return $result ;
	}
	
	public function updateData($mytable, $data , $where)
	{
		$result = $this->update($mytable,$data,$where);
		return $result ;
	}
	
	public function deleteData($mytable, $where) 
	{
		return $output ;
	}
	
	
	//=========================//
	//======== Insert =========//
	//=========================//
	function insert($table,$data)
	{
	  $fields=""; $values="";
	  $i=1;
	  foreach($data as $key=>$val)
	  {
		if($i!=1) { $fields.=", "; $values.=", "; }
		$fields.="$key";
		$values.="'$val'";
		$i++;
	  }
	  $sql = "INSERT INTO $table ($fields) VALUES ($values)";
	  
	  
	  if(mysql_query($sql)) { return true; } 
	  else { die("SQL Error: <br>".$sql."<br>".mysql_error()); return false;}
	}
	//=========================//
	//======= Update ==========//
	//=========================//
	public function update($table,$data,$where)
	{
	  $modifs="";
	  $i=1;
	  foreach($data as $key=>$val)
	  {
		if($i!=1) { $modifs.=", "; }
		if(is_numeric($val)){ 
		$modifs.=$key.'='.$val; 
		}else { 
		$modifs.=$key.' = "'.$val.'"';
		 }
		$i++;
	  }
	  $sql = ("UPDATE $table SET $modifs WHERE $where");
	  if(mysql_query($sql)) { return true; } 
	  else { die("SQL Error: <br>".$sql."<br>".mysql_error()); return false; }
	}
	
	//=========================//
	//======== Delete =========//
	//=========================//
	public function delete($table, $where)
	{
	  $sql = "DELETE FROM $table WHERE $where";
	  if(mysql_query($sql)) { return true; } 
	  else { die("SQL Error: <br>".$sql."<br>".mysql_error()); return false; }
	}

}

?>
