<?php
/**
 * Save java code to server in a specific folder
 *
 * @param code [POST] java code string
 * @param folder [POST] folder to hold the code
 * @return 1 for successful save
 */

require "class/data.php";
$group_id = $_POST['group_id'];
$text = $_POST['text'];
$voice = $_POST['voice'];
$drawing = $_POST['drawing'];
$code = $_POST['code'];
$dataAPI = new data();
echo $dataAPI->uploadCollaborationData($group_id, $text, $voice, $drawing, $code);