<?php
	//import class DAM
	include_once("dam.php");
	//definisikan class Statics
	class Statics{
		private $db;		
		public function __construct(){
			$this->db = new DAM();
		}
		
		//Mendapatkan semua kategori buku
		public function getAllCategories(){
			$temp = $this->db->retrieve("kategori", true);
			$result = array();
			while($line = $temp->fetch_assoc())
				$result[] = $line;
			return $result;
		}
		//Mendapatkan semua lokasi
		public function getAllLocation(){
			$temp = $this->db->retrieve("lokasi", true);
			$result = array();
			while($line = $temp->fetch_assoc())
				$result[] = $line;
			return $result;
		}
		//untuk sidebar
		public static function sidebar($data = null){
			$nama = $_SESSION['SessionData']['Nama'];
			$photoURL = $_SESSION['SessionData']['URLFoto'];			
			echo <<<END
				<section >
					<h3>$nama</h3>
					<div style="padding: 10px; border: 1px solid #eee">
					  <p><a href="#"><img src="$photoURL" width="150px" height="180px" alt="" /></a> </p>
					  <section >
						<div style="padding: 10px; border: 1px solid #eee">
						  <ul class="link-list">
							<li> <img style="vertical-align:middle;" src="images/picture.png" alt="" width="30" height="30"/>  <a href="controller.php?dispatch=ubah-gambar">Change Profile Picture</a></li>
							<li> <img style="vertical-align:middle;" src="images/edit-profil.png" alt="" width="30" height="30"/> <a href="controller.php?dispatch=ubah-profil">Update My Profile</a></li>
						  </ul>
						</div>
					  </section>
					  <section class="last">
						<h3>Messaging</h3>
						<div style="padding: 10px; border: 1px solid #eee">
						  <ul class="link-list">
							<li><img style="vertical-align:middle;" src="images/inbox-pict.jpg" alt="" width="30" height="30"/> <a href="controller.php?dispatch=pesan-masuk">Inbox <span id="totalmsg"></span></a></li>
							<li><img style="vertical-align:middle;" src="images/create.jpg" alt="" width="30" height="30"/><a href="controller.php?dispatch=kirim-pesan">Create New Message</a></li>
						  </ul>
						</div>
						</section>
					<section class="last">
						<h3>Complaint</h3>
						<div style="padding: 10px; border: 1px solid #eee">
						  <ul class="link-list">
							<li><img style="vertical-align:middle;" src="images/reports2.png" alt="" width="30" height="30"/><a href="#" onclick="showComplaintBox(); return false">Give Complaint</a></li>
END;
 
if ($data != null)
echo <<<END
<li><img style="vertical-align:middle;" src="images/reports.jpg" alt="" width="30" height="30"/><a href="#" onclick="\$(\$('#Type option')[1]).attr('selected', true); \$('#Subject').val('${data['Username']}'); showComplaintBox(); return false">Report This User</a></li>
END;

echo <<<END
						  </ul>
						</div>
						</section>
					  <p>&nbsp;</p>
					</div>
				</section>
END;
		}
		//method untuk menampilkan footer setiap halaman
		public static function footer(){
			echo <<<END
			<div id="footer-wrapper">
				<footer class="5grid-layout" id="site-footer">
					<div class="row">
						<div class="3u">
							<section class="first">
								<h2>Developer</h2>
								<ul class="link-list">
									<li><img style="vertical-align:middle;" src="images/pic4.jpg" alt="" width="20" height="20"/>&nbsp;&nbsp;&nbsp;<a href="controller.php?dispatch=lihat-profil&user=ahmadahfa">Ahmad Fanani</a></li>
									<li><img style="vertical-align:middle;" src="images/pic1.jpg" alt="" width="20" height="20"/>&nbsp;&nbsp;&nbsp;<a href="controller.php?dispatch=lihat-profil&user=firliasandyta">Firlia Sandyta</a></li>
									<li><img style="vertical-align:middle;" src="images/pic2.jpg" alt="" width="20" height="20"/>&nbsp;&nbsp;&nbsp;<a href="controller.php?dispatch=lihat-profil&user=irfan92">Muhammad Irfan Nasution</a></li>
									<li><img style="vertical-align:middle;" src="images/pic5.jpg" alt="" width="20" height="20"/>&nbsp;&nbsp;&nbsp;<a href="controller.php?dispatch=lihat-profil&user=nempyong">Vemmy Yusiana</a></li>
								</ul>
							</section>
						</div>
						<div class="3u">
							<section>
								<h2>Links</h2>
								<ul class="link-list">
									<li><a href="http://twitter.com/Buku_Kuliah">Twitter</a>
									<li><a href="http://www.facebook.com/pages/Buku-Kuliahcom/550712361617304?fref=ts">Facebook</a>
									<li><a href="#">About</a>
								</ul>
							</section>
						</div>
						<div class="3u">
							<section>
								<h2>Helps</h2>
								<ul class="link-list">
									<li><a href="#">Tutorials</a>
									<li><a href="#">F.A.Q.</a>
								</ul>
							</section>
						</div>
						<div class="3u">
							<section class="last">
								<h2>Contact Us</h2>
								<ul class="link-list">
									<li><a href="mailto: support@buku-kuliah.com">support@buku-kuliah.com</a>
									<li>(+62) 8576 1234 123</li>
									<li>Depok, West Java</li>
									<li>Indonesia</li>
								</ul>
							</section>
						</div>
					</div>
					<div class="row">
						<div class="12u">
							<div class="divider"></div>
						</div>
					</div>
					<div class="row">
						<div class="12u">
							<div id="copyright">
								&copy; 2013 Buku-Kuliah.com. <br />C4 - Proyek Perangkat Lunak 2012/2013
							</div>
						</div>
					</div>
				</footer>
			</div>
END;
			
		}
		//Header ada beberapa tipe
		public static function header($current = 0){
		$isAdmin = isset($_SESSION['SessionData']) &&
			($_SESSION['SessionData']['isAdmin'] == 1 || $_SESSION['SessionData']['isAdmin'] == 2);
		$isUser = isset($_SESSION['SessionData']) && $_SESSION['SessionData']['isAdmin'] == 0;
		$currentItem = array(0=>"",1=>"",2=>"");
		$currentItem[$current] = "class='current_page_item'";
		
		echo <<<END
		<div id="header-wrapper">
				<header class="5grid-layout" id="site-header">
					<div class="row">
						<div class="12u">
							<div id="logo">
								<img style="z-index: 1000000;" src="images/logo.png" alt="logo" width="150" height="150" />
								<h1 style="margin-left:30px; color:#fff; display: inline;">Buku-Kuliah.com</h1>
							</div>
							<nav class="mobileUI-site-nav" id="site-nav">
								<ul>
									<li ${currentItem[0]}><a href="index.php">Homepage</a></li>
END;
								if($isAdmin){ 
									echo <<<END
											<li ${currentItem[1]}><a href="view.php?p=halaman-admin.tpt">Maintenance</a></li>											
											<li ${currentItem[2]}><a href="controller.php?dispatch=keluar">Sign Out</a></li>
END;
								}else if($isUser){
									echo <<<END
											<li ${currentItem[1]}><a href="controller.php?dispatch=lihat-profil">Profile</a></li>								
											<li ${currentItem[2]}><a href="controller.php?dispatch=keluar">Sign Out</a></li>
END;
								}
		echo <<<END
								</ul>
							</nav>
							<div class="search">
								<form action="controller.php" method="get">
									<input type="hidden" name="dispatch" value="pencarian" />
									<input style="background: #fff;" type="text" id="search" name="keywords" placeholder="Enter keywords to search" required>
									<input type="submit" value="Search" id="submit" class="button">
								</form>
							</div>
						</div>
					</div>
				</header>
			</div>
END;
		}
		//validasi email
		public static function validateEmail($email){
			return filter_var(trim($email), FILTER_VALIDATE_EMAIL)?1:0;
		}
		//validasi username
		public static function validateUsername($username){
			return preg_match("|^[A-Za-z0-9][A-Za-z0-9_-]{4,13}[A-Za-z0-9]$|i", $username);
		}
		//validasi nama
		public static function validateName($name){
			$name = preg_replace("|\s+|"," ", trim($name));
			$forbidden1 = "/([\^<\"\'@\/\{\}\(\)\*\$%\?=>:\|;#0-9]+)|([\s]{2,})|([.]{2,})|([,]{2,})/i";
			$forbidden2 = array("admin", "moderator", "administrator", "mod", "adm.", "support");
			if (preg_match($forbidden1, $name) || in_array($name, $forbidden2)) {
				return 0;
			}
			return (strlen($name)>=3&&strlen($name)<=50)?1:0;
		}
		//validasi password
		public static function validatePassword($password){
			return preg_match("|^[A-Za-z0-9!@#$%^&*() ]{6,15}$|i", $password);
		}
		//validasi review buku
		public static function validateBookReview($resensi){
			$resensi = preg_replace("|\s+|"," ", trim($resensi));
			return preg_match("|^.{10,500}$|i", $resensi);
		}
		//validasi judul buku
		public static function validateBookTitle($data){
			$data = preg_replace("|\s+|"," ", trim($data));
			return preg_match("|^.{2,40}$|i", $data);
		}
		//validasi edisi buku
		public static function validateBookEdition($data){
			$data = preg_replace("|\s+|"," ", trim($data));
			return preg_match("|^[0-9]{0,2}$|i", $data);
		}
		//validasi penerbit buku
		public static function validateBookPublisher($data){
			$data = preg_replace("|\s+|"," ", trim($data));
			$forbidden1 = "/[\^<@\/\{\}\(\)\$%\?=]+/i";
			if(preg_match($forbidden1, $data)){
				return 0;
			}
			return preg_match("|^.{3,40}$|i", $data);
		}
		//validasi tahun terbit
		public static function validateBookYear($data){
			$data = preg_replace("|\s+|"," ", trim($data));
			return preg_match("|^[0-9]{4}$|i", $data);
		}
		//validasi tag buku
		public static function validateBookTags($data){
			$data = preg_replace("|\s+|","", trim($data));
			if(strlen($data)<3 || strlen($data)>36)
				return array("valid"=>false,"message"=>"Tag should have 3-12 alphanumeric.");
				
			$temp = explode(",", $data);
			if(count($temp)<1 || count($temp)>3){
				return array("valid"=>false,"message"=>"Please, specify 1-3 tag(s)");
			}
			
			if(count(array_unique($temp)) < count($temp)){
				return array("valid"=>false,"message"=>"Tags should have no duplicates");
			}
			
			foreach($temp as $tag){
				if(strlen($tag)<3 || strlen($tag)>12)
					return array("valid"=>false,"message"=>"Tag should have 3-12 alphanumeric.");
						
				if(preg_match("|^[^A-Za-z]*$|i", $tag) == 1)
					return array("valid"=>false,"message"=>"Tag should contains at least one alphabet.");
			}
			
				
			if(preg_match("|^[,A-Za-z0-9]+$|i", $data) == 0)
				return array("valid"=>false,"message"=>"Tag should comprise only alphanumeric.");
			return array("valid"=>true);
		}
		//Validasi file foto yang diupload ke sistem
		public static function validatePhoto($photo){
			if($photo['error'] == UPLOAD_ERR_INI_SIZE){
				return array("valid"=>false, "message"=>"The uploaded file exceeds the upload_max_filesize directive in php.ini.");
			}
			
			if($photo['error'] == UPLOAD_ERR_FORM_SIZE){
				return array("valid"=>false, "message"=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.");
			}
			
			if($photo['error'] == UPLOAD_ERR_PARTIAL){
				return array("valid"=>false, "message"=>"The uploaded file was only partially uploaded.");
			}
			
			if($photo['error'] == UPLOAD_ERR_NO_FILE ){
				return array("valid"=>false, "message"=>"No file was uploaded.");
			}
			
			if($photo['error'] == UPLOAD_ERR_NO_TMP_DIR  ){
				return array("valid"=>false, "message"=>"Missing a temporary folder");
			}
			
			if($photo['error'] == UPLOAD_ERR_CANT_WRITE   ){
				return array("valid"=>false, "message"=>"Failed to write file to disk.");
			}
			
			if($photo['error'] == UPLOAD_ERR_EXTENSION   ){
				return array("valid"=>false, "message"=>"A PHP extension stopped the file upload");
			}
			
			if($photo['type'] != "image/gif" && $photo['type'] != "image/png" && $photo['type'] != "image/jpeg" && $photo['type'] != "image/bmp"){
				return array("valid"=>false, "message"=>"Extension of your photo must be either .png, .jpg, .gif, or .bmp");
			}
			
			
			if($photo['size'] > 100000){
				return array("valid"=>false, "message"=>"Photo capacity must not be over 100kb");
			}
			return array("valid"=>true);
		}
		//method untuk meng-unescape suatu input yang mengandung karakter khusus
		public static function sanitize($str){
			return preg_replace("/(<br\/>){2,}/","<br/><br/>",strip_tags(stripslashes(stripslashes(preg_replace("|\\\\r\\\\n|i","<br/>",$str))), '<br>'));
		}
		//fungsi Smilley
		function Smilify($subject)
		{
			$smilies = array(
				':|'  => 'mellow',
				':-|' => 'mellow',
				':-o' => 'ohmy',
				':-O' => 'ohmy',
				':o'  => 'ohmy',
				':O'  => 'ohmy',
				';)'  => 'wink',
				';-)' => 'wink',
				':p'  => 'tongue',
				':-p' => 'tongue',
				':P'  => 'tongue',
				':-P' => 'tongue',
				':D'  => 'biggrin',
				':-D' => 'biggrin',
				'8)'  => 'cool',
				'8-)' => 'cool',
				':)'  => 'smile',
				':-)' => 'smile',
				':('  => 'sad',
				':-(' => 'sad',
			);
			$sizes = array(
				'biggrin' => 18,
				'cool' => 20,
				'haha' => 20,
				'mellow' => 20,
				'ohmy' => 20,
				'sad' => 20,
				'smile' => 18,
				'tongue' => 20,
				'wink' => 20,
			);

    $replace = array();
    foreach ($smilies as $smiley => $imgName)
    {
        $size = $sizes[$imgName];
        array_push($replace, '<img src="images/smiley/'.$imgName.'.gif" alt="'.$smiley.'" width="'.$size.'" height="'.$size.'" />');
    }
    return str_replace(array_keys($smilies), $replace, $subject);
}
	}
?>