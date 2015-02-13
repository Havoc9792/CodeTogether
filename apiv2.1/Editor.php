<?php
class Editor{
	

    public function __construct($assignment_id = null) {	    
		//$this->assignment_id = $assignment_id;  	                 
    }

	

	public function manage($action, $editor_id = null){
		global $db;					
		$teacher_id = User::authService()['user_id'];
		$data = $_POST['code'];	
				
		switch($action){
			case "create":
				
				break;
			case "delete":							
				$db->where('editor', $editor_id);								
				$db->delete('assignment_group_code');
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