<?php
require_once "compiler.php";
require_once "mysql.php";
class javacompiler extends mysql implements compiler{

	public function __construct(){
		parent::construct();
	}
	
	public function compileAndRun($code){
		$code = $_GET;
		if(isset($code)){
			$temp_folder = rand() . rand();
			$path = dirname(dirname(__DIR__)) . "/tmp/" . $temp_folder;
			echo $path;
			//mkdir($path);
		}
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
			$sqlDelete = "DELETE FROM assignment_group_code WHERE group_id = '{$group_id}'";
			$this->query($sqlDelete);
			$counter = 0;
		    
			$file = "../code/". $group_id ."";
			if(file_exists($file)){
				$this->rrmdir($file);
			}
			mkdir($file);
			mkdir($file . "/debug");
			foreach($codeArray as $code){
		    	$excapedCode = $this->escape($code);
				$sqlInsert = "INSERT INTO assignment_group_code (group_id, editor, code) VALUES ('{$group_id}','{$counter}','{code'}'";
				$this->query($sqlInsert);
				file_put_contents($file . "/".$counter.".java", $code);
				$counter++;
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