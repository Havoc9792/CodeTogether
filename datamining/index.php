<?php
unlink("labeled.arff");

$assignment_id = $_POST['assignment_id'];
$input = $_POST['input'];
/**
Tino's		
*/
	
	
	
	
	
	
	
	
shell_exec("sh compile.sh"); 
shell_exec("sh run.sh");

$data = file_get_contents("labeled.arff");
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