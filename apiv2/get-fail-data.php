<?php

require "class/data.php";

$testcase_id = $_POST['testcase_id'];

$dataAPI = new data();
echo $dataAPI->getFailData($testcase_id);