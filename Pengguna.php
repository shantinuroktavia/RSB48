<?php
	class Pengguna{
		public $username, $password, $email, $lokasi, $imageURL, $isAdmin, $nama, $deskripsi, $firstUploadFlag, $fifthUploadFlag, $firstFullRatingFlag, $fifthFullRatingFlag;
		
		public function __construct($data){
			$this->username = $data['username'];
			$this->password = $data['password'];
			$this->email = $data['email'];
			$this->lokasi = $data['lokasi'];
			$this->imageURL = $data['imageURL'];
			$this->isAdmin = isset($data['isAdmin'])?$data['isAdmin']:'0';			
			$this->nama = $data['nama'];
			$this->deskripsi = $data['deskripsi'];
			
			$this->firstUploadFlag = $data['firstUploadFlag'];
			$this->fifthUploadFlag = $data['fifthUploadFlag'];
			$this->firstFullRatingFlag = $data['firstFullRatingFlag'];
			$this->fifthFullRatingFlag = $data['fifthFullRatingFlag'];
		}
	}			
?>