<?php
require "class/assignment.php";
$assignmentID = $_POST['assignment_id'];
$assignmentAPI = new assignment();
//ob_start();
$json = $assignmentAPI->testcaseRanking($assignmentID);
//$json =ob_get_clean();
//$result = json_decode($json,1);
echo $json;
?>