<?php
require "class/assignment.php";
$assignmentID = $_POST['assignment_id'];
$assignmentAPI = new assignment();
echo $assignmentAPI->generateTrainingData($assignmentID);
?>