<?php 
	class Keluhan{
		public $complainantName, $complainantUsername, $content, $type, $time, $subjectName, $subjectUsername, $complaintId, $solved;
		public function __construct($data){		
			$this->complainantName = $data['complainantName'];
			$this->complainantUsername = $data['complainantUsername'];
			$this->subjectName = $data['subjectName'];
			$this->subjectUsername = $data['subjectUsername'];
			$this->complaintId = $data['IDKeluhan'];
			$this->content = $data['Isi_Keluhan'];
			$this->time = $data['Waktu_Keluhan'];
			$this->type = ($data['subjectName'] == NULL)?0:1;
			$this->solved = $data['status_keluhan']=="solved";
		}
	}			
?>