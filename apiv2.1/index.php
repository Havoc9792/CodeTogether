<?php  
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 'On');

define("ROOT", dirname(__DIR__));
define("API_VERSION", "apiv2.1");

require ROOT . '/inc/AltoRouter.php';
require ROOT . '/' . API_VERSION . '/MysqliDB.php';
require ROOT . '/' . API_VERSION . '/User.php';

$db = new MysqliDb('localhost', 'kit', 'kit1234', 'fyp');
$router = new AltoRouter();
$router->setBasePath("/apiv2.1");


$router->map('POST', '/login/', 'User::login');
$router->map('POST|GET', '/logout/', 'User::logout');

//Teacher API
$router->map('POST|GET', '/compileAndRun/[i:assignment_id]/[a:inputs]/', 'Java::compileAndRun');

$router->map('POST', '/testcase/[i:assignment_id]/[save|delete:action]/[i:testcase_id]?/', 'Testcase::manage');
$router->map('GET', '/testcase/[i:assignment_id]/', 'Testcase::get');

$router->map("POST", '/assignment/[i:assignment_id]/[update|create|delete:action]/', 'Assignment::manage');

$router->map("POST", '/samplecode/[i:assignment_id]/[update|create|delete:action]/', 'SampleCode::manage');


$match = $router->match();
//var_dump($match);
if($match) {			
	list($class_name, $method) = explode('::', $match['target']);
	require_once ROOT . '/' . API_VERSION . '/' . $class_name . ".php" ;
	$c = new $class_name;			
	call_user_func_array(array($c, $method), $match['params']); 
}else{
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
	require ROOT . '/views/404.php';
}

