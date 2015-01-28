<?php
require_once "ProgrammingLanguage.php";

class Java implements ProgrammingLanguage{

	public function __construct(){
		
	}
	
	public function compileAndRun($assignment_id, $inputs){
		global $db;
		
		//Create Temp Folder
		$temp_folder = rand() . rand();
		$temp_folder = "123";		
		
		$path = ROOT . "/tmp/" . $temp_folder;	
		rrmdir($path);										
		mkdir($path);
		
		//Get Sample Code from DB
		$db->where('assignment_id', $assignment_id);
		$result = $db->get('assignment_sample_code');
		
		//Save Sample Code to Temp Folder
		$i=0;
		foreach($result as $code){
			$code = $code['code'];
			file_put_contents($path . "/" . $i . ".java", $code);
			$i++;	
		}	
		
		//Compile Sample Code
		$compile = shell_exec("javac $path/*.java 2> $path/compile_log.txt");
		$compileLog = file_get_contents("$path/compile_log.txt");	
		if($compileLog != ""){
			echo json_encode(array('result' => 'compile-error', 'content' => $compileLog));
			return;
		}
		
		//Find out main Class
		file_put_contents($path . "/input.txt", $inputs);
		$command = "sh " . ROOT . "/inc/findMainClass.sh $path";
		$output = shell_exec($command);
		$output = explode("@@@@@@@@@@", $output);
		$output = $output[1];
		if($output == ""){
			echo json_encode(array('result' => 'runtime-error', 'content' => "Cannot find main class"));
			return;
		}
		$output = explode("/", $output);
		$mainClass = $output[sizeof($output)-1];
		
		//Run Sample Code
		$commandRun = "sh " . ROOT . "/inc/runJava.sh '$mainClass' '$path' ";
		$run = shell_exec($commandRun);

		//Check Runtime Error
		$runtime = file_get_contents($path . "/runtime.txt");
		if($runtime != ""){
			echo json_encode(array('result' => 'runtime-error','content' => $runtime));	
			die();
		}
		
		//Display Output	
		$output = file_get_contents($path . "/output.txt");	
		echo json_encode(array('result' => "success", 'content' => $output));			
		
		rrmdir($path);
		
	}

	public function compile($group_id){
	    if(isset($group_id)){
		    $file = "../code/". $group_id ."";
			if(count(glob($file . "/*.java")) > 0){
				$compile = shell_exec("javac $file/*.java 2> $file/debug/compile.txt");
				$compileLog = file_get_contents("$file/debug/compile.txt");
				return $compileLog;
			}
	    }
	}
	public function saveCode($group_id,$codeArray){
	    if(isset($group_id) && isset($codeArray) ){
			$file = "../code/". $group_id ."";
			if(file_exists($file)){
				$this->rrmdir($file);
			}
			mkdir($file);
			mkdir($file . "/debug");	    
		    foreach($codeArray as $editor_id => $code){
		    	$excapedCode = $this->escape($code);
		    	$sql = "UPDATE assignment_group_code SET code = '{$excapedCode}' WHERE editor = '{$editor_id}'";
				$this->query($sql);
				if($code !="")
					file_put_contents($file . "/".$editor_id.".java", $code);	
		    }
			$this->makeFileHistory($group_id, $codeArray);
			return $this->compile($group_id);
		}
	}
	public function runCode($group_id,$inputs){
		$path = "/var/www/html2/code";

		$folder = "/var/www/html2/code/".$_POST['group_id'];
		file_put_contents($folder . "/input.txt", $inputs);
		$command = "sh $path/mainClass.sh $folder";
		$output = shell_exec($command);
		$output = explode("@@@@@@@@@@", $output);
		$output = $output[1];
		if($output == ""){
			echo "Error: Cannot find Java Main Class<br />";
		}

		$output = explode("/", $output);
		$output = $output[sizeof($output)-1];

		$commandRun = "sh $path/java.sh '$output' '$folder' ";
		$run = shell_exec($commandRun);

		if(file_get_contents($folder."/debug/runtime.txt") !=""){
			$result = 1;
		}else{
			$result = 0;
		}
		$content = file_get_contents($folder."/output.txt");
		echo json_encode(array('resultType' => $result,'content' => $content));
	}
}