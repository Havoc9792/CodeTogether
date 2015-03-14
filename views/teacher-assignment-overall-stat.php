<?php
$assignmentAPI = new Assignment($assignment_id);
$assignment = $assignmentAPI->info();

$course_id = $assignment['course_id'];
$courseAPI = new course($course_id);
$course = $courseAPI->info();

$group_id = $param2;
?>

<script type="text/javascript" src="/js/data/overall-data.js"></script>
