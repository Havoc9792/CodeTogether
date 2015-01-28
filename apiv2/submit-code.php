<?php
/**
 * Save java code to server in a specific folder
 *
 * @param code [POST] java code string
 * @param folder [POST] folder to hold the code
 * @return 1 for successful save
 */

//$folder = $_POST['folder'];
//$file = "../code/". $folder ."/test.java";
//unlink($file);
//file_put_contents($file, $code);
require "class/assignment.php";
$codeArray = $_POST['codeArray'];
$group_id = $_POST['group_id'];
$assignment_id = $_POST['assignment_id'];
$assignmentAPI = new assignment();
echo $assignmentAPI->submitAssignment($group_id, $codeArray);

