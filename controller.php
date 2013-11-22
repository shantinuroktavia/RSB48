<?php
	session_start();
	include_once("PageController.php");
	include_once("Statics.php");	
	include_once("SistemManager.php");	
	
	$pm = new SistemManager();
	
	$_SESSION['SystemMode'] = $pm->getSystemMode();
	if($_SESSION['SystemMode'] == 1 && ((!isset($_SESSION['SessionData'])) || (isset($_SESSION['SessionData']) && ($_SESSION['SessionData']['isAdmin'] != 1)))){
		header("Location: index.php");
		exit(0);
	}
	
	if($_SERVER['SERVER_NAME']=="localhost")
		$uploadDir = "C:\\xampp\\htdocs\\buku-kuliah\\betalive\\uploads\\";
	else if($_SERVER['SERVER_NAME']=="buku-kuliah.com")
		$uploadDir = "/home/bukuk426/public_html/betalive/uploads/";
	else if($_SERVER['SERVER_NAME']=="192.168.1.102")
		$uploadDir = "/home/pi/htdocs/buku-kuliah/betalive/uploads/";
	
	$action = $_REQUEST['dispatch'];
	if($action == "daftar-pengguna"){
		if(PageController::getSessionData()){
			$_SESSION['halaman-utama.tpt']['message'] = "Logout first.";
			PageController::load("halaman-utama.tpt", array("message"=>"Logout first."));	
		}
		if(isset($_POST['username'])){				
			if(Statics::validateUsername($_POST['username']) == 0){
				$_SESSION[$action.".tpt"] = $_POST;
				$_SESSION[$action.".tpt"]["message"] = "Username must be bounded by alphanumeric and contain only alphanumeric, -, _, and having 6 - 15 characters of length";
				//var_dump($_SESSION[$action.".tpt"]);exit(0);
				$_SESSION[$action.".tpt"]["username"] = "";
				PageController::load("daftar-pengguna.tpt", $_SESSION[$action.".tpt"]);	
			}
			
			if(Statics::validateName($_POST['nama']) == 0){
				$_SESSION[$action.".tpt"] = $_POST;
				$_SESSION[$action.".tpt"]["message"] = "Try another name.";
				$_SESSION[$action.".tpt"]["nama"] = "";
				PageController::load("daftar-pengguna.tpt", $_SESSION[$action.".tpt"]);
			} 
				
			if(Statics::validateEmail($_POST['email']) == 0){
				$_SESSION[$action.".tpt"] = $_POST;
				$_SESSION[$action.".tpt"]["message"] = "Email format is unacceptable.";
				$_SESSION[$action.".tpt"]["email"] = "";
				PageController::load("daftar-pengguna.tpt", $_SESSION[$action.".tpt"]);
			}
			
			if(Statics::validatePassword($_POST['password']) == 0){
				$_SESSION[$action.".tpt"] = $_POST;
				$_SESSION[$action.".tpt"]["password"] = "";
				$_SESSION[$action.".tpt"]["password2"] = "";
				$_SESSION[$action.".tpt"]["message"] = "Password must contain alphanumeric, spaces, symbols, and having 6 - 15 characters of length";
				PageController::load("daftar-pengguna.tpt", $_SESSION[$action.".tpt"]);	
			}
			
			if($_POST['password'] !== $_POST['password2']){
				$_SESSION[$action.".tpt"] = $_POST;
				$_SESSION[$action.".tpt"]["password"] = "";
				$_SESSION[$action.".tpt"]["password2"] = "";
				$_SESSION[$action.".tpt"]["message"] = "Passwords you typed are mismatch.";
				PageController::load("daftar-pengguna.tpt", $_SESSION[$action.".tpt"]);	
			}
			
			if(strlen($_POST['deskripsi']) > 250){
				$_SESSION[$action.".tpt"] = $_POST;
				$_SESSION[$action.".tpt"]["message"] = "Your description must not be over 250 characters.";
				PageController::load("daftar-pengguna.tpt", $_SESSION[$action.".tpt"]);	
			}
						
			$uploadFile = $uploadDir .$_POST['username']."-". basename($_FILES['picture']['name']);
			if($pm->getSystemMode() == RELEASE){
				$data = array();
				$data['username'] = $_POST['username'];
				$data['password'] = md5($_POST['password']);
				$data['email'] = $_POST['email'];
				$data['lokasi'] = (int)$_POST['lokasi'];
				$data['nama'] = $_POST['nama'];
				$data['deskripsi'] = $_POST['deskripsi'];
				
				$valid = Statics::validatePhoto($_FILES['picture']);  //ngevalidasi data image
				if(!$valid['valid']){ //kalo nggak valid
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = $valid['message'];
					PageController::load("daftar-pengguna.tpt", $_SESSION[$action.".tpt"]);	
				}else{
					if (!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)){ //kalo ada error waktu mindahkan dari folder temporary ke sebenarnya
						//var_dump($_FILES['picture']);exit(0);
						$_SESSION[$action.".tpt"] = $_POST;
						$_SESSION[$action.".tpt"]["message"] = "Photo cannot be moved.";
						PageController::load("daftar-pengguna.tpt", $_SESSION[$action.".tpt"]);
					}else{
						$data['imageURL'] = "uploads/".$_POST['username']."-". basename($_FILES['picture']['name']);		
						PageController::dispatch($action, $data);
					}
				}
			}else if($pm->getSystemMode() == DEVELOPING){			
				PageController::load($action.".tpt", array("message"=>"We are currently in alpha testing. No registration is allowed. Thanks."));
			}			
		}else{
			PageController::dispatch($action);
		}
	}else if($action == "masuk"){
		$data = array();
		$data["username"] = $_POST["username"];
		$data["password"] = md5($_POST["password"]);
		PageController::dispatch($action, $data);
	}else if($action == "keluar"){
		if(PageController::getSessionData()){
			PageController::setSessionData();
			PageController::load("halaman-utama.tpt", array("message"=>"Logout success"));
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You haven't logged in yet."));
		}
	}else if($action == "lihat-profil"){
		if(!isset($_GET['user'])){
			if(PageController::getSessionData()){		
				PageController::dispatch($action, true);
			}else{
				PageController::load("halaman-utama.tpt", array("message"=>"You haven't logged in yet."));
			}
		}else{
			PageController::dispatch($action, array("username"=>$_GET['user']));
		}
	}else if($action == "pesan-masuk"){
		PageController::dispatch($action, isset($_GET['id'])?$_GET['id']:true);
	}else if($action == "kirim-pesan"){
		if(PageController::getSessionData()){
			$data = $_POST;
$_POST['subject'] = preg_replace("|\s+|"," ", trim($_POST['subject']));
$_POST['content'] = preg_replace("|[ ]+|"," ", trim($_POST['content']));
			if(isset($_POST['to']) && isset($_POST['subject']) && isset($_POST['content'])){
				if(strlen($_POST['subject']) < 5 || strlen($_POST['subject']) > 30){
					$data["message"] = "Subject length must be 5-30 non-whitespace characters";
					PageController::load($action.".tpt", $data);
				}
				if(strlen($_POST['content']) < 5 || strlen($_POST['content']) > 300){
					$data["message"] = "Content of the message must be having 5-300 non-whitespace characters";
					PageController::load($action.".tpt", $data);
				}
				PageController::dispatch($action, array("to"=>$_POST['to'], "content"=>"[".$_POST['subject']."] ".$_POST['content']));
			}else{
				if(isset($_GET['user'])){
					PageController::dispatch($action, array("receiverName"=>$_GET['user']));
				}else{
					PageController::dispatch($action);
				}
			}
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You haven't logged in yet."));
		}
	}else if($action == "tambah-buku"){
		if(PageController::getSessionData()){		
			if(isset($_POST['Judul'])){		
				if(Statics::validateBookTitle($_POST['Judul']) == 0){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = "Book title should have 2-40 non-whitespace characters.";
					$_SESSION[$action.".tpt"]["Judul"] = "";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);
				} 
				
				if(Statics::validateBookEdition($_POST['Edisi']) == 0){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = "Book edition must either empty or integer.";
					$_SESSION[$action.".tpt"]["Edisi"] = "";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);
				} 				
				
				if(Statics::validateName($_POST['Pengarang']) == 0){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["Pengarang"] = "";
					$_SESSION[$action.".tpt"]["message"] = "Author name is unacceptable";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
				}
				
				if(Statics::validateBookPublisher($_POST['Penerbit']) == 0){
						$_SESSION[$action.".tpt"] = $_POST;
						$_SESSION[$action.".tpt"]["Penerbit"] = "";
						$_SESSION[$action.".tpt"]["message"] = "Book publisher you specified is unacceptable";
						PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
				}
				
				
				if(Statics::validateBookYear($_POST['Th_Terbit']) == 0){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = "Published year must be in form YYYY";
					$_SESSION[$action.".tpt"]["Th_Terbit"] = "";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);
				} 
				
				if(!isset($_POST['Kategori'])){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = "Specify the category of the book";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
				}
					
				$tagValidity = Statics::validateBookTags($_POST['Tags']);
				if($tagValidity["valid"] == false){
						$_SESSION[$action.".tpt"] = $_POST;
						$_SESSION[$action.".tpt"]["Tags"] = "";
						$_SESSION[$action.".tpt"]["message"] = $tagValidity["message"];
						PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
				}
			
								
				if(Statics::validateBookReview($_POST['Resensi']) == 0){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = "Book review should have 10-500 characters";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
				}
				
				$pictureValidity = Statics::validatePhoto($_FILES['picture']);
				if($pictureValidity["valid"] == false){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = $pictureValidity["message"];
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);
				}
				
				
				$temp;
				preg_match_all("/^.*\.([a-zA-Z0-9]{1,})/i", $_FILES['picture']['name'], $temp);
				$extension = $temp[1][0];
				$randomChars = PageController::getRandomChars(20);			
				$uploadFile = $uploadDir.$randomChars.".".$extension;
				//var_dump($uploadFile);exit(0);
				
				$data = array();
				$data['Judul'] = $_POST['Judul'];
				if(preg_replace("|\s+|", "", $_POST['Edisi']) != "")
					$data['Edisi'] = $_POST['Edisi'];
				$data['Pengarang'] = $_POST['Pengarang'];
				$data['Penerbit'] = $_POST['Penerbit'];
				$data['Kategori'] = $_POST['Kategori'];
				$data['Tags'] = explode(",",$_POST['Tags']);	
				$data['Resensi'] = $_POST['Resensi'];
				$data['Th_Terbit'] = $_POST['Th_Terbit'];
				
				$p = PageController::getSessionData();				
				$data['ID'] = $p['ID'];
				$data['URLFoto'] = "uploads/".$randomChars.".".$extension;	
				
				//var_dump($data);exit(0);
				
				if (!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)){
					//var_dump($_FILES['picture']);exit(0);
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = "Photo cannot be moved. Check your file.";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);
				}
							
				$data['URLFoto'] = "uploads/".$randomChars.".".$extension;	
				//var_dump($data);exit(0);
				
				PageController::dispatch($action, $data);
				
			}else{
				PageController::dispatch($action);
			}
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't logged in yet."));
		}
	}else if($action == "hapus-buku"){
		if(PageController::getSessionData()){
			//var_dump($_POST); exit(0);
			$data = $_POST['id'];
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't logged in yet."));
		}
	}else if($action == "prareset-password"){
		if(PageController::getSessionData()) 
			PageController::load("halaman-utama.tpt", null);
		if(isset($_POST['Email'])){
			$data = array("Email"=>trim($_POST['Email']));			
			PageController::dispatch($action, $data);
		}else
			PageController::dispatch($action, null);
	}else if($action == "validasi-email"){
		if(PageController::getSessionData()) 
			PageController::load("halaman-utama.tpt", null);
		if(isset($_GET['hash'])){
			$data = array("Hash"=>$_GET['hash']);
			PageController::dispatch($action, $data);
		}else
			PageController::load("halaman-utama.tpt", null);
	}else if($action == "reset-password"){
		if(PageController::getSessionData()) 
			PageController::load("halaman-utama.tpt", null);
		if(isset($_POST['Password']) && isset($_SESSION['userId'])){
			if(Statics::validatePassword($_POST['Password']) == 0){
				$_SESSION[$action.".tpt"]["message"] = "Password must contain alphanumeric, -, _, dot, and having 6 - 15 characters of length";
				PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
			}
			
			if($_POST['Password'] !== $_POST['Password2']){
				$_SESSION[$action.".tpt"]["message"] = "Passwords are mismatch.";
				PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
			}
						
			$data = array("Password"=>md5($_POST['Password']), "ID"=>$_SESSION['userId']);
		
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You're not authorized"));
		}		
	}else if($action == "ubah-profil"){
		unset($_SESSION["ubah-profil.tpt"]);
		if(PageController::getSessionData()){	
			if(isset($_POST['Password']) || isset($_POST['Nama']) || isset($_POST['Email']) || isset($_POST['Lokasi']) || isset($_POST['Deskripsi'])){
				//var_dump($_FILES);exit(0);
				if($_POST['Password'] == "sd9fhsd82398sda19823asdfgf" && $_POST['Password2'] == "sd9fhsd82398sda19823asdfgf")
					unset($_POST['Password']);
				
				$data = array();	
				
				if(Statics::validateName($_POST['Nama']) == 0){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = "Name must contain only alphabets, whitespaces and having 3 - 40 characters of length";
					$_SESSION[$action.".tpt"]["Nama"] = "";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);
				} 
				$data['Nama'] = $_POST['Nama'];
				
					
				if(Statics::validateEmail($_POST['Email']) == 0){
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = "Email format is unacceptable.";
					$_SESSION[$action.".tpt"]["Email"] = "";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);
				}
				$data['Email'] = $_POST['Email'];
				
				
				//password handling
				if(isset($_POST['Password'])){
					if(Statics::validatePassword($_POST['Password']) == 0){
						$_SESSION[$action.".tpt"] = $_POST;
						$_SESSION[$action.".tpt"]["Password"] = "";
						$_SESSION[$action.".tpt"]["Password2"] = "";
						$_SESSION[$action.".tpt"]["message"] = "Password must contain alphanumeric, spaces, symbols, and having 6 - 15 characters of length";
						PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
					}
					
					if($_POST['Password'] !== $_POST['Password2']){
						$_SESSION[$action.".tpt"] = $_POST;
						$_SESSION[$action.".tpt"]["Password"] = "";
						$_SESSION[$action.".tpt"]["Password2"] = "";
						$_SESSION[$action.".tpt"]["message"] = "Passwords you typed are mismatch.";
						PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
					}					
					$data['Password'] = md5($_POST['Password']);
				}
								
				$valid = Statics::validatePhoto($_FILES['picture']);  //ngevalidasi data image
				if(!$valid['valid'] && $_FILES['picture']['error'] != UPLOAD_ERR_NO_FILE){//kalo nggak valid
					$_SESSION[$action.".tpt"] = $_POST;
					$_SESSION[$action.".tpt"]["message"] = $valid['message'];
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
				}else{
					$temp;
					preg_match_all("/^.*\.([a-zA-Z0-9]{1,})/i", $_FILES['picture']['name'], $temp);
					$extension = $temp[1][0];
					$randomChars = PageController::getRandomChars(20);			
					$uploadFile = $uploadDir.$randomChars.".".$extension;
					if($_FILES['picture']['error'] == UPLOAD_ERR_NO_FILE);
					else{
						if(!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)){ //kalo ada error waktu mindahkan dari folder temporary ke sebenarnya
							//var_dump($_FILES['picture']);exit(0);
							$_SESSION[$action.".tpt"] = $_POST;
							$_SESSION[$action.".tpt"]["message"] = "Photo cannot be moved.";
							PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);
						}
						$data['URLFoto'] = "uploads/".$randomChars.".".$extension;	
					}	
					
					if(strlen($_POST['Deskripsi']) > 250){
						$_SESSION[$action.".tpt"] = $_POST;
						$_SESSION[$action.".tpt"]["message"] = "Your description must not be over 250 characters.";
						PageController::load($action.".tpt", $_SESSION[$action.".tpt"]);	
					}				
					$data['Deskripsi'] = $_POST['Deskripsi'];
													
					$p = PageController::getSessionData();
					$data['ID'] = $p['ID'];				
					$data['Lokasi'] = (int)$_POST['Lokasi'];
					
					PageController::dispatch($action, $data);
				}
			}else{
				PageController::dispatch($action);
			}
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't logged in yet."));
		}
	}else if($action == "info-buku"){
		$bookId = isset($_GET['id'])?$_GET['id']:0;
		PageController::dispatch($action, array("buku.IDBuku"=>$bookId));
	}else if($action == "ubah-info-buku"){
		if(PageController::getSessionData()){		
			if(isset($_POST['Judul']) || isset($_POST['Edisi']) || isset($_POST['Pengarang']) || isset($_POST['Th_Terbit']) || isset($_POST['Kategori'])){	
				$idBuku = $_POST['id'];
				$data = array();
				
				if(Statics::validateBookTitle($_POST['Judul']) == 0){
					$_SESSION[$action.".tpt"][$idBuku] = $_POST;
					$_SESSION[$action.".tpt"][$idBuku]["message"] = "Book title should have 2-40 non-whitespace characters.";
					$_SESSION[$action.".tpt"][$idBuku]["Judul"] = "";
					
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));
				} 			
				
				if(Statics::validateBookEdition($_POST['Edisi']) == 0){
					$_SESSION[$action.".tpt"][$idBuku] = $_POST;
					$_SESSION[$action.".tpt"][$idBuku]["message"] = "Book edition must either empty or integer.";
					$_SESSION[$action.".tpt"][$idBuku]["Edisi"] = "";
					
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));
				} 
				
				
				if(Statics::validateName($_POST['Pengarang']) == 0){
					$_SESSION[$action.".tpt"][$idBuku] = $_POST;
					$_SESSION[$action.".tpt"][$idBuku]["Pengarang"] = "";
					
					$_SESSION[$action.".tpt"][$idBuku]["message"] = "Author name is unacceptable";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));	
				}
				
				if(Statics::validateBookPublisher($_POST['Penerbit']) == 0){
					$_SESSION[$action.".tpt"][$idBuku] = $_POST;
					$_SESSION[$action.".tpt"][$idBuku]["Penerbit"] = "";
					
					$_SESSION[$action.".tpt"][$idBuku]["message"] = "Book publisher you specified is unacceptable";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));	
				}
				
				
				if(Statics::validateBookYear($_POST['Th_Terbit']) == 0){
					$_SESSION[$action.".tpt"][$idBuku] = $_POST;
					$_SESSION[$action.".tpt"][$idBuku]["message"] = "Published year must be in form YYYY";
					$_SESSION[$action.".tpt"][$idBuku]["Th_Terbit"] = "";
					
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));
				} 
				
				if(!isset($_POST['Kategori'])){
					$_SESSION[$action.".tpt"][$idBuku] = $_POST;
					
					$_SESSION[$action.".tpt"][$idBuku]["message"] = "Specify the category of the book";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));	
				}
					
				$tagValidity = Statics::validateBookTags($_POST['Tags']);
				if($tagValidity["valid"] == false){
						$_SESSION[$action.".tpt"][$idBuku] = $_POST;
						$_SESSION[$action.".tpt"][$idBuku]["Tags"] = "";
					
						$_SESSION[$action.".tpt"][$idBuku]["message"] = $tagValidity["message"];
						PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));	
				}
			
								
				if(Statics::validateBookReview($_POST['Resensi']) == 0){
					$_SESSION[$action.".tpt"][$idBuku] = $_POST;
					
					$_SESSION[$action.".tpt"][$idBuku]["message"] = "Book review should have 10-500 characters";
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));	
				}
				
				$valid = Statics::validatePhoto($_FILES['picture']);  //ngevalidasi data image
				if(!$valid['valid'] && $_FILES['picture']['error'] != UPLOAD_ERR_NO_FILE){//kalo nggak valid
					$_SESSION[$action.".tpt"][$idBuku] = $_POST;
					
					$_SESSION[$action.".tpt"][$idBuku]["message"] = $valid['message'];
					PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));	
				}else{
					if($_FILES['picture']['error'] == UPLOAD_ERR_NO_FILE);
					else{						
						$temp;
						preg_match_all("/^.*\.([a-zA-Z0-9]{1,})/i", $_FILES['picture']['name'], $temp);
						$extension = $temp[1][0];
						$randomChars = PageController::getRandomChars(20);			
						$uploadFile = $uploadDir.$randomChars.".".$extension;
						if(!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)){ //kalo ada error waktu mindahkan dari folder temporary ke sebenarnya
							$_SESSION[$action.".tpt"][$idBuku] = $_POST;
							$_SESSION[$action.".tpt"][$idBuku]["message"] = "Photo cannot be moved. Check your file.";
							
							PageController::load($action.".tpt", $_SESSION[$action.".tpt"][$idBuku], array("id"=>$idBuku));
						}
						$data['URLFoto'] = "uploads/".$randomChars.".".$extension;	
					}
				}					
									
				$data['Judul'] = $_POST['Judul'];
				if(isset($_POST['Edisi']) && trim($_POST['Edisi']) !="")
					$data['Edisi'] = $_POST['Edisi'];
				$data['Pengarang'] = $_POST['Pengarang'];
				$data['Penerbit'] = $_POST['Penerbit'];
				$data['Kategori'] = $_POST['Kategori'];
				$data['Tags'] = explode(",",$_POST['Tags']);	
				$data['Resensi'] = $_POST['Resensi'];
				$data['Th_Terbit'] = $_POST['Th_Terbit'];
				$data['Status'] = isset($_POST['Status'])?$_POST['Status']:0;
				$data['buku.IDBuku'] = $idBuku;
				$data['IDResensi'] = $_POST['IDResensi'];
				
				PageController::dispatch($action, $data);
				
			}else{
				PageController::dispatch($action, array("buku.IDBuku"=>$_GET['id']));
			}
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't logged in yet."));
		}
	}else if($action == "lihat-pesan"){
		//var_dump($_GET['id']); exit(0);
		if(PageController::getSessionData()){
			PageController::dispatch($action, $_GET['id']);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized."));
		}
	}else if($action == "resensi"){
		if(PageController::getSessionData()){
			if(Statics::validateBookReview($_POST['Isi_Resensi']) == 0){	
				$_SESSION["PageController"]["message"] = "Your review should contain 10-500 characters.";			
				PageController::dispatch("info-buku", array("buku.IDBuku"=>$_POST['IDBuku']));
			} 	
			PageController::dispatch($action, array("Isi_Resensi"=>$_POST['Isi_Resensi'], "IDBuku"=>$_POST['IDBuku']));
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized."));
		}
	}else if($action == "pencarian"){
		$keyword = preg_replace("|\s+|"," ", trim($_GET['keywords']));
		if(strlen($keyword) <2 || strlen($keyword) >=30)
			PageController::load("hasil-pencarian.tpt", array("keyword"=>$_GET['keywords'], "message"=>"Keywords should have 2-30 of non-whitespace characters"));
		$data = array("keywords"=>$keyword, "page"=>isset($_GET["page"])?$_GET["page"]:0);
		PageController::dispatch($action, $data);
	}else if($action == "rate-buku"){
		$data = array("Rating"=>$_GET["rating"], "IDBuku"=>$_GET["id"]);
		PageController::dispatch($action, $data);
	}else if($action == "rate-pengguna"){
		$data = array("Rating"=>$_GET["rating"], "IDPenerima"=>$_GET["id"], "IDPemberi"=>$_SESSION["SessionData"]["ID"]);
		PageController::dispatch($action, $data);
	}else if($action == "lihat-daftar-pengguna"){
		PageController::dispatch($action, true);
	}else if($action == "lihat-daftar-buku"){
		PageController::dispatch($action, true);
	}else if($action == "ubah-sistem-mode"){
		$p = PageController::getSessionData();
		if($p && $p['isAdmin'] == 1){
			$mode = isset($_GET['mode'])?$_GET['mode']:0;
			PageController::dispatch($action, array("mode"=>$mode));
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized."));
		}
	}else if($action == "validasi-admin"){
		$p = PageController::getSessionData();
		if($p && $p['isAdmin'] == 1 && isset($_SESSION['Mode'])){
			if($_POST['password'] == $_POST['password2'])
				PageController::dispatch($action, array("Password"=>md5($_POST['password'])));
			else	
				PageController::load("validasi-admin.tpt", array("message"=>"Passwords are mismatch."));
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized."));
		}
	}else if($action == "konfirmasi-admin"){
		$p = PageController::getSessionData();
		if($p && $p['isAdmin'] == 1 && isset($_SESSION['AdminValidated']) && $_SESSION['AdminValidated']){
			PageController::dispatch('ubah-sistem-mode', true);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized."));
		}
	}else if($action == "hapus-pengguna"){
		$sessionData = PageController::getSessionData();
		if($sessionData && $sessionData['isAdmin']==1){
			if($_POST['token'] != $_SESSION['SessionData']['token']){
				PageController::load("halaman-utama.tpt", array("message"=>"Invalid Token. Make sure you have been authorized."));
			}
			unset($_SESSION['SessionData']['token']);
			//var_dump($_POST); exit(0);
			$data = $_POST['idDelete'];
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized"));
		}
	}else if($action == "keluhan"){
		$sessionData = PageController::getSessionData();
		if($sessionData && $_POST){
			$type = (int)$_POST['Type'];
			$subject = $_POST['Subject'];
			$content = preg_replace("/[^\S\r\n]+/"," ", trim($_POST['Isi_Keluhan']));	
			
			$id = (isset($_POST['IDPenerima']) && trim($_POST['IDPenerima']) != "" && $type == 1)?$_POST['IDPenerima']:NULL;
			
			$temp;
			preg_match_all("/^.*?p=(.*)&(.*)=(.*)/i", $_SERVER['HTTP_REFERER'], $temp);
			$username = isset($temp[3][0])?$temp[3][0]:NULL;
			if(strlen($content) < 5 || strlen($content) > 500){
				if(!get_magic_quotes_gpc()){
					$subject = addslashes($_POST['Subject']);
					$content = addslashes(preg_replace("/\s+/"," ", trim($_POST['Isi_Keluhan'])));
				}			
			
				$_SESSION['PageController'] = array("showBox"=>true, 'message' => "Content of complaint must contain 5-500 characters", "Isi_Keluhan"=>$content, 'Subject'=>$subject, "Type"=>$type);
				if($id){
					$_SESSION['PageController']['IDPenerima'] = $id;
				}
				
				if($username)
					PageController::dispatch("lihat-profil", array("username"=>$username));
				else
					PageController::dispatch("lihat-profil", true);
			}
			
			
			if(!get_magic_quotes_gpc()){
				$subject = addslashes($_POST['Subject']);
				$content = addslashes(preg_replace("/\s+/"," ", trim($_POST['Isi_Keluhan'])));
			}
			
			$data = array("Isi_Keluhan"=>$content, 'Subject'=>$subject, "Type"=>$type);
			if($id){
				$_SESSION['PageController']['IDPenerima'] = $id;
			}
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized"));
		}
	}else if($action == "lihat-daftar-keluhan"){
		$sessionData = PageController::getSessionData();
		if($sessionData && $sessionData['isAdmin']==1){
			PageController::dispatch("lihat-daftar-keluhan", true);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized"));
		}
	}else if($action == "blokir-pengguna"){
		$sessionData = PageController::getSessionData();
		if($sessionData && $sessionData['isAdmin']==1){
			//var_dump($_POST);
			$data = $_POST;
			unset($data['dispatch']);
			unset($_POST);
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized"));
		}
	}else if($action == "lihat-keluhan"){
		$sessionData = PageController::getSessionData();
		if($sessionData && $sessionData['isAdmin']==1 && $_GET){
			$data = array('IDKeluhan'=>$_GET['id']);
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized"));
		}
	}else if($action == "lihat-feed"){
		if($_GET){
			$data = array('id_feed'=>$_GET['id']);
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt");
		}
	}else if($action == "unfollow-feed"){
		$sessionData = PageController::getSessionData();
		if($sessionData && $_GET){
			$data = array('id_user'=>$sessionData['ID'], 'id_feed'=>$_GET['id']);
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt");
		}
	}else if($action == "solve-keluhan"){
		$sessionData = PageController::getSessionData();
		if($sessionData && $sessionData['isAdmin']==1 && $_GET){
			$data = array('IDKeluhan'=>$_GET['id']);
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized"));
		}
	}else if($action == "hapus-keluhan"){
		$sessionData = PageController::getSessionData();
		if($sessionData && $sessionData['isAdmin']==1 && $_GET){
			$data = array('IDKeluhan'=>$_GET['id']);
			PageController::dispatch($action, $data);
		}else{
			PageController::load("halaman-utama.tpt", array("message"=>"You aren't authorized"));
		}
	}else{
		//var_dump($action);
		PageController::load("halaman-utama.tpt", array("message"=>"Fiture ($action) has not been implemented"));
	}
?>