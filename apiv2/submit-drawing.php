<?php
/**
 * Save java code to server in a specific folder
 *
 * @param code [POST] java code string
 * @param folder [POST] folder to hold the code
 * @return 1 for successful save
 */

//$folder = $_POST['folder'];
//$file = "../code/". $folder ."/test.java";
//unlink($file);
//file_put_contents($file, $code);
require "class/file.php";
$data = $_POST['drawing'];
$group_id = $_POST['group_id'];
$fileAPI = new file();
echo $fileAPI->submitDrawing($group_id, $data);

