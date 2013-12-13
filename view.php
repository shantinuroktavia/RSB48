<?php
//view.php merupakan class View yang menangani  untuk menampilkan.
	session_start();
	define("TEMPLATE_PATH", "templates/");
	include_once("SistemManager.php");
	include_once("PageController.php");
	
	$pm = new SistemManager();
	$_SESSION['SystemMode'] = $pm->getSystemMode();
	if($_SESSION['SystemMode'] == 1 && ((!isset($_SESSION['SessionData'])) || (isset($_SESSION['SessionData']) && ($_SESSION['SessionData']['isAdmin'] != 1)))){
		require("./".TEMPLATE_PATH.'under-construction.tpt');
		exit(0);
	}
	// cek apakah account diblock atau dihapus
	PageController::getSessionData();   

	//Definisi class view
	class Viewer{
		//method display template yang akan digunakan sebagai view yang ingin ditampilkan
		public static function display($template){
			if(preg_match("|^[a-zA-Z\-\.]+$|",$template) == 0 || $template == "." || $template == ".."){
				$_SESSION['halaman-utama.tpt']['message'] = "RFI is not cool, bro.";
				require("./".TEMPLATE_PATH.'halaman-utama.tpt');
				return;
			}
			//validasi ketika template yang diview tidak ada.
			if(!file_exists("./".TEMPLATE_PATH.$template)){
				$_SESSION['halaman-utama.tpt']['message'] = "RFI is not cool, bro.";
				require("./".TEMPLATE_PATH.'halaman-utama.tpt');
				return;
			}
			include("./".TEMPLATE_PATH.$template);
		}
	}	
	
	$page = $_GET['p'];
	Viewer::display($page);
?>