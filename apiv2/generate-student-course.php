<?php

if(!isset($_GET)){
	die();
}

$course_id = $_GET['course_id'];

require "class/mysql.php";
require "class/course.php";

$db = new mysql();
$course = new course();
$sql = "SELECT * FROM user WHERE type = 0";
$result = $db->query($sql);
while($row = $result->fetch_assoc()){
	$course->enrollStudent($course_id, $row['user_id']);
}

