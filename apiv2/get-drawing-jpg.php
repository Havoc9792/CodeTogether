<?php

$id = $drawing_id;
$remoteImage = dirname(__DIR__) . "/files/drawing/$id.jpg";
$imginfo = getimagesize($remoteImage);
header("Content-type: image/jpeg");
echo file_get_contents($remoteImage);
die();