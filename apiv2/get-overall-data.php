<?php

require "class/data.php";

$testcase_id = $_POST['testcase_id'];
$assignment_id = $_POST['assignment_id'];
$dataAPI = new data();

$data = array('pass'=>$dataAPI->getPassData($testcase_id), 'fail'=>$dataAPI->getFailData($testcase_id), 'attempt'=>$dataAPI->getAttemptData($testcase_id), 'groupno'=>$dataAPI->getAssignmentGroup($assignment_id));

echo json_encode($data);