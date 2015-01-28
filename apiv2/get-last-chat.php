<?php

$group_id = $_POST['group_id'];

require "class/chat.php";
$chatAPI = new chat();

echo $chatAPI->getLastMessage($group_id);



