<?php
class View{
	
    public function __construct() {	    
		
    }


	public function render($part, $param1 = null, $param2 = null){
		global $db, $config, $router;
				
		if($part == "Login"){
			require_once dirname(__DIR__) . '/views/login.php';
			exit();
		}		
		
		require_once __DIR__ . '/Course.php';
		$courseAPI = new Course();	
		
		$config['pagename'] = str_replace("_", " ", $part);	
		
		require dirname(__DIR__) . '/views/header.php';
		
		switch($part){
					
			
			case "Course":				
				if(user::isStudent()){		
					require dirname(__DIR__) . '/views/student-course.php';
				}elseif(user::isTeacher()){
					require dirname(__DIR__) . '/views/teacher-course.php';
				}												
				break;
				
			case "Course_Detail":
				$course_id = $param1;
				if(user::isStudent()){		
					require dirname(__DIR__) . '/views/student-course-detail.php';
				}elseif(user::isTeacher()){
					require dirname(__DIR__) . '/views/teacher-course-detail.php';
				}												
				break;
				
			case "Assignment":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(user::isStudent()){		
					require dirname(__DIR__) . '/views/student-assignment.php';
				}elseif(user::isTeacher()){
					$config['script'] = ['teacher-assignment'];
					require dirname(__DIR__) . '/views/teacher-assignment.php';
				}			
				break;
			
			case "Assignment_Edit":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(user::isStudent()){		
					die();
				}elseif(user::isTeacher()){
					$config['script'] = ["teacher-assignment-form"];
					require dirname(__DIR__) . '/views/teacher-assignment-edit.php';
				}			
				break;								
				
			case "Assignment_Testcase_Edit":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(user::isStudent()){		
					die();
				}elseif(user::isTeacher()){
					$config['script'] = ["teacher-assignment-testcase"];
					require dirname(__DIR__) . '/views/teacher-assignment-edit-testcase.php';
				}			
				break;		
				
			case "Assignment_Statistics":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(user::isStudent()){		
					die();
				}elseif(user::isTeacher()){
					$config['script'] = ["teacher-assignment-stat"];
					require dirname(__DIR__) . '/views/teacher-assignment-stat.php';
				}			
				break;	
				
			case "Assignment_Group_Statistics":	
				$assignment_id = $param1;	
				require_once __DIR__ . '/Assignment.php';			
				if(user::isStudent()){		
					die();
				}elseif(user::isTeacher()){
					$config['script'] = ["teacher-assignment-group-stat"];
					require dirname(__DIR__) . '/views/teacher-assignment-group-stat.php';
				}			
				break;										
								
		}
		
		?>
		<p style="position: fixed; bottom: 0; right: 10px; z-index: 10000; background: #FFF; color: red; font-size: 20px">This page is currently using <b>New</b> apiv2.1 (msg from Hei)</p>
		<?php		
		
		require dirname(__DIR__) . '/views/footer.php';
		


			
		
	}

	public function course(){
		global $courseAPI, $db;
		

								
		$this->render("header");
		
		if(user::isStudent()){		
			render("student");
		}elseif(user::isTeacher()){
			
			render("teacher");
		}	
		
		render("footer");	
		
	}
	
    
}