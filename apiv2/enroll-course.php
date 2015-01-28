<?php

if(!isset($_GET)){
	die();
}

require "class/course.php";

$course_id = $_GET['course_id'];
$user_id = $_GET['user_id'];

$course = new course();
$course->enrollStudent($course_id, 155);
$course->enrollStudent($course_id, 156);
$course->enrollStudent($course_id, 157);