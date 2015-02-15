<?php
class User{

    public function __construct() {        
		if(session_status() == PHP_SESSION_NONE) {
		    session_start();
		}	
    }

    public function createUser($username, $name, $password, $school_id, $type){
        if(isset($username) && isset($name) && isset($password) && isset($school_id) && isset($type)){
            $sql = "INSERT INTO user (password, username, name, school_id, type) VALUES ('{$password}', '{$username}', '{$name}', '{$school_id}', '{$type}') ";
            $this->query($sql);
            return $this->insert_id();
        }
    }


    public function login(){
	    global $db;
	    
	    $email = $_POST['username'];
	    $password = $_POST['password'];
        if(isset($email) && isset($password) ):   
        	$db->where("username", $email);
        	$db->where("password", $password);
        	$result = $db->get("user");                        
            if($db->count == 0){
                echo -1;                
            }else{
                $row = $result[0];               
                $_SESSION['codeTogether']['user_id'] = $row['user_id'];
                $_SESSION['codeTogether']['user_name'] = $row['name'];
                $_SESSION['codeTogether']['user_type'] = $row['type'];
                $_SESSION['codeTogether']['school_id'] = $row['school_id'];
                $_SESSION['codeTogether']['avatar'] = $this->avatar($row['user_id']);
                
		        if($this->isTeacher() ){
			        echo "teacher";
		            //header("location: ./teacher/index.php");
		        }elseif($this->isStudent() ){
			        echo "student";
		            //header("location: ./student/index.php");
		        }                
                               
            }
        endif;
    }


    public static function logout(){
		if(session_status() == PHP_SESSION_NONE) {
		    session_start();
		}	    
        unset($_SESSION['codeTogether']);
        session_destroy();
        user::authService();
    }
    
    
    public function loginGate(){
		if(session_status() == PHP_SESSION_NONE) {
		    session_start();
		}		    
        if(isset($_SESSION['codeTogether'])){
	        header("location: /course/");
        }	    
    }    

    /**
    * Check login status
    * return $_SESSION['codeTogether']
    */
    public static function authService(){
		if(session_status() == PHP_SESSION_NONE) {
		    session_start();
		}		    
        if(!isset($_SESSION['codeTogether'])){
            header("location: /");
            die();
        }else{
            return $_SESSION['codeTogether'];
        }
    }

    public static function authRight($type){
        if($type == "student"){
            if(!user::isStudent()){
                require dirname(dirname(__DIR__)) . '/views/500.php';
                die();
            }
        }elseif($type == "teacher"){
            if(!user::isTeacher()){                
                require dirname(dirname(__DIR__)) . '/views/505.php';
                die();
            }
        }
    }

    public static function isTeacher(){
		if(session_status() == PHP_SESSION_NONE) {
		    session_start();
		}	    
        if(isset($_SESSION['codeTogether']) && $_SESSION['codeTogether']['user_type'] == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function isStudent(){
		if(session_status() == PHP_SESSION_NONE) {
		    session_start();
		}	    
        if(isset($_SESSION['codeTogether']) && $_SESSION['codeTogether']['user_type'] == 0){
            return true;
        }else{
            return false;
        }
    }
    
    public static function avatar($user_id = null){		
	    if(is_null($user_id)){
		    $user_id = User::authService()['user_id'];
	    }  
	    
	    if(file_exists(dirname(dirname(__FILE__)) . "/files/avatar/$user_id.jpg")){
		    return "/files/avatar/$user_id.jpg";
	    }else{
		    return "/files/avatar/user.jpg";
	    }
    }
    
    public function getUserInfo($id){
	    if($id == ""){
		    return false;
	    }else{
		    $sql = "SELECT * FROM user WHERE user_id = '{$id}'";
		    $result = $this->query($sql);
		    return $result->fetch_assoc();
	    }
    }

}