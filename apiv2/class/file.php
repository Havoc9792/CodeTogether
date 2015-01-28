<?php
require_once "mysql.php";
require_once "user.php";
class file extends mysql{

	public $basePath;	
	public $file = null;
	private $user;
	
	private $questionPath;	
	private $masterFolder = "files";
	
	public static $viewerJSSupportedExtension = ['pdf', 'odt', 'odp', 'ods'];



    public function __construct($file = null) {     
    	parent::__construct();   
        $this->basePath = dirname(dirname(dirname(__FILE__)));
        $this->user = user::authService();
        
        if(!is_null($file)){
			$this->file = $file;           
 		}          
        
        $this->questionPath = $this->basePath . "/". $this->masterFolder . "/questions/";          
    }
    
    public static function compile($path){
	    if(isset($path)){
		    $rand_dir = dirname(dirname(dirname(__FILE__))) . "/files/tmp/" . rand() . rand();		    
		    mkdir($rand_dir);		    
		    foreach(file::dirContent($path) as $file){
			    copy($path . "/" . $file, $rand_dir . "/" . $file);
			}
			$compile = shell_exec("javac $rand_dir/*.java");			
			return $rand_dir;
		}	    	    
    }
    
    public static function dirContent($path){
	    $data = array();
	    foreach(scandir($path) as $d){
		    if($d != "." || $d != ".."){
			    $data[] = $d;
		    }
	    }
	    return $data;	    
    }
    
    public function submitSampleCode($assignment_id, $samplecode){
	    mkdir($this->basePath . "/". $this->masterFolder . '/sample_code/' . $assignment_id . '/');
		$sql = "DELETE FROM assignment_sample_code WHERE assignment_id = '{$assignment_id}' ";
		$this->query($sql);				
		array_map('unlink', glob($this->basePath . "/". $this->masterFolder . '/sample_code/' . $assignment_id . '/*'));
		foreach($samplecode as $code){
			$sql = "INSERT INTO assignment_sample_code (assignment_id, code) VALUES ('{$assignment_id}', '{$code}') ";
			$this->query($sql);	
			$sample_code_id = $this->insert_id();					
			file_put_contents($this->basePath . "/". $this->masterFolder . '/sample_code/' . $assignment_id . '/' . $sample_code_id . '.java', $code);	
		}	    
	    	    	    
    }
    
    public static function getSampleCode($assignment_id, $code_id = null){
	    $path = dirname(dirname(dirname(__FILE__))) . "/files/sample_code/" . $assignment_id . "/";
	    if(is_null($code_id)){
		    $files = file::dirContent();		    
	    }
    }
    
    public function submitDrawing($group_id, $data){
	    $user_id = $this->user['user_id'];
	    $sql = "INSERT INTO drawing (group_id, user_id) VALUES ('{$group_id}', '{$user_id}')";
	    $this->query($sql);
	    $id = $this->insert_id();
	    
		$img = str_replace('data:image/png;base64,', '', $data);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);		
			
		file_put_contents($this->basePath . "/". $this->masterFolder . '/drawing/'.$id.'.jpg', $data);				
		return $id;  
    }
    
    public function submitQuestion(){		 				
    	$file = $this->file;
		if(!is_null($file) && $this->user['user_type'] == 1){		     
		    $tempFile = $file['file']['tmp_name'];          		      
		    $targetPath = $this->questionPath;
		    $filename = $file['file']['name'];	 		    	     
		    
	    	$user_id = $this->user['user_id'];
	    	$ext = pathinfo($filename, PATHINFO_EXTENSION);
		    $sql = "INSERT INTO file (filename, user_id, extension, type, type_id) VALUES ('{$filename}', {$user_id}, '{$ext}', 'question', 0)";
		    $this->query($sql);
		    		    
			$targetFile =  $targetPath . $this->insert_id() . "." . $ext;	
		    move_uploaded_file($tempFile,$targetFile);			    
		}	    
    }
    
    public function removeDuplicateQuestion(){
	    $user_id = $this->user['user_id'];
	    if($this->user['user_type'] == 1){
		    $sql = "SELECT file_id, extension FROM file WHERE user_id = {$user_id} AND type_id = 0 ";
		    $result = $this->query($sql);
		    while($row = $result->fetch_assoc()){
			    $this->removeFile($row['file_id'], $this->questionPath . $this->getFilename($row['file_id'], $row['extension']) );
		    }	    	    	    
		    return true;
	    }
    }
    
    private function removeFile($file_id, $path){
	    unlink($path);
	    $user_id = $this->user['user_id'];
	    $sql = "DELETE FROM file WHERE file_id = '{$file_id}' AND user_id = '{$user_id}' ";
	    $this->query($sql);
	    return true;
    }
    
    public function getFilename($file_id, $ext = null){
	    if(is_null($ext)){
		    $sql = "SELECT file_id, extension FROM file WHERE file_id = {$file_id}";
		    $result = $this->query($sql);
		    $row = $result->fetch_assoc();
		    return $file_id . "." . $row['extension'];
	    }else{
		    return $file_id . "." . $ext;
	    }
	    
    }
	

	

}