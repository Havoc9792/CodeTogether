<?php    
$a_id = $_POST['a_id'];
$num = $_POST['num'];

require "class/assignment.php";
$chatAPI = new assignment();

echo $chatAPI->createGroup($a_id, $num);	