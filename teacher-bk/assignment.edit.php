<?php require '../inc/config.php'; ?>

<?php $userAPI->authService(); ?>
<?php $userAPI->authRight('teacher'); ?>

<?php require '../inc/template_start.php'; ?>
<?php require'../inc/page_head.php'; ?>
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
                <i class="gi gi-book_open"></i>Edit <?= $assignmentAPI->info['title'] ?><br><small><?= $courseAPI->info['course_code'] ?> - <?= $courseAPI->info['name'] ?></small>
            </h1>             
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><?= $template['name'] ?></li>
        <li>Courses</li>
        <li><?= $courseAPI->info['name'] ?></li>
        <li><?= $assignmentAPI->info['title'] ?></li> 
        <li>Edit</li>        
    </ul>
    <!-- END Courses Header -->

    <!-- Main Row -->
    <div class="row">
        <div class="col-md-12">
            <!-- Courses Content -->
            <div class="row">
            
			    <!-- Progress Bar Wizard Block -->
			    <div class="block">
			        <!-- Progress Bars Wizard Title -->
			        <div class="block-title">
			            <h2><strong>Edit </strong><?= $assignmentAPI->info['title'] ?></h2>
			        </div>
			        <!-- END Progress Bar Wizard Title -->
			
			        <!-- Progress Bar Wizard Content -->
			        <div class="row">			            
			            <div class="col-sm-12 col-sm-offset-0">			                			
			                <!-- Progress Wizard Content -->
			                <form id="progress-wizard" action="/api/submit-assignment.php" method="post" class="form-horizontal">
			                	<input type="number" id="course-id" name="course-id" value="<?= $assignmentAPI->info['course_id'] ?>" class="hidden">
			                	<input type="number" id="assignment-id" name="assignment-id" value="<?= $assignmentAPI->info['assignment_id'] ?>" class="hidden">
			                    <!-- First Step -->
			                    <div id="progress-first" class="step">
			                    	<div class="row">
			                    		<div class="col-sm-6">
											<div class="form-group">
					                            <label class="col-md-3 control-label" for="example-username">Title</label>
					                            <div class="col-md-8">
					                                <input value="<?= $assignmentAPI->info['title'] ?>" type="text" id="title" name="title" class="form-control" placeholder="Assignemnt Title...">
					                            </div>
					                        </div>
					                        <div class="form-group">
					                            <label class="col-md-3 control-label" for="example-email">Description</label>
					                            <div class="col-md-8">
					                                <textarea id="description" name="description" class="form-control" placeholder="Short Description..."><?= $assignmentAPI->info['description'] ?></textarea>
					                            </div>
					                        </div>	
											<div class="form-group">
					                            <label class="col-md-3 control-label" for="example-username">Due Date</label>												
					                            <div class="col-md-8">
					                                <input value="<?= $assignmentAPI->info['due_date'] ?>" type="text" id="due-date" name="due-date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
					                            </div>					                        
					                        </div>
					                        <div class="form-group">
					                            <label class="col-md-3 control-label" for="example-email">Due Time</label>
					                            <div class="col-md-8">
					                                <div class="input-group bootstrap-timepicker">
					                                    <input value="<?= $assignmentAPI->info['due_time'] ?>" type="text" id="due-time" name="due-time" class="form-control input-timepicker24">
					                                    <span class="input-group-btn">
					                                        <a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a>
					                                    </span>
					                                </div>
					                            </div>
					                        </div>	
											<div class="form-group">
					                            <label class="col-md-3 control-label" for="example-email">Grouping</label>
					                            <div class="col-md-8">					                              
					                            	<input value="<?= $assignmentAPI->info['grouping'] ?>" type="number" id="grouping" name="grouping" class="form-control" placeholder="Number of students in a group...">					                                    					                                
					                            </div>
					                        </div>																                        	
											<div class="form-group">
												<label class="col-md-3 control-label">Language</label>
						                        <div class="col-md-8">
						                            <div class="radio-inline">
						                                <label for="example-radio1">
						                                    <input type="radio" id="code-type" name="code-type" value="java" checked="checked"> Java
						                                </label>
						                            </div>
						                            <div class="radio-inline">
						                                <label for="example-radio2">
						                                    <input type="radio" id="code-type" name="code-type" value="c" onclick="this.checked = false;" disabled> C/C++ (Coming Soon)
						                                </label>
						                            </div>						                            				                            						                            
						                        </div>		                        
					                        </div>						                        
																                        			                        				                        		                    		
			                    		</div>
										<div class="col-sm-6">	
											<div class="form-group">
												<label class="col-md-3 control-label" for="example-select">Status</label>
												<div class="col-md-8">
													<select id="status" name="status" class="form-control" size="1">
														<?php
														if($assignmentAPI->info['status'] == "draft"){
															$statusDraft = "selected";
														}else{
															$statusPublished = "selected";
														}
														?>
														<option value="draft" <?= $statusDraft ?>>Draft</option>
														<option value="publish" <?= $statusPublished ?>>Published</option>														
													</select>
												</div>
											</div>																										                        
					                        <div class="form-group">
					                            <label class="col-md-3 control-label" for="example-email">Questions</label>
					                            <div class="col-md-8">	
					                            	<p>
						                            	<?php
						                            	foreach($assignmentAPI->info['files'] as $file):
						                            	?>
						                            		<?php if(in_array($file['extension'], file::$viewerJSSupportedExtension  )): ?>
						                            			<a target="_blank" href="<?= $template['template_url'] ?>/js/viewerJS/#../../../files/questions/<?= $file['filepath'] ?>">
						                            				<?= $file['filename'] ?> 
						                            			</a>
						                            		<?php else: ?>
						                            			<?= $file['filename'] ?> 	
						                            		<?php endif; ?>                            		
						                            		<a href="javascript:void(0)" class="label label-danger">Delete</a>
						                            	<?php
						                            	endforeach;
						                            	?>				
					                            	</p>                            		
													<div class="dropzone"></div>						                
					                            </div>			                        
					                        </div>																                        					                        					                        		                    		
			                    							                        					                        		                    		
			                    		</div>			                    		
			                    	</div><!-- END row -->		   			                       
			                    </div>
			                    <!-- END First Step -->
			
			                    <!-- Second Step -->
			                    <div id="progress-second" class="step">
			                    	<div class="row">
										<div class="col-sm-12">																                        
					                        <div class="form-group">
					                            <label class="col-md-1 control-label" for="example-email" style="width:12.5%">Sample Code</label>
					                            <div class="col-md-10">					                            		
												    <div id="editor"><?= $assignmentAPI->info['sample_code'] ?></div>					                            
												    <textarea id="code" name="code" class="hidden"></textarea>
												</div>			                        
					                        </div>						                        		                    		
			                    		</div>				
			                    	</div><!-- END row -->                        
			                    </div>
			                    <!-- END Second Step -->	
			                    
			                    <!-- Third Step -->
			                    <div id="progress-third" class="step">
			                    	<div class="row">
										<div class="col-sm-12">																                        
					                        <div class="form-group">
					                            <label class="col-md-1 control-label" for="example-email" style="width:12.5%">Testcase</label>
					                            <div class="col-md-10">					                            		
												    <textarea name="textcase" class="form-control" style="height: 300px;"><?= $assignmentAPI->info['testcase'] ?></textarea>					                            												    
												</div>			                        
					                        </div>						                        		                    		
			                    		</div>				
			                    	</div><!-- END row -->                        
			                    </div>
			                    <!-- END Second Step -->			                    					                    
			
			                    <!-- Form Buttons -->	
			                    <div class="row">		               
			                    	<div class="col-md-10 col-md-offset-1">     
					                    <div class="form-group form-actions">
					                    	<input id="submit" type="submit" value="Save" class="form-control btn btn-primary btn-block" >
					                    </div>
			                    	</div>
			                    </div><!-- END row -->
			                    <!-- END Form Buttons -->
			                </form>
			                <!-- END Progress Wizard Content -->
			            </div>
			        </div>
			        <!-- END Progress Bar Wizard Content -->
			    </div>
			    <!-- END Progress Bar Wizard Block -->
		                	               
            </div>
            <!-- END Courses Content -->
        </div>       
    </div>
    <!-- END Main Row -->
</div>
<!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

<?php include '../inc/template_scripts.php'; ?>

<script src="<?= $template['template_url'] ?>/js/dropzone.js"></script>
<script src="<?= $template['template_url'] ?>/js/pages/formsWizard.js"></script>
<script src="<?= $template['template_url'] ?>/js/ace/ace.js"></script>
<script src="<?= $template['template_url'] ?>/js/ace/ace.java.js"></script>
<script src="<?= $template['template_url'] ?>/js/ace/ace.theme.js"></script>

<script>
	
	
	$(document).delegate('textarea', 'keydown', function(e) {
	  var keyCode = e.keyCode || e.which;
	
	  if (keyCode == 9) {
	    e.preventDefault();
	    var start = $(this).get(0).selectionStart;
	    var end = $(this).get(0).selectionEnd;
	
	    // set textarea value to: text before caret + tab + text after caret
	    $(this).val($(this).val().substring(0, start)
	                + "\t"
	                + $(this).val().substring(end));
	
	    // put caret at right position again
	    $(this).get(0).selectionStart =
	    $(this).get(0).selectionEnd = start + 1;
	  }
	});		
	
$(function(){ 
	//FormsWizard.init(); 
	$("div.dropzone").dropzone({ url: "/api/submit-questions.php" });
	
	var editor = ace.edit("editor");		   
	editor.setTheme("ace/theme/monokai");	
	editor.getSession().setMode("ace/mode/java"); 

	$("div#editor", "form").height($(window).height()*0.7).width("100%");	
	
	$("input#submit", "form").click(function(e){
		e.preventDefault();
		$("textarea#code", "form").val(editor.getSession().getValue());
		if( $("input#due-date").val() == "" || $("input#due-time").val() == "" || $("input#code").val() == "" || $("input#title").val() == "" || $("input#grouping").val() == "" ){
			$.bootstrapGrowl("Please fill in all the blanks", {type: 'danger'});
			return;
		}
		
		NProgress.start();		
		$.post("/api/submit-assignment.php?edit=true", $("form").serializeArray(), function(res){
			console.log(res);			
			if(res > 0){
				$.bootstrapGrowl("Assignment saved, you will be redirected");
				var t = setTimeout(function(){
					window.location = "/teacher/assignment.php?assignment_id=" + res;
				}, 2000);
			}else{
				$.bootstrapGrowl("Error saving assignment", {type: 'danger'});
				NProgress.stop();
			}
		});                  		
	});	
});



</script>

<?php include '../inc/template_end.php'; ?>