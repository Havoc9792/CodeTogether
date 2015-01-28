<?php

if(!isset($_GET)){
	die();
}

$school = $_GET['school'];

require "class/user.php";
$user = new user();
for($i=0;$i<50;$i++){
	$user->createUser($school."student".$i, $school."student".$i, 1234, 4, 0);
}
