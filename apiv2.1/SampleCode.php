<?php
class SampleCode{
	
	private $course_id;
	private $assignment_id;

    public function __construct($assignment_id = null) {	    
		//$this->assignment_id = $assignment_id;  	                 
    }

	

	public function manage($assignment_id, $action){
		global $db;			
		
		$teacher_id = User::authService()['user_id'];
		$data = $_POST['code'];	
				
		switch($action){
			case "create":
				$id = $db->insert("assignment_sample_code", array("assignment_id" => $assignment_id));
				echo $id;
				break;
			case "delete":			
				$editor_id = $_POST['editor_id'];
				$db->where('assignment_id', $assignment_id);
				$db->where('editor_id', $editor_id);
				$db->delete('assignment_sample_code');
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
	
	
	public function get($assignment_id){
		global $db;		
				
		$db->where('assignment_id', $assignment_id);
		$result = $db->get('assignment_testcase');
		echo json_encode($result, TRUE);
	}
    
}