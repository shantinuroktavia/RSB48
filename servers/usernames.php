<?php
	include("../dam.php");
	$return = $users = array();
	
	$dam = new DAM();
	$temp = $dam->retrieve("pengguna", true);
	while($line = $temp->fetch_assoc()){
		$username = $line['Username'];
		$name = $line['Nama'];
		$users[$username] = $name;
	}
	
	unset($dam);
	unset($temp);
	
	$term = $_GET["term"];
	foreach($users as $k=>$v){
		if(preg_match("/$term/i", $k)) { $return[] = $k; } 
		if(preg_match("/$term/i", $v)) { $return[] = $k; } 
	} 
	 echo $_GET['callback'] . '(' . json_encode(array_values(array_unique($return))) . ');'; 
	 
?>