<?php
class DAM extends mysqli{
	public function __construct(){
		if($_SERVER['SERVER_NAME']=="localhost")
			parent::__construct("localhost", "bukuk426_c4", "cemp4t", "bukuk426_bukukuliah");
		else
			parent::__construct("localhost", "bukuk426_c4", "cemp4t", "bukuk426_bukukuliah");
	}
	
/////////////////////////////////////////////////////////////////////CREATE///////////////////////////////////////////////////////////////////////////////////////////
	
	public function create($tableName, $data){
		if($tableName == "pengguna"){
			$Username = $data->username;
			$Password = $data->password;
			$Lokasi = $data->lokasi;
			$URLFoto = $data->imageURL;
			$Email = $data->email;
			$Nama = $data->nama;
			$Deskripsi = $data->deskripsi;
			$query = "INSERT INTO `aktor_sistem` (`Username`, `Password`, `Lokasi`, `URLFoto`, `Email`, `Nama`, `Deskripsi`) 
								  VALUES('$Username', '$Password', '$Lokasi', '$URLFoto', '$Email', '$Nama', '$Deskripsi')";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "pesan"){
			$senderId = $data->senderId;
			$receiverId = $data->receiverId;
			$msgTime = $data->msgTime;
			$status = $data->status;
			$message = $data->message;
			$query = "INSERT INTO `pesan` (`ID`, `Isi_Pesan`, `Status_Pesan`, `Waktu_Pesan`, `IDPenerima`) 
								  VALUES('$senderId', '$message', '$status', '$msgTime', '$receiverId')";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "buku"){
			$query = "INSERT INTO `buku` (`ID`, `Judul`, `Penerbit`, `URLFoto`, `Edisi`,`Pengarang`,`Th_Terbit`) 
								  VALUES ('".$data->ID."','".$data->Judul."','".$data->Penerbit."','".$data->URLFoto."',".(($data->Edisi)?"'".($data->Edisi)."','":"NULL,'").$data->Pengarang."','".$data->Th_Terbit."');";
			//var_dump($query);exit(0);
			$this->query($query);
			return $this->insert_id;
		}else if($tableName == "tag"){
			$query = "INSERT INTO `tag` (`Tag`, `IDBuku`) 
								  VALUES ('".$data['Tag']."','".$data['IDBuku']."');";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "resensi"){
			$query = "INSERT INTO `resensi` (`IDBuku`,  `IDPemberi`, `Isi_Resensi`, `Waktu_Resensi`) 
								  VALUES ('".$data['IDBuku']."','".$data['IDPemberi']."','".$data['Isi_Resensi']."','".$data['Waktu_Resensi']."');";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "reset_data"){
			$query = "INSERT INTO `reset_data` (`ID`,  `Hash`, `Expire_Time`) 
								  VALUES ('".$data['ID']."','".$data['Hash']."','".$data['Expire_Time']."');";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "memiliki_kategori"){
			$query = "INSERT INTO `memiliki_kategori` (`IDBuku`,  `IDKategori`) 
								  VALUES ('".$data['IDBuku']."','".$data['IDKategori']."');";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "rater_buku"){
			$query = "INSERT INTO `rater_buku` (`IDBuku`,  `ID`) 
								  VALUES ('".$data['IDBuku']."','".$data['ID']."');";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "rater_pengguna"){
			$query = "INSERT INTO `rater_pengguna` (`IDPenerima`,  `IDPemberi`) 
								  VALUES ('".$data['IDPenerima']."','".$data['IDPemberi']."');";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "keluhan"){
			$columns = "";
			$values = "";
			foreach($data as $key=>$value){
				$columns .= "`$key`,";
				$values .= "'$value',"; 
			}
			$columns = substr($columns, 0, strlen($columns)-1);
			$values = substr($values, 0, strlen($values)-1);
			
			$query = "INSERT INTO `keluhan` ($columns) 
								  VALUES ($values);";
			//var_dump($query);exit(0);
			parent::query($query);
			return $this->affected_rows; 
		}else if($tableName == "feed"){
			$columns = "";
			$values = "";
			foreach($data as $key=>$value){
				$columns .= "`$key`,";
				$values .= "'$value',"; 
			}
			$columns = substr($columns, 0, strlen($columns)-1);
			$values = substr($values, 0, strlen($values)-1);
			
			$query = "INSERT INTO `feed` ($columns) 
								  VALUES ($values);";
			//var_dump($query);exit(0);
			parent::query($query);
			return $this->affected_rows; 
		}
	}
	
	public function createBeta($tableName, $data){
		$columns = "";
		$values = "";
		foreach($data as $key=>$value){
			$columns .= "`$key`,";
			$values .= "'$value',"; 
		}
		$columns = substr($columns, 0, strlen($columns)-1);
		$values = substr($values, 0, strlen($values)-1);
		
		$query = "INSERT INTO `$tableName` ($columns) 
							  VALUES ($values);";
		//var_dump($query);exit(0);
		parent::query($query);
		return $this->insert_id; 
	}

/////////////////////////////////////////////////////////////////////DELETE///////////////////////////////////////////////////////////////////////////////////////////
		
	public function delete($tableName, $data){	
		if($tableName == "buku"){		
			$affected = 0;
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `buku` WHERE $whereStatement";
			//var_dump($query);exit(0);
			parent::query($query);
			$affected += $this->affected_rows;
			
			$this->delete("tag", $data);
			$affected += $this->affected_rows;
			
			$this->delete("resensi", $data);
			$affected += $this->affected_rows;
			
			$this->delete("memiliki_kategori", $data);
			$affected += $this->affected_rows;
			
			return $affected ;
		}else if($tableName == "reset_data"){
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `reset_data` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "tag"){
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `tag` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "resensi"){
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `resensi` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "pesan"){
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `pesan` WHERE $whereStatement";
			//var_dump($query);exit(0);
			parent::query($query);
			return $this->affected_rows; 
		}else if($tableName == "rater_pengguna"){
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `rater_pengguna` WHERE $whereStatement";
			//var_dump($query);exit(0);
			parent::query($query);
			return $this->affected_rows; 
		}else if($tableName == "rater_buku"){
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `rater_buku` WHERE $whereStatement";
			//var_dump($query);exit(0);
			parent::query($query);
			return $this->affected_rows; 
		}else if($tableName == "memiliki_kategori"){
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `memiliki_kategori` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "pengguna"){
			$affected = 0;
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `aktor_sistem` WHERE $whereStatement";
			
			$temp = array("aktor_sistem.ID"=>$data['ID']);
			$bookList = $this->retrieve("buku-pengguna", $temp);
			
			while($line = $bookList->fetch_assoc()){
				$bookId = $line['IDBuku'];
				$this->delete("buku", array("IDBuku"=>$bookId));
				$affected += $this->affected_rows;	
			}	
			
			$this->delete("pesan", array("IDPenerima"=>$data['ID']));
			$affected += $this->affected_rows;
			$this->delete("resensi", array("IDPemberi"=>$data['ID']));
			$affected += $this->affected_rows;		
			
			parent::query($query);	
			$affected += $this->affected_rows;
			
			return $affected;
		}else if($tableName == "keluhan"){
			$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "DELETE FROM `keluhan` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}
	}
	
	
/////////////////////////////////////////////////////////////////////RETRIEVE///////////////////////////////////////////////////////////////////////////////////////////
	
	public function retrieve($tableName, $data){
		if($tableName == "pengguna"){
			if($data === true){
				$query = "SELECT `ID`,`isAdmin`,`Username`,`Nama`,`Email`,`Password`, `Lokasi` as `LokasiID`,`nama_lokasi` AS Lokasi,`Reputasi`,`Deskripsi`,`MulaiBlokir`,`SelesaiBlokir`,`AlasanBlokir`,`URLFoto`,`isAlphaTester`,`Jumlah_Rater` FROM `aktor_sistem` LEFT JOIN `lokasi` ON `lokasi`.`id_lokasi` = `aktor_sistem`.`Lokasi` WHERE 1";
			}else{	
				$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
				$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
				$query = "SELECT `ID`,`isAdmin`,`Username`,`Nama`,`Email`,`Password`, `Lokasi` as `LokasiID`,`nama_lokasi` AS Lokasi,`Reputasi`,`Deskripsi`,`MulaiBlokir`,`SelesaiBlokir`,`AlasanBlokir`,`URLFoto`,`isAlphaTester`,`Jumlah_Rater` FROM `aktor_sistem` LEFT JOIN `lokasi` ON `lokasi`.`id_lokasi` = `aktor_sistem`.`Lokasi` WHERE $whereStatement";
			}
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "pesan"){
			$whereStatement = "";
			foreach($data as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "SELECT * FROM `pesan` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "pesan-pengguna"){
			$whereStatement = "";
			foreach($data as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "SELECT aktor_sistem.ID as IDPengirim, pesan.IDPenerima as IDPenerima, aktor_sistem.Nama as Nama, Username,  IDPesan, Isi_Pesan, Status_Pesan, Waktu_Pesan  FROM `pesan` LEFT JOIN aktor_sistem ON pesan.ID = aktor_sistem.ID WHERE $whereStatement ORDER BY Waktu_Pesan DESC";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "buku"){		
			$bookData = array();
			if($data === true){		
				$counter = 0;
				$temp = $this->retrieve("buku-pengguna", $data);
				while($line = $temp->fetch_assoc()){
					$bookData[$counter]['info'] = $line;
					$data = array("buku.IDBuku"=>$line['IDBuku']);
					$data = $this->retrieve("kategori", $data);
					$cats = $this->toArray($data);
					$bookData[$counter++]['categories'] = $cats;
				}
			}else{
				$temp = $this->retrieve("buku-pengguna", $data);
				$bookData['info'] = $temp->fetch_assoc();
				
				$temp = $this->retrieve("resensi", array("buku.IDBuku"=>$data['buku.IDBuku']));			
				$reviews = $this->toArray($temp);		
				$bookData['reviews'] = $reviews;
						
				$temp = $this->retrieve("kategori", array("buku.IDBuku"=>$data['buku.IDBuku']));
				$cats = $this->toArray($temp);
				$bookData['categories'] = $cats;
				
				$temp = $this->retrieve("tag", array("IDBuku"=>$data['buku.IDBuku']));
				$cats = $this->toArray($temp);
				$bookData['tags'] = $cats;
			}
			//var_dump($bookData);echo "<br>"; exit(0);
			return $bookData;
		}else if($tableName == "reset_data"){
			$whereStatement = "";
			foreach($data as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "SELECT * FROM `reset_data` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "buku-pengguna"){
			if($data === true){
				$query = "SELECT aktor_sistem.ID as ID, Nama, IDBuku, Judul, Penerbit, buku.URLFoto, Edisi, Pengarang, Th_Terbit, Rating, buku.Jumlah_Rater as Jumlah_Rater, Status, Username  FROM `buku` LEFT JOIN `aktor_sistem` ON `buku`.`ID` = `aktor_sistem`.`ID` WHERE 1";
			}else{
				$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
				$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
				$query = "SELECT aktor_sistem.ID as ID, Nama, IDBuku, Judul, Penerbit, buku.URLFoto, Edisi, Pengarang, Th_Terbit, Rating, buku.Jumlah_Rater as Jumlah_Rater, Status, Username  FROM `buku` LEFT JOIN `aktor_sistem` ON `buku`.`ID` = `aktor_sistem`.`ID` WHERE $whereStatement";
			}
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "tag"){
			$whereStatement = "";
			foreach($data as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "SELECT Tag  FROM `tag` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "resensi"){
			$whereStatement = "";
			foreach($data as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			//$query = "SELECT IDBuku, Nama, Isi_Resensi, Waktu_Resensi, Username  FROM `buku` LEFT JOIN `resensi` ON `buku`.`ID` = `resensi`.`IDPemberi` WHERE $whereStatement";
			$query = "SELECT Username, Nama,  IDBuku, Isi_Resensi, Waktu_Resensi, IDResensi FROM 
							(SELECT resensi.IDBuku as IDBuku, IDPemberi as ID, Isi_Resensi, IDResensi, Waktu_Resensi FROM `buku` LEFT JOIN `resensi` ON `buku`.`IDBuku` = `resensi`.`IDBuku` WHERE $whereStatement) sb LEFT JOIN aktor_sistem
								ON sb.ID = aktor_sistem.id WHERE 1 ORDER BY Waktu_Resensi DESC";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "kategori"){
			if($data === true){
				$query = "SELECT IDKategori , Nama_Kategori FROM kategori WHERE 1";
			}else{
				$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
				$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
				$query = "SELECT sb.IDKategori as IDKategori, Nama_Kategori FROM
							(SELECT memiliki_kategori.IDKategori as IDKategori FROM memiliki_kategori LEFT JOIN buku ON  memiliki_kategori.IDBuku = buku.IDBuku WHERE $whereStatement) sb LEFT JOIN kategori
							ON sb.IDKategori = kategori.IDKategori";
			}
			//var_dump($query);echo "<br>"; var_dump(parent::query($query)); exit(0);
			return parent::query($query);
		}else if($tableName == "rater_buku"){
			$whereStatement = "";
			foreach($data as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "SELECT * FROM `rater_buku` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "sistem"){
			$whereStatement = "";
			foreach($data as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "SELECT * FROM `sistem` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "rater_pengguna"){
			$whereStatement = "";
			foreach($data as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			$query = "SELECT * FROM `rater_pengguna` WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "keluhan"){
			if($data === true){
				$query = "SELECT complainantName, complainantUsername, `aktor_sistem`.`Nama` as subjectName, `aktor_sistem`.`Username` as subjectUsername, `IDKeluhan`, `Isi_Keluhan`, `Waktu_Keluhan`, `status_keluhan` FROM
							( SELECT `aktor_sistem`.`Nama` as complainantName, `aktor_sistem`.`Username` as complainantUsername, `IDKeluhan`, `Isi_Keluhan`, `Waktu_Keluhan`, `IDPenerima`, `status_keluhan` FROM `keluhan` LEFT JOIN `aktor_sistem` ON `aktor_sistem`.`ID`=`keluhan`.`ID` ) A
						        LEFT JOIN 
							`aktor_sistem` 
							ON `aktor_sistem`.`ID`=A.`IDPenerima`
							WHERE 1 ORDER BY `Waktu_Keluhan` DESC";
				//var_dump($query);exit(0);
				return parent::query($query);
			}else{
				$whereStatement = "";
				foreach($data as $key=>$value){
					$whereStatement .= "$key='$value' AND ";
				}
				$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
				$query = "SELECT complainantName, complainantUsername, `aktor_sistem`.`Nama` as subjectName, `aktor_sistem`.`Username` as subjectUsername, `IDKeluhan`, `Isi_Keluhan`, `Waktu_Keluhan`, `status_keluhan` FROM
							( SELECT `aktor_sistem`.`Nama` as complainantName, `aktor_sistem`.`Username` as complainantUsername, `IDKeluhan`, `Isi_Keluhan`, `Waktu_Keluhan`, `IDPenerima`, `status_keluhan` FROM `keluhan` LEFT JOIN `aktor_sistem` ON `aktor_sistem`.`ID`=`keluhan`.`ID` ) A
						        LEFT JOIN 
							`aktor_sistem` 
							ON `aktor_sistem`.`ID`=A.`IDPenerima`
							WHERE $whereStatement";
				//var_dump($query);exit(0);
				return parent::query($query);
			}
		}else if($tableName == "lokasi"){
			$query = "SELECT `id_lokasi`, `nama_lokasi` FROM `lokasi` WHERE 1";			
			//var_dump($query);echo "<br>"; var_dump(parent::query($query)); exit(0);
			return parent::query($query);
		}
	}
	
	public function retrieveBeta($tableName, $cond){
		$conj = $cond['type'];
		$data = $cond['cond'];
		
		$whereStatement = "";
		foreach($data as $key=>$value){
			$whereStatement .= "$key='$value' $conj ";
		}
		$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
		$query = "SELECT * FROM `$tableName` WHERE $whereStatement";
		//var_dump($query);exit(0);
		return parent::query($query);
	}
	
	public function deleteBeta($tableName, $cond){
		$conj = $cond['type'];
		$data = $cond['cond'];
		
		$whereStatement = "";
		foreach($data as $key=>$value){
			$whereStatement .= "$key='$value' $conj ";
		}
		$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
		$query = "DELETE FROM `$tableName` WHERE $whereStatement";
		//var_dump($query);exit(0);
		parent::query($query);
		return $this->affected_rows;
	}
	
/////////////////////////////////////////////////////////////////////UPDATE///////////////////////////////////////////////////////////////////////////////////////////
	
	public function update($tableName, $data, $cond){
		if($tableName == "pengguna"){
			$tableUpdate = "";
				foreach($data as $key=>$value){
					$tableUpdate .= "$key='$value', ";
				}
			$tableUpdate = substr($tableUpdate, 0, strlen($tableUpdate)-2);
			
			$whereStatement = "";
			foreach($cond as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			
			
			$query = "UPDATE `aktor_sistem` SET $tableUpdate WHERE $whereStatement";
			parent::query($query);
			//var_dump($query);exit(0);
			return $this->affected_rows;
		}else if($tableName == "buku"){
			$tableUpdate = "";
				foreach($data as $key=>$value){
					$tableUpdate .= "$key='$value', ";
				}
			$tableUpdate = substr($tableUpdate, 0, strlen($tableUpdate)-2);
			
			$whereStatement = "";
			foreach($cond as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			
			
			$query = "UPDATE `buku` SET $tableUpdate WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "tag"){
			if($this->delete("tag", $cond)){
				foreach($data as $tag){
					if(!$this->create("tag", array("Tag"=>$tag, "IDBuku"=>$cond["IDBuku"])))
						return false;
				}
			}
			return true;
		}else if($tableName == "memiliki_kategori"){
			if($this->delete("memiliki_kategori", $cond)){
				foreach($data as $tag){
					if(!$this->create("memiliki_kategori", array("IDKategori"=>$tag, "IDBuku"=>$cond["IDBuku"])))
						return false;
				}
			}
			return true;
		}else if($tableName == "resensi"){
			$tableUpdate = "";
				foreach($data as $key=>$value){
					$tableUpdate .= "$key='$value', ";
				}
			$tableUpdate = substr($tableUpdate, 0, strlen($tableUpdate)-2);
			
			$whereStatement = "";
			foreach($cond as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			
			
			$query = "UPDATE `resensi` SET $tableUpdate WHERE $whereStatement";
			//var_dump($query);exit(0);
			return parent::query($query);
		}else if($tableName == "pesan"){
			$tableUpdate = "";
				foreach($data as $key=>$value){
					$tableUpdate .= "$key='$value', ";
				}
			$tableUpdate = substr($tableUpdate, 0, strlen($tableUpdate)-2);
			
			$whereStatement = "";
			foreach($cond as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			
			
			$query = "UPDATE `pesan` SET $tableUpdate WHERE $whereStatement";
			//var_dump(parent::query($query));exit(0);
			return parent::query($query);
		}else if($tableName == "sistem"){
			$tableUpdate = "";
				foreach($data as $key=>$value){
					$tableUpdate .= "$key='$value', ";
				}
			$tableUpdate = substr($tableUpdate, 0, strlen($tableUpdate)-2);
			
			$whereStatement = "";
			foreach($cond as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			
			
			$query = "UPDATE `sistem` SET $tableUpdate WHERE $whereStatement";
			parent::query($query);
			return $this->affected_rows;
		}else if($tableName == "keluhan"){
			$tableUpdate = "";
				foreach($data as $key=>$value){
					$tableUpdate .= "$key='$value', ";
				}
			$tableUpdate = substr($tableUpdate, 0, strlen($tableUpdate)-2);
			
			$whereStatement = "";
			foreach($cond as $key=>$value){
				$whereStatement .= "$key='$value' AND ";
			}
			$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);
			
			
			$query = "UPDATE `keluhan` SET $tableUpdate WHERE $whereStatement";
			//var_dump($query);exit(0);
			parent::query($query);
			return $this->affected_rows;
		}
	}
	
	public function updateBeta($tableName, $data, $cond){
		$conj = $cond['type'];
		$cond = $cond['cond'];
		
		$tableUpdate = "";
			foreach($data as $key=>$value){
				$tableUpdate .= "$key='$value', ";
			}
		$tableUpdate = substr($tableUpdate, 0, strlen($tableUpdate)-2);
		
		$whereStatement = "";
		foreach($cond as $key=>$value){
			$whereStatement .= "$key='$value' $conj ";
		}
		$whereStatement = substr($whereStatement, 0, strlen($whereStatement)-4);	
		
		$query = "UPDATE `$tableName` SET $tableUpdate WHERE $whereStatement";
		//var_dump($query); exit(0);
		parent::query($query);
		return $this->affected_rows;
	}
	
	public function toArray($data){
		$result = array();
		if($data->num_rows > 0)
			while($line = $data->fetch_assoc()){
				$result[] = $line;
			}
		return $result;
	}
	
	public function specialQuery($query){
		return parent::query($query);
	}
	
	public function search($data){
		$query = "SELECT DISTINCT ID, Nama, IDBuku, Judul, Penerbit, URLFoto, Edisi, Pengarang, Th_Terbit, Rating, Status, Username FROM (
						(	
							(SELECT aktor_sistem.ID as ID, Nama, IDBuku, Judul, Penerbit, buku.URLFoto, Edisi, Pengarang, Th_Terbit, Rating, Status, Username FROM `buku` LEFT JOIN `aktor_sistem` ON `buku`.`ID` = `aktor_sistem`.`ID` WHERE IDBuku in (SELECT IDBuku FROM `tag` WHERE `Tag` LIKE '%${data['terms']}%') OR `Judul` LIKE '%${data['terms']}%')
							UNION 
							(SELECT aktor_sistem.ID as ID, Nama, IDBuku, Judul, Penerbit, buku.URLFoto, Edisi, Pengarang, Th_Terbit, Rating, Status, Username FROM `buku` LEFT JOIN `aktor_sistem` ON `buku`.`ID` = `aktor_sistem`.`ID` WHERE (match(Judul) against('${data['terms']}' IN BOOLEAN MODE)) OR (match(Pengarang) against('${data['terms']}' IN BOOLEAN MODE)) OR (match(Penerbit) against('${data['terms']}' IN BOOLEAN MODE)))
						) A
				 ) WHERE 1 LIMIT 10 OFFSET ${data['offset']} 
				";
				
		$totalQuery = "SELECT COUNT(DISTINCT IDBuku) as total FROM (
					(	
						(SELECT aktor_sistem.ID as ID, Nama, IDBuku, Judul, Penerbit, buku.URLFoto, Edisi, Pengarang, Th_Terbit, Rating, Status, Username FROM `buku` LEFT JOIN `aktor_sistem` ON `buku`.`ID` = `aktor_sistem`.`ID` WHERE IDBuku in (SELECT IDBuku FROM `tag` WHERE `Tag` LIKE '%${data['terms']}%')  OR `Judul` LIKE '%${data['terms']}%')
						UNION 
						(SELECT aktor_sistem.ID as ID, Nama, IDBuku, Judul, Penerbit, buku.URLFoto, Edisi, Pengarang, Th_Terbit, Rating, Status, Username FROM `buku` LEFT JOIN `aktor_sistem` ON `buku`.`ID` = `aktor_sistem`.`ID` WHERE (match(Judul) against('${data['terms']}' IN BOOLEAN MODE)) OR (match(Pengarang) against('${data['terms']}' IN BOOLEAN MODE)) OR (match(Penerbit) against('${data['terms']}' IN BOOLEAN MODE)))
					) A
			 ) WHERE 1
			";
		//var_dump($query); exit(0);	
		$temp = parent::query($totalQuery)->fetch_assoc();
		$total = $temp['total'];
		$temp = parent::query($query);
		$data = array();
		while($line = $temp->fetch_assoc()){
			$data[] = $line;
		}
		return (array("total"=>$total, "data"=>$data));	
	}
}
?>