<?php
require_once "class/file.php";
$fileAPI = new file($_FILES);
$fileAPI->submitQuestion();
?> 
