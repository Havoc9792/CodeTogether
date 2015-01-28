<?php

require "class/data.php";

$group_id = $_POST['group_id'];

$dataAPI = new data();
echo $dataAPI->getCollaborationData($group_id);