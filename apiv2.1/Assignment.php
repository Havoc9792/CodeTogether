<?php
require_once 'File.php';
class Assignment{
	
	public $info;
	private $course_id;
	private $assignment_id;

    /**
     * __construct function.
     *
     * @access public
     * @param mixed $assignment_id
     * @return void
     */
    public function __construct($assignment_id = null) {
                       
        //Individual Course
        if(!is_null($assignment_id)){
	        //$this->info = $this->assignmentInfo($assignment_id);
	        $this->assignment_id = $assignment_id;
        }
    }

	public function manage($assignment_id, $action){
		global $db;						
		
		$teacher_id = User::authService()['user_id'];
		
		if(!user::isTeacher()){
			die();
		}
		
		$data = $_POST['form'];
		$code = $_POST['code'];	
		
		//var_dump($code); die();			
		
		$parsedData = array();
		foreach($data as $d){			
			$parsedData[$d['name']] = $d['value'];
		}				
				
		switch($action){
			case "create":
				$id = $db->insert("assignment_sample_code", array("assignment_id" => $assignment_id));
				$assignment_id = $id;
				echo $id;
				break;	
							
			case "update":					
				if(!isset($data)){
					echo 1;
					die();
				}		
																		
				$deadline = date("Y-m-d H:i:s", strtotime($parsedData['due-date'] . $parsedData['due-time']) );
				$db->where('assignment_id', $assignment_id);				
				$db->update('assignment', array(
						'title' => $parsedData['title'],
						"course_id" => $parsedData['course-id'],
						"description" => $parsedData['description'],
						"deadline" => $deadline,
						"status" => $parsedData['status'],
						"grouping" => $parsedData['grouping'],							
					)
				);
																	
				if(isset($code)){
					require_once 'SampleCode.php';
					$samplecode = new SampleCode;
					$samplecode->manage($assignment_id, "update");
				}else{
					echo 1;
				}
												
				break;
			case "delete":			
				$editor_id = $_POST['editor_id'];
				$db->where('assignment_id', $assignment_id);
				$db->where('editor_id', $editor_id);
				$db->delete('assignment_sample_code');
				echo 1;
				break;				
		}										
		
	}
	
	
    public function getEditor($group_id){
	    global $db;	    
	    $db->where("group_id", $group_id);
	    $editors = $db->get("assignment_group_code", null, 'editor, code');	    	    
	    return $editors;
    }	
	
	public function groupID($assignment_id = null){
		global $db;
		if(is_null($assignment_id)){
			$assignment_id = $this->assignment_id;
		}
		if(user::isTeacher()) return;
		$user_id = user::authService()['user_id'];
		if(isset($assignment_id)){
			$result = $db->rawQuery("SELECT AGS.group_id 
					FROM assignment_group_student AGS
					JOIN assignment_group AG ON AG.group_id = AGS.group_id
					WHERE AGS.student_id = '{$user_id}' 
					AND AG.assignment_id = '{$assignment_id}'");			
			return $result[0]['group_id'];
		}
	}
	
	public function groupList($assignment_id){
		global $db;
		if(is_null($assignment_id)){
			$assignment_id = $this->assignment_id;
		}				
		if(user::isStudent()){
			$group_id = $this->groupID($assignment_id);
			$result = $db->rawQuery("SELECT AG.group_id as group_id, U.name as name, S.name as school_name, U.user_id as user_id
					FROM assignment_group AG
					JOIN assignment_group_student AGS ON AG.group_id = AGS.group_id
					JOIN user U ON U.user_id = AGS.student_id
					JOIN school S ON S.school_id = U.school_id
					WHERE AG.assignment_id = '{$assignment_id}'					
					AND AG.group_id = '{$group_id}'
					ORDER BY U.name ASC");			
		}else{
			$result = $db->rawQuery("SELECT AG.group_id as group_id, U.name as name, S.name as school_name, U.user_id as user_id
					FROM assignment_group AG
					JOIN assignment_group_student AGS ON AG.group_id = AGS.group_id
					JOIN user U ON U.user_id = AGS.student_id
					JOIN school S ON S.school_id = U.school_id
					WHERE AG.assignment_id = '{$assignment_id}'					
					ORDER BY U.name ASC");
		}
		
		$data = array();
		foreach($result as $row){
			$data[$row['group_id']][] = $row;
		}
		return $data;		
	}	

    
	public function info($assignment_id = null){
		global $db;
		
		if(is_null($assignment_id)){
			$assignment_id = $this->assignment_id;
		}
		
		$user_id = user::authService()['user_id'];
		if(!isset($assignment_id) && !isset($user_id)){
			return -1;
		}
		
		$db->where("assignment_id", $assignment_id);		
        $result = $db->get("assignment")[0];                
       
		$db->where("type_id", $assignment_id);
		$db->where("type", "question");
		$resultFile = $db->get("file");
        
        $files = array();
        foreach($resultFile as $rowFile){
                $filepath = file::getFilename($rowFile['file_id'], $rowFile['extension']);
                $rowFile['filepath'] = $filepath;
                $files[] = $rowFile;
        }
        $result['files'] = $files;
				

        if(user::isStudent() ){
	        $result['group_id'] = Assignment::groupID($assignment_id);	        	        	        
	        $result['editor'] = Assignment::getEditor($result['group_id']);	        	        	        
        }elseif(user::isTeacher() ){
	        $db->where("assignment_id", $assignment_id);
	        $result2 = $db->get("assignment_group", "COUNT(*) as group_count")[0];						
			
			$result['group_count'] = $result2['group_count'];
			$deadline = explode(" ", $result['deadline']);
			$result['due_date'] = $deadline[0];
			$result['due_time'] = $deadline[1];											
			
			$db->where("assignment_id", $assignment_id);
			$sample_codes = $db->get("assignment_sample_code");
									
			$result['sample_code'] = $sample_codes;
			
		}
		
		$result['deadline_time'] = strtotime($result['deadline']);			
		
		if(time() > $result['deadline_time']){
			$result['overdue'] = true;
		}else{
			$result['overdue'] = false;
			$diff = $result['deadline_time'] - time();
			$result['deadline_day'] = ceil($diff / 60 / 60 / 24);			
 		}			

        return $result;
	}    
    


}