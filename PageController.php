<?php
	class PageController{
		public static function dispatch($action, $data = NULL){
			
			if($data == NULL){
				//var_dump($data);exit(0);
				PageController::load($action.".tpt");
				
			}else{
				if($action == "daftar-pengguna"){		
					include_once("PenggunaManager.php");
					try{
						$pm = new PenggunaManager();
						$temp = $pm->getPengguna(array("username"=>$data["username"]));
						if($temp && $temp->num_rows>0){
							$data["message"] = "Registration Failed. The username you specify has been taken.";
							$data["password"] = "";
							PageController::load("daftar-pengguna.tpt", $data);
						}
						
						$temp = $pm->getPengguna(array("email"=>$data["email"]));
						if($temp && $temp->num_rows>0){
							$data["message"] = "Registration Failed. The email you specify have been used by another account.";
							$data["password"] = "";
							PageController::load("daftar-pengguna.tpt", $data);
						}
						
						$success = $pm->createPengguna($data);
						if($success){
							unset($_SESSION['daftar-pengguna.tpt']);
							PageController::load("halaman-utama.tpt", array("message"=>"Registration success. You may now login."));
						}else{
							$data["message"] = "Registration Failed. An error happens when saving to database.";
							$data["password"] = "";
							PageController::load("daftar-pengguna.tpt", $data);
						}
					}catch(Exception $e){
						$data["message"] = $e->getMessage();
						PageController::load("daftar-pengguna.tpt", $data);
					}
				}else if($action == "masuk"){	
					include_once("PenggunaManager.php");
					$pm = new PenggunaManager();
					define("SUCCESS", 0);
					define("INVALID_USERNAME", 1);
					define("INVALID_PASSWORD", 2);
					define("BLOCKED", 3);
					$authData = $pm->authenticate($data);
				
					//var_dump($authData);exit(0);					
					if($authData['status'] == SUCCESS){
						$p = $authData["data"];
						if($_SESSION['SystemMode'] == 0 && $p['isAdmin']==0 && $p['isAlphaTester'] == 0){
							PageController::load("halaman-utama.tpt", array("message"=>"We are now conducting alpha testing. Come back here later."));
						}
						PageController::setSessionData($p);
						if($p['isAdmin'] == 1){
							PageController::load("halaman-admin.tpt", array("message"=>"Login Success", "data"=>$p));
							$_SESSION['SessionData']['token'] = PageController::getRandomChars(20);
						}else
							PageController::load("halaman-utama.tpt", array("message"=>"Login Success", "data"=>$p));						
					}else if($authData['status'] == INVALID_USERNAME){
						PageController::load("halaman-utama.tpt", array("message"=>"Invalid username"));
					}else if($authData['status'] == INVALID_PASSWORD){
						PageController::load("halaman-utama.tpt", array("message"=>"Wrong password"));
					}else if($authData['status'] == BLOCKED){
						PageController::load("halaman-utama.tpt", array("message"=>"Your account is temporarily blocked until ${authData['to']} for reason: ${authData['reason']}"));
					}
					
				}else if($action == "keluar"){
					PageController::setSessionData();
					PageController::load("halaman-utama.tpt", array("message"=>"Logout success"));
				}else if($action == "lihat-profil"){
					$p = PageController::getSessionData();
					if($data === true){ //looking his own profile
						if($p == NULL){
							PageController::load("halaman-utama.tpt", array("message"=>"You are not logged in."));
						}else{							
							include_once("BukuManager.php");
							$pm = new BukuManager();
							$books = $pm->getAllBukuByPengguna(array("aktor_sistem.ID"=>$p['ID']));
							//var_dump($books); exit(0);
							$data = array("void"=>true);
							while($line = $books->fetch_assoc()){
								$data['books'][] = $line;
							}
							PageController::load("lihat-profil.tpt", $data);
						}
					}else if(is_array($data)){
						include_once("PenggunaManager.php");
						$pm = new PenggunaManager();
						$temp = $pm->getPengguna($data);
						
						$username = $data['username'];
						if($temp === false || $temp->num_rows == 0){
							PageController::load("halaman-utama.tpt", array("message"=>"Username you specified is not exists."));
						}
						
						//looking for his own profil
						$userInfo = $temp->fetch_assoc();
						if($userInfo['ID'] == $p['ID']){
							PageController::dispatch("lihat-profil", true);
							exit(0);
						}
						
						$canRate = !($pm->hasRated(array("IDPemberi"=>$p['ID'], "IDPenerima"=>$userInfo['ID'])));
						if($canRate){
							$userInfo['canRate'] = true;
						}
						
						include_once("BukuManager.php");
						$bm = new BukuManager();
						$books = $bm->getAllBukuByPengguna(array("aktor_sistem.ID"=>$userInfo['ID']));
						$data = array();
						while($line = $books->fetch_assoc()){
							$data['books'][] = $line;
						}
												
						PageController::load("lihat-profil-pengguna-lain.tpt", array_merge($data, $userInfo), array("user"=>$username));
					}
				}else if($action == "pesan-masuk"){	
					if(isset($_SESSION['pesan-masuk.tpt']))
						unset($_SESSION['pesan-masuk.tpt']);
					include_once("PesanManager.php");
					
					$p = PageController::getSessionData();					
					$pm = new PesanManager();
					
					if($data === true){
						$userId = $p['ID'];
						$p = $pm->getAllPesanByPengguna($userId);
						$data = array();
						while($line = $p->fetch_assoc()){
							$data[] = $line;
						}
						//var_dump($p); exit(1);	
						PageController::load("pesan-masuk.tpt", $data);
					}else{
						$pesanId = $data;
						$p = $pm->getPesan($pesanId);
						$p = $p->fetch_assoc();
						//var_dump($p); exit(1);	
						PageController::load("info-pesan.tpt", $p);
					}
				}else if($action == "kirim-pesan"){
					if(isset($_SESSION['kirim-pesan.tpt']))
						unset($_SESSION['kirim-pesan.tpt']);
						
					include_once("PesanManager.php");
					$pm = new PesanManager();
					$p = PageController::getSessionData();
					if(isset($data["receiverName"])){
						$data = array("to"=>$data["receiverName"]);
						PageController::load("kirim-pesan.tpt", $data);
					}
					
					
					try{
						$userId = $p['ID'];
						$data['senderId'] = $userId;
						$pm->kirimPesan($data);
						$p = $pm->getAllPesanByPengguna($userId);
						$data = array();
						while($line = $p->fetch_assoc()){
							$data[] = $line;
						}
						$data["message"] = "Message has been successfully sent.";
						//var_dump($p); exit(1);	
						unset($_SESSION['kirim_pesan']);
						PageController::load("pesan-masuk.tpt", $data);
					}catch(Exception $e){
						$data["message"] = $e->getMessage();
						PageController::load("kirim-pesan.tpt", $data);
					}
				}else if($action == "tambah-buku"){		
					include_once("BukuManager.php");
					$pm = new BukuManager();
					try{
						$bookId = $pm->addBuku($data);
						unset($_SESSION[$action.'.tpt']);
						
						$p = PageController::getSessionData();
						$userId = $p['ID'];
						$locationId = $p['LokasiID'];
						$bookTitle = $data['Judul'];
						$content = "Saya baru saja menambahkan buku berjudul <a href='controller.php?dispatch=info-buku&id=$bookId'>\"$bookTitle\"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.";
						PageController::log(array('tipe_feed'=>0, 'isi_feed'=>$content, 'id_user'=>$userId, 'id_lokasi'=>$locationId));
						PageController::load($action.'.tpt', array("message"=>"Congratulation, a new book has been added to your repo."));
					}catch(Exception $e){
						$data["message"] = $e->getMessage();
						PageController::load($action.'.tpt', $data);
					}
				}else if($action == "hapus-buku"){
					include_once("BukuManager.php");
					$bm = new BukuManager();
					$n = count($data);
					$p = PageController::getSessionData();
					if($_SESSION['SessionData']['isAdmin'] == 0){
						foreach($data as $id){ 
							$temp = $bm->getBuku(array("buku.IDBuku"=>$id, "aktor_sistem.ID"=>$p['ID']));
							$isValid = isset($temp['info']);
							//var_dump($isValid); exit(0);
							if(!$isValid){
								$data = array('message' => "You're not suppossed to delete books that are not yours.");
								PageController::load("halaman-utama.tpt", $data);
							}
							if(!$bm->deleteBuku(array("IDBuku"=>$id))){
								$_SESSION['PageController']['message'] = "Unable to delete book with id ".$id;
								PageController::dispatch("lihat-profil", true);
							}
						}
						$userId = $p['ID'];
						$locationId = $p['LokasiID'];
						$bookTitle = $temp['info']['Judul'];
						$content = "Saya baru saja menghapus buku $bookTitle dari direpositori saya.";
						PageController::log(array('tipe_feed'=>0, 'isi_feed'=>$content, 'id_user'=>$userId, 'id_lokasi'=>$locationId));
						
						$_SESSION['PageController']['message'] = "$n book(s) have been trashed.";
						PageController::dispatch("lihat-profil", true);
					}else if($_SESSION['SessionData']['isAdmin'] == 1){
						$data = array_unique($data, SORT_NUMERIC);
						$n = count($data);
						foreach($data as $id){ 
							if(!$bm->deleteBuku(array("IDBuku"=>$id))){
								$_SESSION['PageController']['message'] = "Unable to delete book with id ".$id;
								PageController::dispatch("lihat-daftar-buku", true);
							}
						}
						$_SESSION['PageController']['message'] = "$n book(s) have been trashed.";
						PageController::dispatch("lihat-daftar-buku", true);
					}else{
						PageController::dispatch("halaman-utama.tpt");
					}
				}else if($action == "prareset-password"){
					include_once("PenggunaManager.php");
					$pm = new PenggunaManager();	
					
					$temp = $pm->getPengguna($data);
					$email = $data["Email"];
					if($temp === false || $temp->num_rows == 0){
						$data['message'] = "Your email is not associated to any account.";
						PageController::load("prareset-password.tpt", $data);
					}else if($temp->num_rows == 1){ // Got you
						$userInfo = $temp->fetch_assoc();
						$hash = PageController::getRandomChars(20);
						$data = array("ID"=>$userInfo['ID'], "Hash"=>$hash, "Expire_Time"=>date("Y-m-d H:i:s", strtotime("+10 minutes")));
						$recoveryLink = "http://buku-kuliah.com/betalive/controller.php?dispatch=validasi-email&hash=$hash";
						//var_dump($data);exit(0);
						$pm->savePasswordRecoveryData($data);
						$to     = $email;
						$nama 	= $userInfo['Nama'];
						$subject = 'Password recovery';
						$message = "Hello $nama, please visit $recoveryLink to recover your password. ". "\r\n". "\r\n". "\r\n". "\r\n". "Do not reply this message";
						$headers = 'From: noreply@buku-kuliah.com' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();

						if(mail($to, $subject, $message, $headers)){
							$data = array("message"=>"Recovery link has been sent to your email. The link will be expired in 10 minutes. Hurry Up! ");
							PageController::load("prareset-password.tpt", $data);
						}
						
					}
				}else if($action == "validasi-email"){
					include_once("PenggunaManager.php");
					$pm = new PenggunaManager();
					
					$temp = $pm->getPasswordRecoveryData($data);
					if($temp->num_rows == 0){
						PageController::load("prareset-password.tpt", array("message"=>"Hash is not valid. Are you trying to break in our system?"));	
					}
					$data = $temp->fetch_assoc();
					
					$expireTime = new DateTime($data['Expire_Time']);
					$now = new DateTime();
					$interval =  date_diff($now, $expireTime); 
					$isValid = ($interval->format('%R')) == '+';
					
					if($isValid){					
						$_SESSION['userId'] = $data['ID'];
						PageController::load("reset-password.tpt", null);
					}else{
						$data = array("message"=>"Recovery link has been expired. Duuh!! ");
						PageController::load("prareset-password.tpt", $data);
					}
					
					//var_dump($data);exit(0);
				}else if($action == "reset-password"){
					//var_dump($data);exit(0);
					include_once("PenggunaManager.php");
					$pm = new PenggunaManager();
					if($pm->reset($data)){
						unset($_SESSION['userId']);
						$data = array("message"=>"Your password has been reset.  ");
						PageController::load("halaman-utama.tpt", $data);
					}else{
						$data = array("message"=>"You've just typed your old password!");
						PageController::load("reset-password.tpt", $data);
					}
				}else if($action == "ubah-profil"){
					include_once("PenggunaManager.php");
					$pm = new PenggunaManager();
					if($pm->editPengguna($data)){
						$temp = $pm->getPengguna(array("ID"=>$data['ID']));
						$p = $temp->fetch_assoc();
						PageController::setSessionData($p);
						
						include_once("BukuManager.php");
						$bm = new BukuManager();
						$books = $bm->getAllBukuByPengguna(array("aktor_sistem.ID"=>$p['ID']));
						$data = array();
						while($line = $books->fetch_assoc()){
							$data['books'][] = $line;
						}
						$data['message'] = "Your profile is now update.";
						unset($_SESSION["lihat-profil.tpt"]);
						PageController::load("lihat-profil.tpt", $data);
					}
					$data['message'] = "Updating failed. Please try again later.";
					unset($_SESSION["lihat-profil.tpt"]);
					PageController::load("ubah-profil.tpt", null);
				}else if($action == "info-buku"){
					include_once("BukuManager.php");
					include_once("LogManager.php");
					
					$p = PageController::getSessionData();
					$bm = new BukuManager();
					$bookId = $data["buku.IDBuku"];
					$data = $bm->getBuku($data);
					if($data['info']){
						$p = PageController::getSessionData();
						if(!$bm->hasRated(array("IDBuku"=>$data['info']['IDBuku'], "ID"=>$p['ID'])))
							$data['canRate'] = true;
							
						//var_dump($data);exit(0);
						$lm = new LogManager();
						$lm->invalidateNotif(array('id_user'=>$p['ID'], 'id_obj'=>$bookId, 'tipe_notif'=>'review'));
						PageController::load("info-buku.tpt", $data, array("id"=>$bookId));
					}else{
						PageController::load("halaman-utama.tpt", array("message"=>"Book id you specified is invalid."));
					}
				}else if($action == "ubah-info-buku"){
					include_once("BukuManager.php");
					$bm = new BukuManager();
					
					$session = PageController::getSessionData();
					$bookId = $data["buku.IDBuku"];
					$temp = $bm->getAllBukuByPengguna(array("buku.ID"=>$session['ID'], "buku.IDBuku"=>$bookId));
					if($temp->num_rows == 0)
						PageController::load("halaman-utama.tpt", array("message"=>"You're not authorized to edit the book."));
					
					// menampilkan form ubah informasi buku
					if(count($data) == 1){					
						$bookInfo = $bm->getBuku($data);
						//var_dump($bookInfo['reviews'][count($bookInfo['reviews'])-1]);exit(0);
						$tags = $bookInfo['tags'];					
						$temp = array();
						foreach($tags as $tag){
							$temp[] = $tag['Tag'];
						}
						$tags = implode(",", $temp);					
						$reviews = $bookInfo['reviews'][count($bookInfo['reviews'])-1]['Isi_Resensi'];
						
						$temp = $bookInfo['categories'];
						$cats = array();
						foreach($temp as $cat){
							$cats[] = $cat['IDKategori'];
						}
						
						$data = $bookInfo['info'];
						$data['Tags'] = $tags;
						$data['Kategori']  = $cats;
						$data['Resensi'] = $reviews;
						$data["buku.IDBuku"] = $bookId;
						$data["IDResensi"] = $bookInfo['reviews'][count($bookInfo['reviews'])-1]["IDResensi"];
						//var_dump($data);exit(0);
						PageController::load("ubah-info-buku.tpt", $data, array("id"=>$bookId));
					}else{  // menyimpan data buku yang baru
						//var_dump($data);exit(0);
						$cond = array("buku.ID"=>$session['ID'], "buku.IDBuku"=>$bookId);
						unset($data["buku.IDBuku"]);
						try{
							if($bm->editBuku($data, $cond)){
								$data = $bm->getBuku(array("buku.IDBuku"=>$bookId));
								$data['message'] = "Book has been successfully updated";
								unset($_SESSION[$action.'.tpt']);
								PageController::load("info-buku.tpt", $data, array("id"=>$bookId));
							}else{
								$data = $bm->getBuku(array("buku.IDBuku"=>$bookId));
								$data['message'] = "Book data cannot be updated";
								PageController::load("info-buku.tpt", $data, array("id"=>$bookId));
							}
						}catch(Exception $e){
							$data = $bm->getBuku(array("buku.IDBuku"=>$bookId));
							$data['message'] = $e->getMessage();
							PageController::load("info-buku.tpt", $data, array("id"=>$bookId));
						}
					}
				}else if($action == "lihat-pesan"){
					include_once("PesanManager.php");					
					$p = PageController::getSessionData();					
					$pm = new PesanManager();
					$temp = $pm->getPesan($data);
					$msg = $temp->fetch_assoc();
					//var_dump($msg);exit(0);
					if($msg && $msg['IDPenerima']==$p['ID']){
						$data = $msg;
						$prevId = $nextId = null;
						$temp = $pm->getAllPesanByPengguna($p['ID']);						
						//var_dump($msg);exit(0);
						$found = false;
						while(($line = $temp->fetch_assoc()) && !$found){
							//var_dump($line);exit(0);
							if($line['IDPesan'] == $msg['IDPesan']){
								$line = $temp->fetch_assoc();
								$nextId = isset($line['IDPesan'])?$line['IDPesan']:null;
								$found = true;
							}else
								$prevId = $line['IDPesan'];
						}
						$data['next'] = $nextId;
						$data['previous'] = $prevId;
						$msgId = $msg["IDPesan"];
						//var_dump($data);exit(0);
						PageController::load("lihat-pesan.tpt", $data, array("id"=>$msgId));
					}else{
						$data = array("message"=>"There's possibility the message has been deleted.");
						PageController::load("halaman-utama.tpt", $data);
					}
				}else if($action == "resensi"){
					$now = date("Y-m-d H:i:s");
					$p = PageController::getSessionData();	
					$id = $p['ID'];
					$data['Waktu_Resensi'] = $now;
					$data['IDPemberi'] = $id;
					$idBuku = $data['IDBuku'];
					
					include_once("BukuManager.php");
					$bm = new BukuManager();
					if($bm->addResensi($data)){
						$data = $bm->getBuku(array("buku.IDBuku"=>$idBuku));
						//var_dump($data);exit(0);
						$title = $data['info']['Judul'];
						$ownerId = $data['info']['ID'];
						$_SESSION["PageController"]['message'] = "Your review has been added.";
						PageController::log(array('tipe_feed'=>0, 'isi_feed'=>"Saya baru saja memberi resensi untuk buku berjudul \"$title\"", 'id_user'=>$id, 'id_lokasi'=>$p['LokasiID']));
						include_once('LogManager.php');
						$lm = new LogManager();
						if($ownerId != $id)
							$lm->createNotif(array('id_user'=>$ownerId, 'id_pemberi'=>$id, 'id_obj'=>$idBuku, 'tipe_notif'=>'review'));
						PageController::dispatch("info-buku", array("buku.IDBuku"=>$idBuku));
					}
					$_SESSION["PageController"]['message'] = "Your review can not be added.";
					PageController::dispatch("info-buku", array("buku.IDBuku"=>$idBuku));
				}else if($action == "pencarian"){
					include_once("BukuManager.php");								
					$pm = new BukuManager();
					$keyword = implode(" ",preg_split("/\s+/",trim($data['keywords'])));
					$page = (int)$data['page'];
					$offset = $page*10;
					$searchResult = $pm->search(array("terms"=>$keyword, "offset"=>$offset));					
					$total = $searchResult["total"];				
					
					$data = array();
					$data['keyword'] = $keyword;
					$data['total'] = $total;
					$data['page'] = $page;
					
					//var_dump($searchResult["data"]);exit(0);
					foreach($searchResult["data"] as $item){
						$temp2 = $pm->getKategori(array("buku.IDBuku"=>$item['IDBuku']));
						$cats = array();
						while($cat = $temp2->fetch_assoc()){
							$cats[] = $cat["Nama_Kategori"];
						}
						$item['Kategori'] = implode(", ", $cats);
						$data['books'][] = $item;
					}
					if($offset+10 < $total)
						$data['next'] = true;
					if($offset >= 10)
						$data['previous'] = true;
					//var_dump($data);exit(0);
					PageController::load("hasil-pencarian.tpt", $data);
				}else if($action == "rate-buku"){
					include_once("BukuManager.php");								
					$pm = new BukuManager();
					$success = $pm->rate($data);
					//var_dump($success);exit(0);
				}else if($action == "rate-pengguna"){
					include_once("PenggunaManager.php");								
					$pm = new PenggunaManager();
					$success = $pm->rate($data);
					//var_dump($success);exit(0);
				}else if($action == "lihat-daftar-pengguna"){
					include_once("PenggunaManager.php");								
					$pm = new PenggunaManager();
					$temp = $pm->getAllPengguna();
					$data = array();
					while($line = $temp->fetch_assoc()){
						if($line['isAdmin'] == 0)
							$data['users'][] = $line;
					}
					//var_dump($data);exit(0);
					PageController::load("lihat-daftar-pengguna.tpt", $data);
				}else if($action == "lihat-daftar-buku"){
					include_once("BukuManager.php");								
					$pm = new BukuManager();
					$all = $pm->getAllBuku();
					$cats = array();
					foreach($all as $line){
						foreach($line['categories'] as $cat){
							$cats[$cat["Nama_Kategori"]][] = $line['info'];
						}
					}
					//var_dump($cats);exit(0);
					PageController::load("lihat-daftar-buku.tpt", array('data'=>$cats));
				}else if($action == "ubah-sistem-mode"){
					if(isset($_SESSION['AdminValidated']) && $_SESSION['AdminValidated']){
						$mode = $_SESSION['Mode'];
						include_once("SistemManager.php");								
						$pm = new SistemManager();				
						unset($_SESSION['AdminValidated']);
						unset($_SESSION['Mode']);
						$pm->changeSystemMode($mode);
						$newMode = $pm::$modes[$mode];
						PageController::load("halaman-admin.tpt", array("message"=>"System mode has been changed to $newMode"));
					}else{ // belum divalidasi
						$_SESSION['Mode'] = $data['mode'];
						PageController::load("validasi-admin.tpt");
					}
				}else if($action == "validasi-admin"){
					include_once("PenggunaManager.php");								
					$pm = new PenggunaManager();
					$p = PageController::getSessionData();
					$data['ID'] = $p['ID'];
					$temp = $pm->getPengguna($data);
					if($temp->num_rows == 0)
						PageController::load("validasi-admin.tpt",array("message"=>"We cannot authenticate you. Try again."));
					else{
						$_SESSION['AdminValidated'] = true;
						PageController::load("konfirmasi-admin.tpt");
					}						
				}else if($action == "hapus-pengguna"){
					include_once("PenggunaManager.php");
					$pm = new PenggunaManager();
					$data = array_unique($data, SORT_NUMERIC);
					$n = count($data);
					foreach($data as $id){ 
						if(!$pm->deletePengguna(array("ID"=>$id))){
							$_SESSION['PageController']['message'] = "Unable to delete user with id ".$id;
							PageController::dispatch("lihat-daftar-pengguna", true);
						}
					}
					$_SESSION['PageController']['message'] = "$n user(s) have been deleted.";
					PageController::dispatch("lihat-daftar-pengguna", true);
				}else if($action == "keluhan"){
					include_once("KeluhanManager.php");
					$km = new KeluhanManager();
					include_once("PenggunaManager.php");
					$pm = new PenggunaManager();
					
					$type = $data['Type'];
					unset($data['Type']);
					
					
					$temp = PageController::getSessionData();
					$complainantId = $temp['ID'];
						
					if($type == 0 ){   // system complaint
						try{
							$content = "[".$data['Subject']."] ".$data['Isi_Keluhan'];
							$data = array("ID"=>$complainantId, "Isi_Keluhan"=>$content);
							$km->createKeluhan($data);
							$data = array('message' => "Your complaint has been saved. Thanks for your cooperation");
							PageController::load("halaman-utama.tpt", $data);
						}catch(Exception $e){
							$data = array('message' => $e->getMessage());
							PageController::load("halaman-utama.tpt", $data);
						}
					}else if($type == 1 ){ 
						$p = $pm->getPengguna(array("Username"=>$data["Subject"]));
						if($p->num_rows == 0){
							$data = array('message' => "Username is not found. Please try another one.", "showBox"=>true);
							PageController::load("lihat-profil.tpt", $data);
						}
						$p = $p->fetch_assoc();
						$subjectId = $p['ID'];
						
						
						if($subjectId == $complainantId){
							$data = array('message' => "It's illogical to complaint about yourself. Are you out of your mind?");
							PageController::load("halaman-utama.tpt", $data);
						}
						
						$content = $data['Isi_Keluhan'];
						
						$data = array("ID"=>$complainantId, "IDPenerima"=>$subjectId, "Isi_Keluhan"=>$content);
						
						try{
							$km->createKeluhan($data);
							$data = array('message' => "Your complaint has been saved. Thanks for your cooperation");
							PageController::load("halaman-utama.tpt", $data);
						}catch(Exception $e){
							$data = array('message' => $e->getMessage());
							PageController::load("halaman-utama.tpt", $data);
						}
						//var_dump($data);exit(0);
					}else{
						$data = array('message' => "Complaint type is unacceptable");
						PageController::load("halaman-utama.tpt", $data);
					}
				}else if($action == "lihat-daftar-keluhan"){					
					include_once("KeluhanManager.php");
					$km = new KeluhanManager();
					
					$comps = serialize($km->getAllKeluhan());
					$data = array("complaints"=>$comps);
					PageController::load("lihat-daftar-keluhan.tpt", $data);
				}else if($action == "blokir-pengguna"){					
					include_once("PenggunaManager.php");
					$pm = new PenggunaManager();
					$n = count($data['idBlock']);
					foreach($data['idBlock'] as $id){
						$temp = array("ID" => (int)$id,
						"MulaiBlokir" => $data['startDate'],
						"SelesaiBlokir" => $data['expireDate'],
						"AlasanBlokir" => $data['reason']);
						
						if(!$pm->editPengguna($temp)){
							$_SESSION['PageController']['message'] = "Unable to block user with id ".$id;
							PageController::dispatch("lihat-daftar-pengguna", true);
						}
					}
					
					$_SESSION['PageController']['message'] = "$n users has been successfully blocked";
					PageController::dispatch("lihat-daftar-pengguna", true);
				}else if($action == "lihat-keluhan"){	
					include_once("KeluhanManager.php");
					$km = new KeluhanManager();
					
					//var_dump($km->getKeluhan($data));exit(0);
					$temp = $km->getKeluhan($data);
					$complaint = $temp['data']; unset($temp['data']);
					if($complaint){ $temp['data'] = serialize($complaint);
						PageController::load("lihat-keluhan.tpt", $temp, array("id"=>$data['IDKeluhan']));
					}
					$_SESSION['PageController']['message'] = "Complaint Not Found.";
					PageController::dispatch("lihat-daftar-keluhan", true);					
				}else if($action == "solve-keluhan"){	
					include_once("KeluhanManager.php");
					$km = new KeluhanManager();
					
					//var_dump($km->getKeluhan($data));exit(0);
					$temp = $km->getKeluhan($data);
					$complaint = $temp['data'];
					if($complaint){
						//var_dump($complaint);exit(0);
						$km->solveKeluhan($data);
						$_SESSION['PageController']['message'] = "Complaint status has been set to 'solved'";
						PageController::dispatch("lihat-keluhan", $data);	
					}
					$_SESSION['PageController']['message'] = "Complaint Not Found.";
					PageController::dispatch("lihat-daftar-keluhan", true);					
				}else if($action == "hapus-keluhan"){	
					include_once("KeluhanManager.php");
					$km = new KeluhanManager();
					
					//var_dump($km->getKeluhan($data));exit(0);
					$temp = $km->getKeluhan($data);
					$complaint = $temp['data'];
					if($complaint){
						$km->deleteKeluhan($data);
						$_SESSION['PageController']['message'] = "Complaint has been deleted";
						PageController::dispatch("lihat-daftar-keluhan", true);		
					}
					$_SESSION['PageController']['message'] = "Complaint Not Found.";
					PageController::dispatch("lihat-daftar-keluhan", true);					
				}else if($action == "lihat-feed"){	
					include_once("FeedManager.php");
					include_once("LogManager.php");
					$fm = new FeedManager();
					$p = PageController::getSessionData();
					$id = $p['ID'];
					
					$feed = $fm->getFeed($data);
					if($p){
						$ownership = $fm->getOwnership(array('id_feed'=>$data['id_feed'], 'id_user'=>$id));
						if($ownership['owned']){
							$lm = new LogManager();
							$lm->invalidateNotif(array('id_user'=>$id, 'id_obj'=>$data['id_feed'], 'tipe_notif'=>'feed'));
						}
						$lm = new LogManager();
						$lm->invalidateNotif(array('id_user'=>$id, 'id_obj'=>$data['id_feed'], 'tipe_notif'=>'follow'));
					}
					//var_dump($feed);exit(0);
					if($feed){
						PageController::load("lihat-feed.tpt", $feed, array("id"=>$data['id_feed']));
					}
					PageController::load("halaman-utama.tpt", array("message"=>"Invalid Feed Id."));					
				}else if($action == "unfollow-feed"){	
					include_once("FeedManager.php");
					$fm = new FeedManager();
					
					if($fm->unFollow($data)){
						$_SESSION['PageController']['message'] = "You now unfollow this feed";
						PageController::dispatch("lihat-feed", $data);
					}
					$_SESSION['PageController']['message'] = "Cannot unfollow this feed...";
					PageController::dispatch("lihat-feed", $data);			
				}
			}	
		}
		
		public static function load($template, $data = NULL, $identifier = NULL){
			if(isset($_SESSION['PageController'])){
				$data = array_merge($data, $_SESSION['PageController']);
				unset($_SESSION['PageController']);
			}
			if($data != NULL){
				if($identifier == NULL)
					$_SESSION[$template] = $data;
				else{
					$temp = array_values($identifier); // identifier dipastikan array berdimensi satu
					$id = $temp[0];
					$_SESSION[$template][$id] = $data;
				}
			}	
			if($identifier != NULL){
				$id = "";
				foreach($identifier as $key=>$value){
					$id .= "$key=".urlencode($value)."&";
				}
				$id = substr($id, 0, strlen($id)-1);
				header("Location: view.php?p=".$template."&".$id);
				exit(0);
			}else{
				header("Location: view.php?p=".$template);
				exit(0);			
			}			
		}
		
		public static function validate($data){
			$retVal = array();
			foreach($data as $key=>$value){
				$retVal[$key] = $this->db->real_escape_string($value);
			}
			return $retVal;
		}
		
		public static function log($data){
			//$data = array('id_user'=>$id, 'isi_feed'=>$content, 'tipe_feed'=>1);
			include_once("LogManager.php");
			$lm = new LogManager();
			$lm->log($data);
		}
		
		public static function setSessionData($p = null){
			if($p == null){
				unset($_SESSION['SessionData']);
			}else
				$_SESSION['SessionData'] = $p;
		}
		public static function getSessionData(){
			include_once("PenggunaManager.php");
			$data = (isset($_SESSION['SessionData']))?$_SESSION['SessionData']:null;
			if($data){
				$id = $_SESSION['SessionData']['ID'];
				$pm = new PenggunaManager();
				$userStatus = $pm->getUserStatus(array("ID"=>$id));
				if($userStatus['valid']){
					return $data;
				}else{
					PageController::setSessionData();
					PageController::load("halaman-utama.tpt", array("message"=>"Your account is no longer valid for now."));
				}
			}
			return $data;
		}
		
		public static function getRandomChars($n){
			$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
			$str = "";
			for($i=0; $i<20; $i++)
				$str .= substr($chars, rand()%62, 1);
			return $str;
		}
	}
?>