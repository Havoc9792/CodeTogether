<?php
/**
 * Save java code to server in a specific folder
 *
 * @param code [POST] java code string
 * @param folder [POST] folder to hold the code
 * @return 1 for successful save
 */

require "class/assignment.php";
$inputs = $_POST['inputs'];
$group_id = $_POST['group_id'];
$assignment_id = $_POST['assignment_id'];
$assignmentAPI = new assignment();
echo $assignmentAPI->testAssignment($group_id, $inputs);