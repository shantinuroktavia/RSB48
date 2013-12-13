<?php
session_start();

$aResponse['error'] = false;
$aResponse['message'] = '';

// ONLY FOR THE DEMO, YOU CAN REMOVE THIS VAR
	$aResponse['server'] = ''; 
// END ONLY FOR DEMO
	
	
if(isset($_POST['action'])){
	if(htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'rating'){
		$id = intval($_POST['idBox']);
		$rate = floatval($_POST['rate']);
		$success = false;
		
		if($id >= 0){ //ngirim rating buku
			if(isset($_SESSION['SessionData'])){
				include_once("../BukuManager.php");
				$pm = new BukuManager();
				$data = array('IDBuku'=>$id, 'Rating'=>$rate); 
				$success = ($pm->rate($data))?true:false;
			}			
			// json datas send to the js file
			
		}else{ //rating pengguna
			if(isset($_SESSION['SessionData'])){
				include_once("../PenggunaManager.php");
				$pm = new PenggunaManager();
				$data = array('IDPenerima'=>(-1*$id), 'Rating'=>$rate, "IDPemberi"=>$_SESSION["SessionData"]["ID"]); 
				$success = ($pm->rate($data))?true:false;
			}
		}
		
		if($success){
				$aResponse['message'] = 'Your rate has been successfuly recorded. Thanks for your rate :)';			
				// ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
					$aResponse['server'] = '<strong>Success answer :</strong> Success : Your rate has been recorded. Thanks for your rate :)<br />';
					$aResponse['server'] .= '<strong>Rate received :</strong> '.$rate.'<br />';
					$aResponse['server'] .= '<strong>ID to update :</strong> '.$id;
				// END ONLY FOR DEMO
				
				echo json_encode($aResponse);
			}else{
				$aResponse['error'] = true;
				$aResponse['message'] = 'An error occured during the request. Please retry';
				
				// ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
					$aResponse['server'] = '<strong>ERROR :</strong> Your error if the request crash !';
				// END ONLY FOR DEMO
				
				
				echo json_encode($aResponse);
			}
	}
	else
	{
		$aResponse['error'] = true;
		$aResponse['message'] = '"action" post data not equal to \'rating\'';
		
		// ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
			$aResponse['server'] = '<strong>ERROR :</strong> "action" post data not equal to \'rating\'';
		// END ONLY FOR DEMO
			
		
		echo json_encode($aResponse);
	}
}
else{
	$aResponse['error'] = true;
	$aResponse['message'] = '$_POST[\'action\'] not found';
	
	// ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
		$aResponse['server'] = '<strong>ERROR :</strong> $_POST[\'action\'] not found';
	// END ONLY FOR DEMO
	
	echo json_encode($aResponse);
}