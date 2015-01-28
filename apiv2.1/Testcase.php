<?php
class Testcase{
	
	private $course_id;
	private $assignment_id;

    public function __construct($assignment_id = null) {	    
		//$this->assignment_id = $assignment_id;  	                 
    }

	
	/**
	 * Testcase API for teacher will land here first
	 * 
	 * @access public
	 * @param mixed $action [create|edit|delete]
	 * @return void
	 */
	public function manage($assignment_id, $action){
		global $db;			
		
		$teacher_id = User::authService()['user_id'];
		$data = $_POST['data'];	
				
			
		switch($action){
			case "save":
				$db->where('assignment_id', $assignment_id);
				$db->delete('assignment_testcase');
				
				if(!isset($data)){
					echo 1;
					break;
				}
				
				foreach($data as $d){
					$db->insert("assignment_testcase", array(
						'assignment_id' => $assignment_id, 
						'input' => $d['input'],
						'output' => $d['output'], 
						'type' => $d['type'],
						'description' => $d['comment'])
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