<?php
class GlobalFunction{
	
	
	public static function getInput(){
		parse_str(file_get_contents("php://input"), $input);
		return $input;
	}
	
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
		
		if(User::isStudent()){
			$db->join("assignment_group_student AGS", "AGS.group_id=AGC.group_id", "LEFT");			
			$db->where("AGC.editor", $editor_id);
			$db->where("AGS.student_id", $user_id);
			$db->get("assignment_group_code AGC");				
			if($db->count == 0){
				return false;
			}else{
				return true;
			}			
		}elseif(User::isTeacher()){
			$db->join('assignment A', 'A.assignment_id = SC.assignment_id', 'LEFT');
			$db->join('course C', 'C.course_id = A.course_id', 'LEFT');
			$db->where('C.user_id', $user_id);
			$db->get('assignment_sample_code SC');
			if($db->count == 0){
				return false;
			}else{
				return true;
			}			
		}	

	}	
}

