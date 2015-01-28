<?php
//require_once "mysql.php";
interface compiler{
	public function compile($group_id);
	public function saveCode($group_id,$codeArray);
	public function runCode($group_id,$inputs);
	
	/*
	
	
	public function rrmdir($dir){
		if(is_dir($dir)){
			$objects = scandir($dir);
			foreach ($objects as $object){
				if ($object != "." && $object != ".."){
					if (filetype($dir."/".$object) == "dir")
						$this->rrmdir($dir."/".$object);
					else
						unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
	public function makeFileHistory($group_id, $codeArray){
	    $user_id = user::authService()['user_id'];
	    foreach($codeArray as $code){
		    $excapedCode = $this->escape($code);
	    	$sql = "INSERT INTO assignment_history (group_id, code, user_id,editor) VALUES ('{$group_id}', '{$excapedCode}', '{$user_id}','{editor}')";
			$this->query($sql);
	    }
	    $sql2 = "SELECT assignment_history_id as id FROM assignment_history  WHERE group_id = '{$group_id}' ORDER BY save_time DESC LIMIT 1 OFFSET 50";
	    $result = $this->query($sql2);
	    if($result->num_rows != 0){
		    $id = $result->fetch_assoc()['id'];
	    
			$sql3 = "DELETE FROM assignment_history WHERE group_id = '{$group_id}' AND assignment_history_id < '{$id}'";
			$this->query($sql3);
		}
	    
	    return true;
    }
    
    */
}