<?php require '../inc/config.php'; ?>

<?php $userAPI->authService(); ?>
<?php $userAPI->authRight('teacher'); ?>

<?php require '../inc/template_start.php'; ?>
<?php require '../inc/page_head.php'; ?>
<?php 
require_once '../api/course.php'; 
require_once '../api/assignment.php'; 
require_once '../api/file.php';
$assignmentAPI = new assignment($_GET['assignment_id']);
$courseAPI = new course($assignmentAPI->info['course_id']);
?>

<!-- Page content -->
<div id="page-content">
    <!-- Courses Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-book_open"></i><?= $courseAPI->info['course_code'] ?> - <?= $courseAPI->info['name'] ?><br><small><?= $assignmentAPI->info['title'] ?></small>
            </h1>             
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><?= $template['name'] ?></li>
        <li>Courses</li>
        <li><?= $courseAPI->info['name'] ?></li>
        <li><?= $assignmentAPI->info['title'] ?></li>        
    </ul>
    <!-- END Courses Header -->

    <!-- Main Row -->
    <div class="row">
        <div class="col-md-8">
            <!-- Course Widget -->
            <div class="widget">
                <div class="widget-advanced">
                    <!-- Widget Header -->
                    <div class="widget-header text-center themed-background-dark">
                        <div class="widget-options">
                            <button class="btn btn-xs btn-default" data-toggle="tooltip" title="Love it!"><i class="fa fa-heart text-danger"></i></button>
                        </div>
                        <h3 class="widget-content-light">
                            <a href="page_ready_elearning_course_lessons.php"><?= $assignmentAPI->info['title'] ?></a><br>
                            <small><?= $courseAPI->info['course_code'] ?> - <?= $courseAPI->info['name'] ?></small>
                        </h3>
                    </div>
                    <!-- END Widget Header -->

                    <!-- Widget Main -->
                    <div class="widget-main">                        
                        <!-- Lesson Content -->
                        <h3 class="sub-header">Description</h3>
                        <p><?= nl2br($assignmentAPI->info['description']) ?></p>
                                               
                        
                        <h3 class="sub-header">Questions</h3>
                        <?php
                        foreach($assignmentAPI->info['files'] as $file):
                        	if(in_array($file['extension'], file::$viewerJSSupportedExtension  )):
                        ?>
                                    <iframe id="viewer" src ="<?= $template['template_url'] ?>/js/viewerJS/#../../../files/questions/<?= $file['filepath'] ?>" width='' height='' allowfullscreen webkitallowfullscreen frameBorder="0"></iframe>                        
                        <?php
                        	endif;
                        endforeach;
                        ?>
                        
                        <h3 class="sub-header">Sample Code</h3>                        
                        <div id="editor"><?= $assignmentAPI->info['sample_code'] ?></div>

                        <h3 class="sub-header">Testcase</h3>                        
                        <p>
	                        <?php
		                    $i=1;
	                        $testcases = nl2br($assignmentAPI->info['testcase']);
	                        foreach(explode("<br />", $testcases) as $t){
		                        echo "Testcase $i: " . $t . "<br />";
		                        $i++;
		                    }
	                        ?>
	                    </p>                        
                       
                        <!-- END Lesson Content -->
                    </div>
                    <!-- END Widget Main -->
                </div>
            </div>
            <!-- END Course Widget -->
        </div>
        <div class="col-md-4">
            <!-- About Block -->
            <div class="block">
                <!-- About Content -->
                <div class="block-section">
                    <a href="/teacher/assignment.edit.php?assignment_id=<?= $assignmentAPI->info['assignment_id'] ?>" class="btn btn-lg btn-default btn-block"><i class="fa fa-gear"></i> Edit Assignment</a>
					<a id="delete" class="btn btn-lg btn-danger btn-block"><i class="fa fa-trash"></i> Delete Assignment</a>
                
                </div>
                <!-- END About Content -->
            </div>
            <!-- END About Block -->            

            <!-- Your Account Block -->
            <div class="block">
                <!-- Your Account Title -->
                <div class="block-title">                   
                    <h2><strong>Assignment</strong> Status</h2>
                </div>
                <!-- END Your Account Title -->
                <!-- Your Account Content -->
                <div class="block-section">
                    <table class="table table-borderless table-striped table-vcenter">
                        <tbody>                            
                            <tr>
                                <td class="text-right">Status</td>
                                <td>
                                    <a href="javascript:void(0)" class="label label-<?= ($assignmentAPI->info['status'] == "draft") ? "warning" : "primary" ?>"><?= $assignmentAPI->info['status'] ?></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Deadline</td>
                                <td>
	                                <?= $assignmentAPI->info['deadline'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Grouping</td>
                                <td>
	                                <?= $assignmentAPI->info['group_count'] ?>
                                </td>
                            </tr>  
                            <tr>
                                <td class="text-right">Submission</td>
                                <td>
	                                0 / <?= $assignmentAPI->info['group_count'] ?>
	                            </td>
                            </tr>                                                      
                        </tbody>
                    </table>
                </div>
                <!-- END Your Account Content -->
            </div>
            <!-- END Your Account Block -->

            <!-- Most Viewed Courses Block -->
            <div class="block">
                <!-- Most Viewed Courses Title -->
                <div class="block-title">
                    <h2><strong>Students'</strong> Grouping</h2>
                </div>
                <!-- END Most Viewed Courses Title -->

                <!-- Most Viewed Courses Content -->
		        <table class="table table-striped table-vcenter">
		            <tbody>
                        <?php	                       
                        foreach($assignmentAPI->groupList($assignmentAPI->info['assignment_id']) as $group):
                        ?>
		                <ul style="list-style: none">
			                <?php
				            foreach($group as $student):
				            ?>                            
		                    <li>
                                <?= $student['name'] ?>
		                        
		                    </li>	
		                    <?php
			                endforeach;    
			                ?>		                   
		                </ul>  
		                <hr>                                   
                        <?php
                        endforeach;
                        ?>
		              </tbody>
		        </table>                
                <!-- END Most Viewed Courses Content -->
            </div>
            <!-- END Most Viewed Courses Block -->
        </div>
    </div>
    <!-- END Main Row -->
</div>
<!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

<?php include '../inc/template_scripts.php'; ?>
<script src="<?= $template['template_url'] ?>/js/ace/ace.js"></script>
<script src="<?= $template['template_url'] ?>/js/ace/ace.java.js"></script>
<script src="<?= $template['template_url'] ?>/js/ace/ace.theme.js"></script>
<script>
$(function(){
	
	var assignment_id = <?= $assignmentAPI->info['assignment_id'] ?>;
	var course_id = <?= $courseAPI->info['course_id'] ?>;

	var editor = ace.edit("editor");		   
	editor.setTheme("ace/theme/monokai");	
	editor.getSession().setMode("ace/mode/java"); 
	var editor_div = document.getElementById('editor');
	var doc = editor.getSession().getDocument()
    editor_div.style.height = 16 * doc.getLength() + 'px';
    editor.textInput.getElement().disabled = true;
    editor.resize();    
//	$("div#editor").height($(window).height()*0.7).width("100%");

	$("iframe").height($(window).height() * 0.7).width("100%");
	
	$("a#delete").click(function(){		
		if(confirm("Are you sure to delete this assignment?")){
			NProgress.start();
			$.post("/api/delete-assignment.php", {assignment_id: assignment_id}, function(res){
				if(res == 1){
					$.bootstrapGrowl("Assignment deleted, you will be redirected");
					var t = setTimeout(function(){
						window.location = "/teacher/assignments.php?course_id="+course_id;
					}, 2000);					
				}else{
					$.bootstrapGrowl("Error deleting assignment", {type: 'danger'});
					NProgress.stop();					
				}
			});
		}
	});
});
</script>


<?php include '../inc/template_end.php'; ?>