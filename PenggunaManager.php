<?php
	include_once("Pengguna.php");
	include_once("dam.php");
	class PenggunaManager{
		private $db;		
		public function __construct(){
			$this->db = new DAM();
		}
		
		public function createPengguna($data){
			$data = $this->validate($data);
			$p = new Pengguna($data);
			return $this->db->create("pengguna", $p);
		}
		
		public function validate($data){
			$retVal = array();
			foreach($data as $key=>$value){
				$retVal[$key] = $this->db->real_escape_string($value);
			}
			return $retVal;
		}
		public function authenticate($data){
			$data = $this->validate($data);
			$temp = $this->db->retrieve("pengguna", $data);
			//var_dump($authData);exit(0);
			
			if($temp->num_rows > 0){
				$line = $temp->fetch_assoc();
				$id = $line["ID"];
				//var_dump($id);exit(0);
				if($this->isBlocked($id)){
					return array("status"=>3, "reason"=>$line["AlasanBlokir"], "to"=>date("F d, Y", strtotime($line["SelesaiBlokir"])));
				}
				return array("status"=>0, "data"=>$line, "ID"=>$id);
			}else{
				$temp = $this->db->retrieve("pengguna", array("username"=>$data['username']));
				if($temp->num_rows>0)
					return array("status"=>2);
				else
					return array("status"=>1);
			}
		}
		
		public function getPengguna($data){
			$data = $this->validate($data);
			return $this->db->retrieve("pengguna", $data);
		}
		
		public function isBlocked($id){
			$query = "SELECT * FROM `aktor_sistem` WHERE `MulaiBlokir` IS NOT NULL AND NOW() >= `MulaiBlokir` AND NOW() <= `SelesaiBlokir` AND `ID`=$id";
			$temp = $this->db->specialQuery($query);
			return $temp->num_rows > 0;
		}
		
		public function savePasswordRecoveryData($data){
			$data = $this->validate($data);
			return $this->db->create("reset_data", $data);
		}
		
		public function getPasswordRecoveryData($data){
			$data = $this->validate($data);
			$temp = $this->db->retrieve("reset_data", $data);
			if($temp){
				$hash = $data['Hash'];
				$data = array("Hash"=>$hash);
				$this->db->delete("reset_data", $data);
				return $temp;
			}
			return false;
		}
		
		/////////////////////////////////////////////////// BADGE DI SINI //////////////////////////////////////////////////
		public function editPengguna($data){
			$data = $this->validate($data);
			$cond = array('ID'=>$data['ID']);
			unset($data['ID']);
			// echo "<br />data: <br />";var_dump($data);echo "<br />cond: <br />";var_dump($cond);exit(0);
			return $this->db->update("pengguna", $data, $cond);
		}	
		
		public function deletePengguna($data){
			$data = $this->validate($data);
			return $this->db->delete("pengguna", $data);
		}
		
		public function reset($data){
			$data = $this->validate($data);
			$cond = array('ID'=>$data['ID']);
			$data = array('Password'=>$data['Password']);
			return $this->db->update("pengguna", $data, $cond);
		}
		
		public function getAllPengguna(){
			return $this->db->retrieve("pengguna", true);
		}
		
		public function rate($data){
			$data = $this->validate($data);
			if($this->hasRated(array('IDPemberi'=>$data['IDPemberi'], 'IDPenerima'=>$data['IDPenerima']))){
				return false;
			}else{				
				$IDPemberi = $data['IDPemberi'];
				$IDPenerima = $data['IDPenerima'];
				$rating = $data['Rating'];
				$p = $_SESSION["SessionData"];
				$userInfo = $this->getPengguna(array("ID"=>$IDPenerima))->fetch_assoc();
				//var_dump($bookInfo);exit(0);
				$oldRaters = $userInfo['Jumlah_Rater'];
				$oldRating = $userInfo['Reputasi'];
				$newRating = ($rating+$oldRating*$oldRaters)/($oldRaters+1);
				$newRaters = $oldRaters + 1;
				
				$data = $this->validate(array('Reputasi'=>$newRating, 'Jumlah_Rater'=>$newRaters));
				$cond = $this->validate(array('ID'=>$IDPenerima));
				return $this->db->update("pengguna", $data, $cond) && $this->db->create("rater_pengguna", array("IDPenerima"=>$IDPenerima, "IDPemberi"=>$IDPemberi));
			}
		}
		
		public function hasRated($data){
			$data = $this->validate($data);
			$temp = $this->db->retrieve("rater_pengguna", $data);
			return  $temp !== false && $temp->num_rows > 0;
		}
		
		public function getUserStatus($data){
			$data = $this->validate($data);
			$temp = $this->db->retrieve("pengguna", $data);
			
			if($temp->num_rows > 0){
				$line = $temp->fetch_assoc();
				$id = $line["ID"];
				if($this->isBlocked($id)){
					return array("valid"=>false, "reason"=>"blocked");
				}
				return array("valid"=>true);
			}else{
				return array("valid"=>false, "reason"=>"deleted");
			}
		}
	}
	
	
?>