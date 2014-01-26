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
		$run = mysql_query($sql);
		if($run){
				$result = $run;
				//$result = $rs;
			}else{
				$result = 0;
			}
					
			return $result ;
		
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
			$result=array();
		  	$req = mysql_query("SELECT * FROM `Tb_rentpermonth` WHERE 1 AND ref_id_room = '".$idroom."'  AND `status` = 2 ORDER BY `year` DESC ,`month` DESC LIMIT 1 ") or die("SQL Error: <br>".$sql."<br>".mysql_error());
		  	while($data= mysql_fetch_assoc($req)) {
				$result[]=$data;
		  	}
		  return $result;
	}
	
	public function selectData($mytable,$data,$where)
	{
			$result  ='';
			$sql =" SELECT $data FROM $mytable WHERE 1 $where";
		
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
