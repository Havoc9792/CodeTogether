<?php

interface ProgrammingLanguage{
	public function compile($group_id);
	public function saveCode($group_id,$codeArray);
	public function runCode($group_id,$inputs);		    
}

function rrmdir($dir){
	if(is_dir($dir)){
		$objects = scandir($dir);
		foreach ($objects as $object){
			if ($object != "." && $object != ".."){
				if (filetype($dir."/".$object) == "dir")
					rrmdir($dir."/".$object);
				else
					unlink($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}
	