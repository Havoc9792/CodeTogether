<?php
require "class/assignment.php";
$group_id = $_POST['group_id'];
$assignmentAPI = new assignment();
echo $assignmentAPI->addEditor($group_id);