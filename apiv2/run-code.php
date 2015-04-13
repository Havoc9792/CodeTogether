<?php
/**
 * Run code in server in a specific folder
 *  
 * @param folder [POST] folder to hold the code
 * @return 1 for successful complication
 */

$inputs = $_POST['inputs'];
$path = "/var/www/html2/code";
//$folder = "/var/www/html/code/".$_REQUEST['folder'];

$folder = "/var/www/html2/code/".$_POST['group_id'];
file_put_contents($folder . "/input.txt", $inputs);
$command = "sh $path/mainClass.sh $folder";
//echo $command;
$output = shell_exec($command);
$output = explode("@@@@@@@@@@", $output);
$output = $output[1];
if($output == ""){
	echo "Error: Cannot find Java Main Class<br />";
}

$output = explode("/", $output);
$output = $output[sizeof($output)-1];
//echo json_encode(array('resultType' => "0",'content' => "sadasd"));

$commandRun = "sh $path/java.sh '$output' '$folder' ";
$run = shell_exec($commandRun);

if(file_get_contents($folder."/debug/runtime.txt") !=""){
	$result = 1;
}else{
	$result = 0;
}
	$content = file_get_contents($folder."/output.txt");
echo json_encode(array('resultType' => $result,'content' => $content));


