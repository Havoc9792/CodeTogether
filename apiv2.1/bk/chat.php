<?php
require_once "mysql.php";
require_once "user.php";
/**
 * chat class.
 *
 * @extends mysql
 */
class chat extends mysql{

	public $basePath;
	public $info;
	//private $course_id;
	private $group_id;

    /**
     * __construct function.
     *
     * @access public
     * @param mixed $course_id
     * @return void
     */
    public function __construct($group_id = null) {
        parent::__construct();
        $this->basePath = dirname(__FILE__);
        //Individual Course
        if(!is_null($group_id)){
	        //$this->info = $this->assignmentInfo($assignment_id);
	        $this->group_id = $group_id;
        }
    }

	public function submitMessage($group_id, $message, $type){
		$user_id = user::authService()['user_id'];
		$message = $this->escape($message);
		$sql = "INSERT INTO chat (group_id, user_id, content, type) VALUES ('{$group_id}', '{$user_id}', '{$message}', '{$type}')";
		$this->query($sql);
		if ($type == 'voice'){
			$sql = "SELECT chat_id FROM chat WHERE group_id = '{$group_id}' ORDER BY chat_id DESC LIMIT 1";
			$result = $this->query($sql);
			$row = $result->fetch_assoc();
			return $row["chat_id"];
		}
	}
	
	public function loadMessage($group_id, $chat_id){
		if ($chat_id == 0)
			$sql = "SELECT U.user_id as user_id, U.name as username, C.content as message, C.chat_id as chat_id, C.type as type FROM chat C JOIN user U ON C.user_id = U.user_id WHERE C.group_id = '{$group_id}' ORDER BY chat_id DESC LIMIT 50";
		else
			$sql = "SELECT U.user_id as user_id, U.name as username, C.content as message, C.chat_id as chat_id, C.type as type FROM chat C JOIN user U ON C.user_id = U.user_id WHERE C.group_id = '{$group_id}' AND C.chat_id < '{$chat_id}' ORDER BY chat_id DESC LIMIT 50";
		$result = $this->query($sql);
		$data = array();
		if ($result->num_rows != 0){
			while($row = $result->fetch_assoc()){
				$row['avatar'] = user::avatar($row['user_id']);
				$data[] = $row;
			}
			$reverse = array_reverse($data);
		}
		return json_encode($reverse);
	}
	
	public function getLastMessage($group_id){
		$sql = "SELECT U.user_id as user_id, U.name as username, C.sent_time as time FROM chat C JOIN user U ON C.user_id = U.user_id WHERE C.group_id = '{$group_id}' ORDER BY chat_id DESC LIMIT 1";
		$result = $this->query($sql);
		$row = $result->fetch_assoc();
		$row['avatar'] = user::avatar($row['user_id']);
		return json_encode($row);
	}
}