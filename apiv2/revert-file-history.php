<?php

$id = $_POST['id'];
$group_id = $_POST['group_id'];

require "class/assignment.php";
$assignmentAPI = new assignment();

echo $assignmentAPI->getFileHistory($group_id, $id);



