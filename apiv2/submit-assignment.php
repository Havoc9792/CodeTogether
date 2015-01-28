<?php

//var_dump($_POST);

$form = array();
foreach($_POST['form'] as $f){
	$form[$f['name']] = $f['value'];
}

//var_dump($form);

$title = $form['title'];
$description = $form['description'];
$dueDate = $form['due-date'];
$dueTime = $form['due-time'];
$codeType = $form['code-type'];

$grouping = $form['grouping'];
$status = $form['status'];
$course_id = $form['course-id'];

$samplecode = $_POST['code'];


require "class/assignment.php";
$assignmentAPI = new assignment();

if(isset($_GET['edit'])){
	//Edit excisting
	$assignment_id = $form['assignment-id'];
	if($return_assignment_id = $assignmentAPI->editAssignment($title, $description, $dueDate, $dueTime, $codeType, $samplecode, $status, $course_id, $assignment_id) ){
		//header("location: ../teacher/assignments.php?course_id=" . $course_id);
		echo $return_assignment_id;
	}else{
		echo -1;
	}		
}else{
	//Create New
	if($assignment_id = $assignmentAPI->createAssignment($title, $description, $dueDate, $dueTime, $codeType, $samplecode, $status, $grouping, $course_id) ){
		//header("location: ../teacher/assignments.php?course_id=" . $course_id);                
		echo $assignment_id;
	}else{
		echo -1;
	}	
}




