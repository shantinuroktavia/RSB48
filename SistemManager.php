<?php
/*
Sistem Manager.php merupakan class untuk mengatur System Mode.
System mode ada tiga jenis: Developing, Maintaining, Release.
Developing : sistem sedang dalam pengembangan, hanya user tertentu (alfatester) yang bisa masuk
Maintaining : sistem ditutup secara total
Release: sistem dibuka.

*/
	//include class DAM
	include_once("dam.php");
	//Mendefinisikan representasi drai setiap mode
	define("DEVELOPING", 0);
	define("MAINTAINING", 1);
	define("RELEASE", 2);
	
	/* Class SistemManager merupakan class pengatur mode system
	@author : C4 / PPL 2013
	*/
	class SistemManager{
		private $db;
		public static $modes = array("DEVELOPING", "MAINTAINING", "RELEASE");
		public function __construct(){
			$this->db = new DAM();
		}
		//Method untuk mengubah sistem mode
		public function changeSystemMode($mode){
		//condition untuk mengaktifkan suatu mode system
			switch($mode){
				case DEVELOPING:
					return $this->db->update("sistem", array("mode"=>0), array("ID"=>1));
				case MAINTAINING:
					return $this->db->update("sistem", array("mode"=>1), array("ID"=>1));
				case RELEASE:
					return $this->db->update("sistem", array("mode"=>2), array("ID"=>1));
			}
		}
		//method untuk mendapatkan status sistem mode
		public function getSystemMode(){
			$temp = $this->db->retrieve("sistem", array("ID"=>1))->fetch_assoc();
			return $temp["mode"];
		}
	}
?>