<?php

$group_id = $_POST['group_id'];
$chat_id = $_POST['chat_id'];

require "class/chat.php";
$chatAPI = new chat();

echo $chatAPI->loadMessage($group_id, $chat_id);



