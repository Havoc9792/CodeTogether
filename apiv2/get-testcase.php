<?php

require "class/data.php";

$assignment_id = $_POST['assignment_id'];

$dataAPI = new data();
echo $dataAPI->getTestcase($assignment_id);