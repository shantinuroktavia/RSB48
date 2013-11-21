<!--- tester.php merupakan class tamabhan yang digunakan untuk testing sistem.-->

<?php
session_start();
if(!isset($_GET['hash'])){
	$hash = getRandomChars(10);
	header("Location: tester.php?hash=".$hash);
	exit(0);
}
$hash = $_GET['hash'];

if(isset($_POST['scr'])){
	//var_dump($_POST);exit(0);
	$_SESSION[$hash]['script'] = $_POST['scr'];
}

$script = isset($_SESSION[$hash]['script'])?$_SESSION[$hash]['script']:"";
echo "<html><head><title>PHP Tester</title></head><body>";
eval($script);
echo "<br><hr><br><br><form action='tester.php?hash=$hash' method='post'>
<textarea name='scr' rows='10' cols='120'>$script
</textarea><br>
<input type='submit' value='Submit' />
</form>";

//method untuk mendapatkan karakter acak
function getRandomChars($n){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$result = "";
	while($n-- > 0){
		$r = rand(0, 61);
		$result .= substr($chars, $r, 1);
	}
	return $result;
}
?>