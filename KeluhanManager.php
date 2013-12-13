<?php
	include_once("dam.php");
	include_once("Keluhan.php");
	
	class KeluhanManager{
		private $db;		
		public function __construct(){
			$this->db = new DAM();
		}
		
		public function createKeluhan($data){
			$data = $this->validate($data);	
			if( $this->db->create("keluhan", $data)){
				return true;
			}
			throw new Exception("Error while saving to database.");
		}
		
		public function solveKeluhan($data){
			$data = $this->validate($data);	
			if( $this->db->update("keluhan", array("status_keluhan"=>"solved") ,$data)){
				return true;
			}
		}
		
		public function deleteKeluhan($data){
			$data = $this->validate($data);	
			if( $this->db->delete("keluhan",$data)){
				return true;
			}
		}
		
		public function validate($data){
			$retVal = array();
			foreach($data as $key=>$value){
				$retVal[$key] = $this->db->real_escape_string($value);
			}
			return $retVal;
		}
		
		public function getAllKeluhan(){
			$temp = $this->db->retrieve("keluhan", true);
			$retVal = array();
			while($line = $temp->fetch_assoc()){
				$retVal[] = new Keluhan($line);
			}
			return $retVal;
		}
		
		public function getKeluhan($data){
			$data = $this->validate($data);	
			$id = $data['IDKeluhan'];
			$temp = $this->db->retrieve("keluhan", $data);
				
			$complaint = NULL;
			//var_dump($temp->num_rows);exit(0);
			if($temp->num_rows > 0){
				$line = $temp->fetch_assoc();
				$complaint = new Keluhan($line);
			}
			
			$condition = $complaint->type==0?"`IDPenerima` IS NULL":"`IDPenerima` IS NOT NULL";
			
			$query = "SELECT `IDKeluhan` FROM `keluhan` WHERE $condition ORDER BY `Waktu_Keluhan` ASC";
			$temp = $this->db->specialQuery($query);
			
			$last = $next = NULL;
			$found = false;
			while(($line = $temp->fetch_assoc()) && !$found){
				$tempId = $line['IDKeluhan'];
				if($tempId == $id){
					$found = true;
					if($line = $temp->fetch_assoc()){
						$next = $line['IDKeluhan'];
					}
				}else{
					$last = $tempId;
				}
			}
			
			$retVal = array("data"=>$complaint);
			if($last){
				$retVal['prev'] = $last;
			}
			
			if($next){
				$retVal['next'] = $next;
			}
			return $retVal;
		}
	}
?>