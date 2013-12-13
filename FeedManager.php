<?php
	include_once("dam.php");
	
	class FeedManager{
		private $db;		
		public function __construct(){
			$this->db = new DAM();
		}
		
		public function getFeed($data){
			$id = $data['id_feed'];
			$query = <<<END
				SELECT poster_username, poster_name, poster_url, `aktor_sistem`.Username as comm_poster_username, `aktor_sistem`.Nama as comm_poster_name,`aktor_sistem`.URLFoto as comm_poster_url, id_feed, isi_feed, tipe_feed, waktu_feed, comm_isi_feed, comm_waktu_feed FROM
				(
				SELECT `aktor_sistem`.Username as poster_username, `aktor_sistem`.Nama as poster_name, `aktor_sistem`.URLFoto as poster_url, id_feed, tipe_feed, isi_feed, waktu_feed, comm_id_user, comm_isi_feed, comm_waktu_feed  FROM
				(
				SELECT A.id_user as id_user, A.id_feed as id_feed, A.isi_feed as isi_feed, A.waktu_feed as waktu_feed, A.tipe_feed as tipe_feed, B.id_user as comm_id_user, B.isi_feed as comm_isi_feed, B.waktu_feed as comm_waktu_feed FROM `feed` A LEFT JOIN `feed` B ON A.`id_feed` = B.`induk_feed` WHERE A.`id_feed` = '$id'
				) F JOIN `aktor_sistem` ON F.id_user = `aktor_sistem`.`ID` WHERE 1 
				) G JOIN `aktor_sistem` ON G.comm_id_user = `aktor_sistem`.`ID` WHERE 1
END;
			//var_dump($query);exit(0);
			$rs = $this->db->specialQuery($query);
			
			if($rs->num_rows > 0){			
				$data = array();
				while($line = $rs->fetch_assoc()){
					if($line['comm_poster_username'] == NULL){ // Non Comment
						$data = array(); $data['poster'] = array(); $data['data'] = array(); $data['commentaries'] = array();
						$data['poster']['username'] = $line['poster_username'];
						$data['poster']['name'] = $line['poster_name'];
						$data['poster']['url'] = $line['poster_url'];
						$data['data']['content'] = $line['isi_feed'];
						$data['data']['time'] = $line['waktu_feed'];
						$data['data']['id_feed'] = $line['id_feed'];
						//$data['time'] = date('F d Y, H:i', strtotime($line['waktu_feed']));
					}else{ // Comments & their parent
						if(!isset($data['data']['content'])){ // jika parentnya belum disimpan
							$data = array(); $data['poster'] = array(); $data['data'] = array(); $data['commentaries'] = array();
							$data['poster']['username'] = $line['poster_username'];
							$data['poster']['name'] = $line['poster_name'];
							$data['poster']['url'] = $line['poster_url'];
							$data['data']['content'] = $line['isi_feed'];
							$data['data']['time'] = $line['waktu_feed'];
							$data['data']['id_feed'] = $line['id_feed'];
						}
						$data['commentaries'][] = 
							array('poster'=>array("username"=>$line['comm_poster_username'], "name"=>$line['comm_poster_name'], "url"=>$line['comm_poster_url']),
								  'data'=>array("content"=>$line['comm_isi_feed'], "time"=>$line['comm_waktu_feed'])
								 );
					}
				}
				return $data;				
			}
			return NULL;
		}
		
		public function validate($data){
			$retVal = array();
			foreach($data as $key=>$value){
				$retVal[$key] = $this->db->real_escape_string($value);
			}
			return $retVal;
		}
		
		
		public function getOwnership($data){
			$data = $this->validate($data);
			$id_user = $data['id_user'];
			unset($data['id_user']);
			$temp = $this->db->retrieveBeta("feed", array('type'=>'AND', 'cond'=>$data));
			if($line = $temp->fetch_assoc()){
				if($line['id_user'] == $id_user){
					return array('owned'=>true);
				}else{
					return array('owned'=>false, 'owner'=>$line['id_user']);
				}
			}
			return NULL;
		}
		
		public function isFollowing($data){
			$data = $this->validate($data);
			$temp = $this->db->retrieveBeta("follow_feed", array('type'=>'AND', 'cond'=>$data));
			return $temp->num_rows > 0;
		}
		
		public function unFollow($data){
			$data = $this->validate($data);
			$temp = $this->db->deleteBeta("follow_feed", array('type'=>'AND', 'cond'=>$data));
			return $temp;
		}
	}
	
	
?>