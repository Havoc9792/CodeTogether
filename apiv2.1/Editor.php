<?php
class Editor{
	

    public function __construct($assignment_id = null) {	    
		//$this->assignment_id = $assignment_id;  	                 
    }


	public function history($editor_id, $history_id = null){
		global $db;
		if(!GlobalFunction::isUserOwnEditor($editor_id)) die('no auth');
		
		//Get a list of history
		if(is_null($history_id)){		
			$data = $db->rawQuery("SELECT AH.editor as editor, AH.assignment_history_id as assignment_history_id, AH.save_time as save_time, U.name as name
				FROM assignment_history AH 
				JOIN user U ON AH.user_id = U.user_id
				WHERE AH.editor = '{$editor_id}'");
		}else{
			//Get the editor with a specific history
			$data = $db->rawQuery("SELECT AH.editor as editor, AH.code as code, AH.assignment_history_id as assignment_history_id, AH.save_time as save_time, U.name as name
				FROM assignment_history AH 
				JOIN user U ON AH.user_id = U.user_id
				WHERE AH.editor = '{$editor_id}'
				AND AH.assignment_history_id = '{$history_id}' ")[0];			
		}
	    echo json_encode($data);	    		
	}
	

	public function manage($action, $editor_id = null){
		global $db;					
		$teacher_id = User::authService()['user_id'];
		$data = $_POST['code'];	
				
		switch($action){
			case "create":
				
				break;
			case "delete":	
				if(!GlobalFunction::isUserOwnEditor($editor_id)) die('no auth');						
				$db->where('editor', $editor_id);	
				
				if(User::isTeacher()){
					$db->delete('assignment_sample_code');
				}else{
					$db->delete('assignment_group_code');
					
					$db->where('editor', $editor_id);
					$db->delete('assignment_history');
				}
															
				echo 1;
				break;
			case "update":	
				if(!isset($data)){
					echo 1;
					die();
				}	
				
				foreach($data as $d){
					$sample_code_id = substr($d['id'], 6);
					//echo $sample_code_id;
					$db->where('sample_code_id', $sample_code_id);
					$db->update("assignment_sample_code", array(
						'assignment_id' => $assignment_id, 
						'code' => $d['editor']
						)
					);
				}		
				echo 1;					
				break;
		}										
		
	}
	
}