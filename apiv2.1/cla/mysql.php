<?php
/**
*	Universial mySQL class
*	by Mok Ka Hei
*	last revise: 14 Nov 2014
*
**/
class mysql{
    private $dbuser = "kit";
    private $dbpassword = "kit1234";
    private $dbhost = "localhost";    
    private $dbname = "fyp";
    private $db;
    
    public function __construct(){
        $this->connect();
        $this->db->set_charset("utf8");              
    }
    
    private function connect(){
        $this->db = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname) or die("Error " . mysqli_error());
    }
    
    
    public function query($query){
        $this->db->query("SET CHARACTER SET 'utf8'");
        $this->db->query("SET collation_connection = 'utf8_general_ci'");             
        if($result = $this->db->query($query)){
            return $result;
        }else{
            echo "Errormessage: \n" . $this->db->error . "\n" . $query;
            die();
        }        
    }    
    
    public function insert_id(){
	    return $this->db->insert_id;
    }
    
    public function escape($query){
        return $this->db->real_escape_string($query);
    }      
    
    
}
