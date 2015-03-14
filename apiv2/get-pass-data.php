<?php

require "class/data.php";

$testcase_id = $_POST['testcase_id'];

$dataAPI = new data();
echo $dataAPI->getPassData($testcase_id);