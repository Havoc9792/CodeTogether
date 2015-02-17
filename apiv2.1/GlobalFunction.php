<?php
class GlobalFunction{
	
	//Check if user is in group
	public static function isUserInGroup($group_id){
		global $db;		
		$user_id = User::authService()['user_id'];		
		$db->where("group_id", $group_id);		
		$db->where("student_id", $user_id);
		$db->get("assignment_group_student");		
		if($db->count == 0){
			return false;
		}else{
			return true;
		}
	}
	
	//Check if user own an editor tab
	public static function isUserOwnEditor($editor_id){
		global $db;		
		$user_id = User::authService()['user_id'];			
		$db->join("assignment_group_student AGS", "AGS.group_id=AGC.group_id", "LEFT");			
		$db->where("AGC.editor", $editor_id);
		$db->where("AGS.student_id", $user_id);
		$db->get("assignment_group_code AGC");				
		if($db->count == 0){
			return false;
		}else{
			return true;
		}
	}	
}