
require "class/assignment.php";

$group_id = $_POST['group_id'];
$assignmentAPI = new assignment();
echo $assignmentAPI->runAgainstTestCase($group_id);