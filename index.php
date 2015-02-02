<?php  
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 'On');

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}


$api_folder = "apiv2";
$root = dirname(__FILE__);
require $root . "/inc/config.php";
require $root . '/inc/AltoRouter.php';
require $root . '/' . $api_folder . '/class/user.php';
$router = new AltoRouter();
$user = new User();

//$router->setBasePath("/");

//Login Page
$router->map('GET', '/', 'View::render#Login', 'login');

//Course
$router->map('GET', '/course/', 'View::render#Course', 'course');
$router->map('GET', '/course/[i:course_id]/', 'View::render#Course_Detail', 'course_detail');
$router->map('GET', '/assignment/[i:assignment_id]/', 'View::render#Assignment', 'assignment');

//Teacher Assignment
$router->map('GET', '/assignment/add/[i:course_id]/', 'View::render#Assignment_New', 'assignment_new');
$router->map('GET', '/assignment/edit/[i:assignment_id]/', 'View::render#Assignment_Edit', 'assignment_edit');
$router->map('GET', '/assignment/edit/testcase/[i:assignment_id]/', 'View::render#Assignment_Testcase_Edit', 'assignment_edit_testcase');

$router->map('GET', '/statistics/[i:assignment_id]/', 'View::render#Assignment_Statistics', 'assignment_stat');
$router->map('GET', '/statistics/[i:assignment_id]/group/[i:group_id]/', 'View::render#Assignment_Group_Statistics', 'assignment_group_stat');

//Assignment Do Page
$router->map('GET', '/assignment/do/[i:assignment_id]/', function($assignment_id){
	global $api_folder, $config, $router;
	user::authService();
	user::authRight('student');
	
	$config['assignment_do'] = true;
	$config['pagename'] = "Do Assignment";	
	require __DIR__ . '/' . $api_folder . '/class/course.php';	
	$courseAPI = new course();
	
	require __DIR__ . '/views/header.php';
		
	
	if(user::isStudent()){		
		require __DIR__ . '/views/student-assignment-do.php';
	}
	
	require __DIR__ . '/views/footer.php';
	
}, 'assignment_do');



//Drawing
$router->map('GET', '/drawing/[i:drawing_id]/', function($drawing_id){
	global $api_folder, $config, $router;
	user::authService();				
	require __DIR__ . '/' . $api_folder . '/get-drawing-jpg.php';	
}, 'drawing');


//Teacher Assignment Statistic


//Teacher Assignment Group Statistic







$match = $router->match();


if($match && is_callable( $match['target'] ) ) {
	
		?>
		<p style="position: fixed; bottom: 0; left: 10px; z-index: 10000; background: #FFF; color: blue; font-size: 20px">This page is currently using <b>OLD</b> apiv2 (msg from Hei)</p>
		<?php		
	call_user_func_array( $match['target'], $match['params'] ); 
	
}elseif($match){
	//New Routering for APIv2.1
	
	define("ROOT", __DIR__);
	define("API_VERSION", "apiv2.1");	
	
	require_once ROOT . '/inc/AltoRouter.php';
	require_once ROOT . '/' . API_VERSION . '/MysqliDB.php';
	//require_once ROOT . '/' . API_VERSION . '/User.php';	
	
	$db = new MysqliDb('localhost', 'kit', 'kit1234', 'fyp');
	
	list($class_name, $method) = explode('::', $match['target']);
	list($method_name, $input) = explode('#', $method);
	
	require_once ROOT . '/' . API_VERSION . '/' . $class_name . ".php" ;
	$c = new $class_name;
				
	array_unshift($match['params'], $input);
	
	call_user_func_array(array($c, $method_name), $match['params']); 	
}else{
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
	require __DIR__ . '/views/404.php';
}

