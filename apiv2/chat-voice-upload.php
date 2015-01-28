<?php
require "class/chat.php";
$group_id = $_POST['group_id'];
$chatAPI = new chat();
$name = $chatAPI->submitMessage($group_id, '', 'voice');

$save_folder = dirname(__FILE__) . "/voice";
$tmp_name = $_FILES["audiofile"]["tmp_name"];
$upload_name = $_FILES["audiofile"]["name"];
$filename = "$save_folder/".$name.".wav";
$saved = 0;
$saved = move_uploaded_file($tmp_name, $filename) ? 1 : 0;
echo $name;
?>