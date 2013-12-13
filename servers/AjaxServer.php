<?php
	include_once("../dam.php");
	include_once("../PenggunaManager.php");
	include_once("../LogManager.php");
	include_once("../FeedManager.php");
	session_start();
	
	
	function sortByTime($a, $b){
	  if( strtotime($a['unformatted_time']) < strtotime($b['unformatted_time']) ) return 1;
	  return -1;
	}
	
	function getRandomChars($n){
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		$str = "";
		for($i=0; $i<20; $i++)
			$str .= substr($chars, rand()%62, 1);
		return $str;
	}
	
	$action = $_REQUEST['action'];
	if($action == "getNewMessages"){
		if(isset($_SESSION['SessionData'])){
			$p = $_SESSION['SessionData'];
			$dam = new DAM();
			$temp = $dam->retrieve("pesan-pengguna", array("IDPenerima"=>$p['ID'], "Status_Pesan"=>0));
			echo json_encode(array("total"=>$temp->num_rows));
			unset($dam);
			unset($temp);
		}
	}else if($action == "postFeed"){
		if(isset($_SESSION['SessionData'])){
			if(strlen($_POST['content']) < 5 || strlen($_POST['content']) > 200){
				echo json_encode(array("ok"=>false, "message"=>"Unqualified post length."));
			}else{				
				$p = $_SESSION['SessionData'];
				$id = $p['ID'];	
				
				// cek apakah user diblock atau didelete
				$pm = new PenggunaManager();
				$userStatus = $pm->getUserStatus(array("ID"=>$id));
				
				if($userStatus['valid']){
					unset($pm); unset($userStatus);
					$dam = new DAM();
					$location_id = ($_POST['location_id'] === '1')?$p['LokasiID']:((int)$_POST['location_id']-1);	
					$content = get_magic_quotes_gpc()?$_POST['content']:addslashes($_POST['content']);
					$data = array('id_user'=>$id, 'isi_feed'=>$content, 'tipe_feed'=>1, 'id_lokasi'=>$location_id);
			
					if($dam->create('feed', $data)){
						echo json_encode(array("ok"=>true, "message"=>"Your question is posted."));
					}else{
						echo json_encode(array("ok"=>false, "message"=>"Unknown error. Please try again."));
					}
					unset($dam);
				}else{
					echo json_encode(array("ok"=>false, "message"=>"Your account is not valid for now.", "refresh"=>true));
				}
			}
		}else{
			echo json_encode(array("ok"=>false, "message"=>"You're not authorized"));
		}
	}else if($action == "postComment"){
		if(isset($_SESSION['SessionData'])){
			if(strlen($_POST['content']) < 1 || strlen($_POST['content']) > 200){
				echo json_encode(array("ok"=>false, "message"=>"Comment should comprise of 1-200 characters"));
			}else{	
				$p = $_SESSION['SessionData'];
				$id = $p['ID'];
				
				// cek apakah user diblock atau didelete
				$pm = new PenggunaManager();
				$userStatus = $pm->getUserStatus(array("ID"=>$id));
				
				if($userStatus['valid']){
					unset($pm); unset($userStatus);
					$dam = new DAM();
					$parent = (int)$_POST['parent'];
					$content = get_magic_quotes_gpc()?$_POST['content']:addslashes($_POST['content']);
					$data = array('id_user'=>$id, 'isi_feed'=>$content, 'tipe_feed'=>2, 'induk_feed'=>$parent);
					if($dam->create('feed', $data)){
						echo json_encode(array("ok"=>true, "message"=>"Your comment is posted."));
						$fm = new FeedManager();
						$ownership = $fm->getOwnership(array('id_feed'=>$parent, 'id_user'=>$id));
						if(!$ownership['owned']){						
							// Memberi notifikasi kesemua yang follow post
							$lm= new LogManager();
							$query = "SELECT `id_user` FROM `follow_feed` WHERE `id_feed`=$parent";
							$temp = $dam->specialQuery($query);
							while($line = $temp->fetch_assoc()){
								$id_user = $line['id_user'];
								if($id != $id_user)
									$lm->createNotif(array('id_user'=>$id_user, 'id_pemberi'=>$id, 'id_obj'=>$parent, 'tipe_notif'=>'follow'));
							}
							$dam->createBeta('follow_feed', array("id_user"=>$id, "id_feed"=>$parent));   // follow post
							
							//memberi notifikasi keowner feed
							$owner = $ownership['owner'];
							$lm->createNotif(array('id_user'=>$owner, 'id_pemberi'=>$id, 'id_obj'=>$parent, 'tipe_notif'=>'feed'));
							
							unset($fm);unset($dam);
						}else{
							// Memberi notifikasi kesemua yang follow post
							$lm= new LogManager();
							$query = "SELECT `id_user` FROM `follow_feed` WHERE `id_feed`=$parent";
							$temp = $dam->specialQuery($query);
							while($line = $temp->fetch_assoc()){
								$id_user = $line['id_user'];
								$lm->createNotif(array('id_user'=>$id_user, 'id_pemberi'=>$id, 'id_obj'=>$parent, 'tipe_notif'=>'follow'));
							}
						}
					}else{
						echo json_encode(array("ok"=>false, "message"=>"Unknown error. Please try again."));
						unset($dam);
					}
				}else{
					echo json_encode(array("ok"=>false, "message"=>"Your account is not valid for now.", "refresh"=>true));
				}
			}
		}else{
			echo json_encode(array("ok"=>false, "message"=>"You're not authorized"));
		}
	}else if($action == "checkNewFeeds"){
		$timestamp = $_POST['timestamp'];
		$time = date('Y-m-d H:i:s', $timestamp);
		$dam = new DAM();		
		$location_id = (int)$_POST['location_id']-1;
		$addition = ($location_id == 0)?"":" AND `id_lokasi`=$location_id";		
		
		$query = "SELECT count(`id_feed`) as count FROM `feed` JOIN `aktor_sistem` ON `feed`.id_user = `aktor_sistem`.`ID` WHERE `waktu_feed` > '$time' AND `tipe_feed` IN ('0', '1') $addition";
		$rs = $dam->query($query);
		
		$data = $rs->fetch_assoc();
		echo json_encode(array("total"=>$data['count']));
	}else if($action == "getNewFeeds"){
		$timestamp = $_POST['timestamp'];
		$time = date('Y-m-d H:i:s', $timestamp);
		$location_id = (int)$_POST['location_id']-1;
		$addition = ($location_id == 0)?"":" AND A.id_lokasi=$location_id";
		$dam = new DAM();	
		$query = <<<END
			SELECT poster_username, poster_name, poster_url, `aktor_sistem`.Username as comm_poster_username, `aktor_sistem`.Nama as comm_poster_name,`aktor_sistem`.URLFoto as comm_poster_url, id_feed, isi_feed, waktu_feed, comm_isi_feed, comm_waktu_feed FROM
			(
			SELECT `aktor_sistem`.Username as poster_username, `aktor_sistem`.Nama as poster_name, `aktor_sistem`.URLFoto as poster_url, id_feed, isi_feed, waktu_feed, comm_id_user, comm_isi_feed, comm_waktu_feed  FROM
			(
			SELECT A.id_user as id_user, A.id_feed as id_feed, A.isi_feed as isi_feed, A.waktu_feed as waktu_feed, B.id_user as comm_id_user, B.isi_feed as comm_isi_feed, B.waktu_feed as comm_waktu_feed FROM `feed` A LEFT JOIN `feed` B ON A.`id_feed` = B.`induk_feed` WHERE A.`waktu_feed` > '$time' AND A.`tipe_feed` IN ('0', '1') $addition ORDER BY A.waktu_feed DESC, B.waktu_feed ASC
			) F JOIN `aktor_sistem` ON F.id_user = `aktor_sistem`.`ID` WHERE 1 
			) G LEFT JOIN `aktor_sistem` ON G.comm_id_user = `aktor_sistem`.`ID` WHERE 1
END;
		$rs = $dam->query($query);
		$data = array();
		while($line = $rs->fetch_assoc()){
			$id = (int)$line['id_feed'];
			if($line['comm_poster_username'] == NULL){ // Non Comment
				$data[$id] = array();
				$data[$id]['poster_username'] = $line['poster_username'];
				$data[$id]['poster_name'] = $line['poster_name'];
				$data[$id]['poster_url'] = $line['poster_url'];
				$data[$id]['content'] = $line['isi_feed'];
				$data[$id]['unformatted_time'] = $line['waktu_feed'];
				$data[$id]['time'] = date('F d Y, H:i', strtotime($line['waktu_feed']));
				$data[$id]['commentaries'] = array();
			}else{ // Comments & their parent
				if(!isset($data[$id]['content'])){ // jika parentnya belum disimpan
					$data[$id] = array();
					$data[$id]['poster_username'] = $line['poster_username'];
					$data[$id]['poster_name'] = $line['poster_name'];
					$data[$id]['poster_url'] = $line['poster_url'];
					$data[$id]['content'] = $line['isi_feed'];
					$data[$id]['unformatted_time'] = $line['waktu_feed'];
					$data[$id]['time'] = date('F d Y, H:i', strtotime($line['waktu_feed']));
					$data[$id]['commentaries'] = array();
				}
				$data[$id]['commentaries'][] = array('poster_username'=>$line['comm_poster_username'], 
													 'poster_name'=>$line['comm_poster_name'], 
													 'poster_url'=>$line['comm_poster_url'], 
													 'content'=>$line['comm_isi_feed'], 
													 'time'=>date('F d Y, H:i', strtotime($line['comm_waktu_feed']))
													 );
			}
		}
		uasort($data, "sortByTime");
		$keys = array_keys($data);
		echo json_encode(array("data"=>$data, "keys"=>$keys));
		//var_dump($data);
	}else if($action == "getFeeds"){
		$timestamp = $_POST['timestamp'];
		$time = date('Y-m-d H:i:s', $timestamp);
		$total = (int)$_POST['total']*5;
		$location_id = ((int)$_POST['location_id'])-1;
		$addition = ($location_id === 0)?"":" AND A.id_lokasi=$location_id";
		
		$dam = new DAM();		
		$query = <<<END
			SELECT poster_username, poster_name, poster_url, `aktor_sistem`.Username as comm_poster_username, `aktor_sistem`.Nama as comm_poster_name,`aktor_sistem`.URLFoto as comm_poster_url, id_feed, isi_feed, waktu_feed, comm_isi_feed, comm_waktu_feed FROM
			(
			SELECT `aktor_sistem`.Username as poster_username, `aktor_sistem`.Nama as poster_name, `aktor_sistem`.URLFoto as poster_url, id_feed, isi_feed, waktu_feed, comm_id_user, comm_isi_feed, comm_waktu_feed  FROM
			(
			SELECT A.id_user as id_user, A.id_feed as id_feed, A.isi_feed as isi_feed, A.waktu_feed as waktu_feed, B.id_user as comm_id_user, B.isi_feed as comm_isi_feed, B.waktu_feed as comm_waktu_feed FROM `feed` A LEFT JOIN `feed` B ON A.`id_feed` = B.`induk_feed` WHERE A.`waktu_feed` < '$time' AND A.`tipe_feed` IN ('0', '1') $addition ORDER BY A.waktu_feed DESC, B.waktu_feed ASC
			) F JOIN `aktor_sistem` ON F.id_user = `aktor_sistem`.`ID` WHERE 1 LIMIT $total
			) G LEFT JOIN `aktor_sistem` ON G.comm_id_user = `aktor_sistem`.`ID` WHERE 1
END;
		//echo $query;
		$rs = $dam->query($query);
		$data = array();
		while($line = $rs->fetch_assoc()){
			$id = (int)$line['id_feed'];
			if($line['comm_poster_username'] == NULL){ // Non Comment
				$data[$id] = array();
				$data[$id]['poster_username'] = $line['poster_username'];
				$data[$id]['poster_name'] = $line['poster_name'];
				$data[$id]['poster_url'] = $line['poster_url'];
				$data[$id]['content'] = $line['isi_feed'];
				$data[$id]['unformatted_time'] = $line['waktu_feed'];
				$data[$id]['time'] = date('F d Y, H:i', strtotime($line['waktu_feed']));
				$data[$id]['commentaries'] = array();
			}else{ // Comments & their parent
				if(!isset($data[$id]['content'])){ // jika parentnya belum disimpan
					$data[$id] = array();
					$data[$id]['poster_username'] = $line['poster_username'];
					$data[$id]['poster_name'] = $line['poster_name'];
					$data[$id]['poster_url'] = $line['poster_url'];
					$data[$id]['content'] = $line['isi_feed'];
					$data[$id]['unformatted_time'] = $line['waktu_feed'];
					$data[$id]['time'] = date('F d Y, H:i', strtotime($line['waktu_feed']));
					$data[$id]['commentaries'] = array();
				}
				$data[$id]['commentaries'][] = array('poster_username'=>$line['comm_poster_username'], 
													 'poster_name'=>$line['comm_poster_name'], 
													 'poster_url'=>$line['comm_poster_url'], 
													 'content'=>$line['comm_isi_feed'], 
													 'time'=>date('F d Y, H:i', strtotime($line['comm_waktu_feed']))
													 );
			}
		}
		uasort($data, "sortByTime");
		$keys = array_keys($data);
		echo json_encode(array("data"=>$data, "keys"=>$keys));
		//var_dump($data);
	}else if($action == "getNewNotif"){
		if(isset($_SESSION['SessionData'])){
			$p = $_SESSION['SessionData'];
			$id = $p['ID'];
			
			// cek apakah user diblock atau didelete
			$pm = new PenggunaManager();
			$userStatus = $pm->getUserStatus(array("ID"=>$id));
			
			if($userStatus['valid']){
				unset($pm); unset($userStatus);
				$dam = new DAM();
				$query = "SELECT `id_obj` as id, `tipe_notif` as type, GROUP_CONCAT(DISTINCT `aktor_sistem`.`Nama`) as names FROM `notifikasi` LEFT JOIN `aktor_sistem` ON `notifikasi`.`id_pemberi` = `aktor_sistem`.ID WHERE `status_notif`='0' AND `id_user`='$id' GROUP BY `id_obj`, `tipe_notif`";
				//var_dump($query); exit(0);
				$temp = $dam->specialQuery($query);
				$data = array();
				while($line = $temp->fetch_assoc()){
					$type = $line['type'];
					$notif_id = $line['id'];
					$names = $line['names'];
					if(!isset($data[$type])) $data[$type] = array();
					$data[$type][$notif_id] = $names;
				}
				echo json_encode(array("ok"=>true, "data"=>$data));
			}else{
				echo json_encode(array("ok"=>false, "message"=>"Your account is not valid for now."));
			}
		}else{
			echo json_encode(array("ok"=>false, "message"=>"You're not authorized"));
		}
	}else if($action == "getAdminToken"){
		$p = $_SESSION['SessionData'];
		$_SESSION['attemp'] = isset($_SESSION['attemp'])?$_SESSION['attemp']+1:0;
		if($_SESSION['attemp'] >= 3){
			echo json_encode(array("ok"=>true, "message"=>"maximum attemp reached. attemp: ".$_SESSION['attemp'], "refresh"=>true));
			unset($_SESSION['SessionData']);
			unset($_SESSION['attemp']);
		}else{
			if(isset($p) && ($p['isAdmin']==1) && $_POST){			
				$id = $p['ID'];			
				$dam = new DAM();
				if(md5($_POST['pass']) == $p['Password']){		
					$token = getRandomChars(20);
					echo json_encode(array("ok"=>true, "token"=>$token));
					$_SESSION['SessionData']['token'] = $token;
					unset($_SESSION['attemp']);
				}else{
					$chance = 3 - $_SESSION['attemp'];
					echo json_encode(array("ok"=>false, "message"=>"Invalid Password. You have $chance attemp".($chance>1?"s":"")." left"));
				}
			}else{
				echo json_encode(array("ok"=>false, "message"=>"You're not authorized"));
			}
		}
	}else{
		header("HTTP/1.0 101 Invalid Action");
	}
	
?>