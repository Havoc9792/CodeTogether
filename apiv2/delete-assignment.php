<?php

$assignment_id = $_POST['assignment_id'];

require "class/assignment.php";
$assignmentAPI = new assignment();
echo $assignmentAPI->deleteAssignment($assignment_id);



