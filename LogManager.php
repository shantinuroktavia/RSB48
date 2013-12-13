<?php
	include_once("dam.php");
	
	class LogManager{
		private $db;		
		public function __construct(){
			$this->db = new DAM();
		}
		
		public function log($data){
			$data = $this->validate($data);
			return $this->db->create("feed", $data);
		}
		
		public function validate($data){
			$retVal = array();
			foreach($data as $key=>$value){
				if(is_array($value)){
					foreach($value as $k=>$v){
						$retVal[$key][$k] = $this->db->real_escape_string($v);
					}
				}else
					$retVal[$key] = $this->db->real_escape_string($value);
			}
			return $retVal;
		}
		
		public function createNotif($data){
			$data = $this->validate($data);
			return $this->db->createBeta("notifikasi", $data);
		}
		
		public function invalidateNotif($data){
			$data = $this->validate($data);
			return $this->db->updateBeta("notifikasi", array("status_notif"=>1), array("type"=>"AND", "cond"=>$data));
		}
		
	}
	
	
?>