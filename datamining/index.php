<?php
unlink("labeled.arff");
$assignment_id = $_GET['assignment_id'];
$input = $_GET['input'];
/**
Tino's		
*/
require("/var/www/html2/apiv2.1/MysqliDB.php");
require("/var/www/html2/apiv2.1/Java.php");
define("ROOT", dirname(__DIR__));
$db = new MysqliDb('localhost', 'kit', 'kit1234', 'fyp');
$javaAPI = new Java();
ob_start();
$javaAPI->compileAndRun($assignment_id,$input);
$json =ob_get_clean();
$temp = json_decode($json, 1);
require("/var/www/html2/apiv2/class/assignment.php");
$assignmentAPI = new assignment();
error_log("input for sample code : ".$input);
error_log("expected output : ".$temp['content']);
$assignmentAPI->generateTrainingData($assignment_id,$input,$temp['content']);
	
	
	
	
	
	
	
	
shell_exec("sh compile.sh"); 
shell_exec("sh run.sh");

$data = file_get_contents("labeled.arff");
//echo $data;
//die();
$data = explode(PHP_EOL.PHP_EOL, $data);
foreach($data as &$d){
	$d = explode(PHP_EOL, $d);
	foreach($d as &$dd){
		$dd = explode("\t", $dd);
	}
}
$data = $data[0];

foreach($data as &$d){
	//$d[1] = intval($d[1]) * 100;
	$d[1] *= 100;
	if($d[1] < 0.001){
		$d[1] = "0.000";
	}
}

echo json_encode($data);