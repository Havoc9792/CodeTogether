<?php
require_once "mysql.php";
class user extends mysql{

    public $basePath;

    public function __construct() {
        parent::__construct();
		if(session_status() == PHP_SESSION_NONE) {
		    session_start();
		}	
        $this->basePath = dirname(__FILE__);
        $this->rootPath = dirname(dirname(__FILE__));
    }

    public function createUser($username, $name, $password, $school_id, $type){
        if(isset($username) && isset($name) && isset($password) && isset($school_id) && isset($type)){
            $sql = "INSERT INTO user (password, username, name, school_id, type) VALUES ('{$password}', '{$username}', '{$name}', '{$school_id}', '{$type}') ";
            $this->query($sql);
            return $this->insert_id();
        }
    }

    /**
    * Login function ($email, $password)
    * return success
    *		array(1, array(user_info))
    *  return fail
    *		array(-1, info)
    */
    public function login($email, $password){
        if(isset($email) && isset($password) ):
            $email = $this->escape($email);
            $password = $this->escape($password);
            $sql = "SELECT user_id, type, school_id, name FROM user WHERE username = '{$email}' AND password = '{$password}' ";
            $result = $this->query($sql);
            if($result->num_rows == 0){
                return -1;
                //return array(-1, "Incorrect Username or Password");
            }else{
                $row = $result->fetch_assoc();
                $_SESSION['codeTogether']['user_id'] = $row['user_id'];
                $_SESSION['codeTogether']['user_name'] = $row['name'];
                $_SESSION['codeTogether']['user_type'] = $row['type'];
                $_SESSION['codeTogether']['school_id'] = $row['school_id'];
                $_SESSION['codeTogether']['avatar'] = $this->avatar($row['user_id']);
                $this->loginForward();
                //return array(1, array($row['user_id'], $row['type'], $row['school_id']) );
            }
        endif;
    }

    public function loginForward(){
        if($this->isTeacher() ){
	        return "teacher";
            //header("location: ./teacher/index.php");
        }elseif($this->isStudent() ){
	        return "student";
            //header("location: ./student/index.php");
        }
        die();
    }

    /**
    * Logout function
    * return redirection to url
    */
    public static function logout(){
		if(session_status() == PHP_SESSION_NONE) {
		    session_start();
		}	    
        unset($_SESSION['codeTogether']);
        session_destroy();
        user::authService();
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
		    $user_id = user::authService()['user_id'];
	    }    
	    if(file_exists(dirname(dirname(dirname(__FILE__))) . "/files/avatar/$user_id.jpg")){
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