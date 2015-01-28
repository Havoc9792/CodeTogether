<?php
/**
 * Compile java code in server in a specific folder
 *
 * @param folder [POST] folder to hold the code
 * @return 1 for successful complication
 */

/*
$folder = "/var/www/html/code/".$_POST['folder'];

$command = "sh /var/www/html/code/compile.sh $folder";
//echo $command;
exec($command);
$compile_error = file_get_contents("$folder/debug/compile.txt");
if($compile_error == ""){
	echo "1";
}else{
	echo nl2br($compile_error);
}
*/
require "class/assignment.php";
$group_id = $_POST['group_id'];
$assignmentAPI = new assignment();
echo $assignmentAPI->compileAssignment($group_id, $code);
