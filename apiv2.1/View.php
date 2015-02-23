<?php
class View{
	
    public function __construct() {	    
		
    }
    
    
    public function drawing($drawing_id){
	    	    
		$id = $drawing_id;
		$remoteImage = ROOT . "/files/drawing/$id.jpg";
		$imginfo = getimagesize($remoteImage);
		header("Content-type: image/jpeg");
		echo file_get_contents($remoteImage);	    
	    
    }


	public function render($part, $param1 = null, $param2 = null){
		global $db, $config, $router, $user;
				
		if($part == "Login"){
			$user->loginGate();
			require_once dirname(__DIR__) . '/views/login.php';
			exit();
		}
		
		/* Views below require login */	
		User::authService();		
		
		
		require_once __DIR__ . '/Course.php';
		$courseAPI = new Course();	
		
		$config['pagename'] = str_replace("_", " ", $part);	
		
		require dirname(__DIR__) . '/views/header.php';
		
		switch($part){
			
			case "Question_Bank":
				if(User::isTeacher()){
					require dirname(__DIR__) . '/views/questionbank.php';
				}			
				break;
			
			case "Assignment_Do":
				$assignment_id = $param1;	
				$config['assignment_do'] = true;
				require_once __DIR__ . '/Assignment.php';
				require_once __DIR__ . '/Testcase.php';			
				if(User::isStudent()){		
					require dirname(__DIR__) . '/views/student-assignment-do.php';
				}			
				break;
					
			
			case "Course":				
				if(User::isStudent()){		
					$config['script'] = ["student-course"];
					require dirname(__DIR__) . '/views/student-course.php';
				}elseif(User::isTeacher()){
					require dirname(__DIR__) . '/views/teacher-course.php';
				}												
				break;
				
			case "Course_Detail":
				$course_id = $param1;
				if(User::isStudent()){		
					require dirname(__DIR__) . '/views/student-course-detail.php';
				}elseif(User::isTeacher()){
					$config['script'] = ["teacher-course-detail"];
					require dirname(__DIR__) . '/views/teacher-course-detail.php';
				}												
				break;
			
			case "Course_New":				
				if(User::isTeacher()){
					require_once __DIR__ . '/School.php';
					$config['script'] = ["teacher-course-new"];
					require dirname(__DIR__) . '/views/teacher-course-new.php';
				}												
				break;							
				
			case "Assignment":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(User::isStudent()){		
					require dirname(__DIR__) . '/views/student-assignment.php';
				}elseif(User::isTeacher()){
					$config['script'] = ['teacher-assignment'];
					require dirname(__DIR__) . '/views/teacher-assignment.php';
				}			
				break;
			
			case "Assignment_Edit":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(User::isStudent()){		
					die();
				}elseif(User::isTeacher()){
					$config['script'] = ["teacher-assignment-form"];
					require dirname(__DIR__) . '/views/teacher-assignment-edit.php';
				}			
				break;								
				
			case "Assignment_Testcase_Edit":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(User::isStudent()){		
					die();
				}elseif(User::isTeacher()){
					$config['script'] = ["teacher-assignment-testcase"];
					require dirname(__DIR__) . '/views/teacher-assignment-edit-testcase.php';
				}			
				break;		
				
			case "Assignment_Statistics":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(User::isStudent()){		
					die();
				}elseif(User::isTeacher()){
					$config['script'] = ["teacher-assignment-stat"];
					require dirname(__DIR__) . '/views/teacher-assignment-stat.php';
				}			
				break;	
				
			case "Assignment_Group_Statistics":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(User::isStudent()){		
					die();
				}elseif(User::isTeacher()){
					$config['script'] = ["teacher-assignment-group-stat"];
					require dirname(__DIR__) . '/views/teacher-assignment-group-stat.php';
				}			
				break;										
								
		}					
		
		require dirname(__DIR__) . '/views/footer.php';
		


			
		
	}

	public function course(){
		global $courseAPI, $db;
		

								
		$this->render("header");
		
		if(User::isStudent()){		
			render("student");
		}elseif(User::isTeacher()){
			
			render("teacher");
		}	
		
		render("footer");	
		
	}
	
    
}