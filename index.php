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
//require $root . '/' . $api_folder . '/class/user.php';
$router = new AltoRouter();
//$user = new User();

//$router->setBasePath("/");

//Login Page
$router->map('GET', '/', 'View::render#Login', 'login');

//Course
$router->map('GET', '/course/', 'View::render#Course', 'course');
$router->map('GET', '/course/[i:course_id]/', 'View::render#Course_Detail', 'course_detail');
$router->map('GET', '/course/add/', 'View::render#Course_New', 'course_new');
$router->map('GET', '/questionbank/', 'View::render#Question_Bank', 'questionbank');
$router->map('GET', '/assignment/[i:assignment_id]/', 'View::render#Assignment', 'assignment');

//Teacher Assignment
$router->map('GET', '/assignment/add/[i:course_id]/', 'View::render#Assignment_New', 'assignment_new');
$router->map('GET', '/assignment/edit/[i:assignment_id]/', 'View::render#Assignment_Edit', 'assignment_edit');
$router->map('GET', '/assignment/edit/testcase/[i:assignment_id]/', 'View::render#Assignment_Testcase_Edit', 'assignment_edit_testcase');

$router->map('GET', '/statistics/[i:assignment_id]/', 'View::render#Assignment_Statistics', 'assignment_stat');
$router->map('GET', '/statistics/[i:assignment_id]/group/[i:group_id]/', 'View::render#Assignment_Group_Statistics', 'assignment_group_stat');

//Assignment Do
$router->map('GET', '/assignment/do/[i:assignment_id]/', 'View::render#Assignment_Do', 'assignment_do');


//Drawing
$router->map('GET', '/drawing/[i:drawing_id]/', 'View::drawing', 'drawing');




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
	require_once ROOT . '/' . API_VERSION . '/User.php';	
	
	$user = new User();
	$db = new MysqliDb('localhost', 'kit', 'kit1234', 'fyp');
	
	list($class_name, $method) = explode('::', $match['target']);	
		
	require_once ROOT . '/' . API_VERSION . '/' . $class_name . ".php" ;
	$c = new $class_name;
	
	if(strpos($method, '#') !== false){
		list($method_name, $input) = explode('#', $method);				
		array_unshift($match['params'], $input);	
		call_user_func_array(array($c, $method_name), $match['params']);		
	}else{
		call_user_func_array(array($c, $method), $match['params']);
	}
 	
}else{
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
	require __DIR__ . '/views/404.php';
}

