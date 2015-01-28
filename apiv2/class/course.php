<?php
require_once dirname(__FILE__) . "/mysql.php";
require_once dirname(__FILE__) . "/user.php";
require_once dirname(__FILE__) . "/assignment.php";
class course extends mysql{

	public $basePath;
	public $info;
	private $user;
	private $course_id;

    public function __construct($course_id = null) {
        parent::__construct();
        $this->basePath = dirname(__FILE__);
        //user::authService() = user::authService();
        //Individual Course
        if(!is_null($course_id)){
            $this->course_id = $course_id;
            $this->info = $this->courseInfo($course_id);
        }
    }

    public function enrollStudent($course_id, $user_id){
	    if(isset($course_id) && isset($user_id)){
                $sql = "INSERT INTO course_student (user_id, course_id) VALUES ({$user_id}, {$course_id}) ";
                $this->query($sql);
                return true;
	    }
    }

    public function courseStudentsList($course_id){
            if(!isset($course_id)){
                    return -1;
            }
            $sql = "SELECT U.user_id as user_id, U.name as name, S.name as school_name
                    FROM course_student CS
                    JOIN user U ON U.user_id = CS.user_id
                    JOIN school S ON U.school_id = S.school_id
                    WHERE course_id = '$course_id' ";
            $result = $this->query($sql);
            $studentList = array();
            while($row = $result->fetch_assoc()){
                    $studentList[] = $row;
            }
            return $studentList;
    }

    public function courseList(){
            $user_id = user::authService()['user_id'];
            if(!isset($user_id)){
                return -1;
            }
            //If user is teacher
            if(user::isTeacher() ){
                $sql2 = "SELECT * FROM course C WHERE C.user_id = '$user_id' ";
                $result = $this->query($sql2);
                $courseList = array();
                while($row = $result->fetch_assoc()){
                        $row['studentList'] = $this->courseStudentsList($row['course_id']);
                        $courseList[] = $row;
                }
                return $courseList;
            }else{
                $sql2 = "SELECT C.description AS description, C.name AS name, C.course_id AS course_id, C.course_code AS course_code, U.user_id as teacher_id, U.name as teacher_name, S.name as teacher_school
                         FROM course C
                         JOIN course_student CS ON CS.course_id = C.course_id
                         JOIN user U ON U.user_id = C.user_id
                         JOIN school S ON S.school_id = U.school_id
                         WHERE CS.user_id = '$user_id' ";
                $result = $this->query($sql2);
                $courseList = array();
                while($row = $result->fetch_assoc()){
                    $courseList[] = $row;
                }
                return $courseList;
            }
    }

    public function courseInfo($course_id){
            $user_id = user::authService()['user_id'];
            if(!isset($course_id) && !isset($user_id)){
                    return -1;
            }

            if(user::isTeacher() ){
                //techer
                $sql = "SELECT * FROM course WHERE course_id = '$course_id' AND user_id = '$user_id' ";
                $result = $this->query($sql);
                $row = $result->fetch_assoc();
            }else{
                //student
                $sql = "SELECT C.name as name, C.course_code as course_code, C.course_id as course_id
                        FROM course C
                        JOIN course_student CS ON CS.course_id = C.course_id
                        WHERE CS.user_id = {$user_id} AND C.course_id = '{$course_id}' ";
                $result = $this->query($sql);
                $row = $result->fetch_assoc();
            }

            $row['studentList'] = $this->courseStudentsList($row['course_id']);
            return $row;
    }

    public function courseAssignmentList($course_id = null){
            $user_id = user::authService()['user_id'];
            if(is_null($course_id)){
                    $course_id = $this->course_id;
            }
            if(!isset($course_id) && !isset($user_id)){
                    return -1;
            }

            if(user::isTeacher() ){
                $sql = "SELECT assignment_id FROM assignment WHERE course_id = '$course_id' ";
            }else{
                $sql = "SELECT assignment_id FROM assignment WHERE course_id = '{$course_id}' AND status = 'publish' ";
            }
			//echo $sql;
            $result = $this->query($sql);
            $assignment = array();
            while($row = $result->fetch_assoc()){
                    $assignment[] = assignment::assignmentInfo($row['assignment_id']);
            }
            return $assignment;
    }


}