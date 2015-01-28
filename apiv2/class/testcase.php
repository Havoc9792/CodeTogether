<?php
require_once "mysql.php";
require_once "user.php";
/**
 * assignment class.
 *
 * @extends mysql
 */
class testcase extends mysql{

	public $basePath;
	
	private $course_id;
	private $assignment_id;

    /**
     * __construct function.
     *
     * @access public
     * @param mixed $assignment_id
     * @return void
     */
    public function __construct($assignment_id) {
        parent::__construct();
        $this->basePath = dirname(__FILE__);
        $this->assignment_id = $assignment_id;        
    }
    
    public function getSampleCode($assignment_id = null){
		if(is_null($assignment_id)){
			$assignment_id = $this->assignment_id;
		}
		$sql = "SELECT sample_code FROM assignment WHERE assignment_id = '{$assignment_id}' ";		
		$result = $this->query($sql);		  
		$row = $result->fetch_assoc();
		return $row['sample_code'];
    }

	public function submitTestcase($input, $output, $type, $comment){
		if(isset($input) && isset($output) && isset($type) && isset($comment)){
			$assignment_id = $this->assignment_id;
			$sql = "INSERT INTO assignment_testcase (assignment_id, input, output, comment) VALUES ('{$assignment_id}', '{$input}', '{$output}', '{$comment}')";
			$this->query($sql);
			return true;
		}
	}
	
	public function getTestcaseOutput($assignment_id = null){
		if(is_null($assignment_id)){
			$assignment_id = $this->assignment_id;
		}
		$code = $this->getSampleCode();
		
	}
}