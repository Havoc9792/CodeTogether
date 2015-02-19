<?php
$assignmentAPI = new Assignment($assignment_id);
$assignment = $assignmentAPI->info();

$course_id = $assignment['course_id'];
$courseAPI = new course($course_id);
$course = $courseAPI->info();	
?>

<style>
i.delete-tab{
	position: absolute;
	top: 2px;
	right: 2px;
	color: #F55753;
	opacity: 0;
	cursor: pointer;
}

li.tab-li:hover i.delete-tab{
	opacity: 1;
}	
</style>

<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= $router->generate('course') ?>" class="">Course</a>
                        </li>
                        <li>
                        	<a href="<?= $router->generate('course_detail', array('course_id' => $course['course_id']) ) ?>" class=""><?= $course['name'] ?></a>
                        </li>
                        <li>
                        	<a href="<?= $router->generate('assignment', array('assignment_id' => $assignment['assignment_id']) ) ?>"><?= $assignment['title'] ?></a>
                        </li>  
                        <li>
                        	<a href="#" class="active">Edit</a>
                        </li>                      
                    </ul>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->  
		<!-- START CONTAINER FLUID -->
		<div class="container-fluid container-fixed-lg">
		<!-- BEGIN PlACE PAGE CONTENT HERE -->
		
		
			<div class="row">				
				<div class="col-md-12">
					<h1><?= $assignment['title'] ?></h1>	
					<h4><?= $course['course_code'] ?> - <?= $course['name'] ?></h4>			
				</div>						
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					
					<div class="panel panel-transparent">
	                	<div class="panel-body">
							<form id="form" action="/apiv2/submit-assignment.php" method="post" class="form-horizontal">
			                	<input type="number" id="course-id" name="course-id" value="<?= $assignment['course_id'] ?>" class="hidden">
			                	<input type="number" id="assignment-id" name="assignment-id" value="<?= $assignment['assignment_id'] ?>" class="hidden">
			                    <!-- First Step -->
			                    <div id="progress-first" class="step">
			                    	<div class="row">
			                    		<div class="col-sm-6">
											<div class="form-group">
					                            <label class="col-md-3 control-label" for="example-username">Title</label>
					                            <div class="col-md-8">
					                                <input value="<?= $assignment['title'] ?>" type="text" id="title" name="title" class="form-control" placeholder="Assignemnt Title...">
					                            </div>
					                        </div>
					                        <div class="form-group">
					                            <label class="col-md-3 control-label" for="example-email">Description</label>
					                            <div class="col-md-8">
					                                <textarea id="description" name="description" class="form-control" placeholder="Short Description..." style="height: 300px"><?= $assignment['description'] ?></textarea>
					                            </div>
					                        </div>	
											<div class="form-group">
					                            <label class="col-md-3 control-label" for="example-username">Due Date</label>												
					                            <div class="col-md-8">
					                                <input value="<?= $assignment['due_date'] ?>" type="text" id="due-date" name="due-date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
					                            </div>					                        
					                        </div>
					                        <div class="form-group">
					                            <label class="col-md-3 control-label" for="example-email">Due Time</label>
					                            <div class="col-md-8">
					                                <div class="input-group bootstrap-timepicker">
					                                    <input value="<?= $assignment['due_time'] ?>" type="text" id="due-time" name="due-time" class="form-control input-timepicker24">
					                                    <span class="input-group-btn">
					                                        <a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-clock-o"></i></a>
					                                    </span>
					                                </div>
					                            </div>
					                        </div>	
															                        
																                        			                        				                        		                    		
			                    		</div>
										<div class="col-sm-5 col-sm-offset-1">	
											<div class="form-group">
												<label class="col-md-3 control-label" for="example-select">Status</label>
												<div class="col-md-8">
													<select id="status" name="status" class="form-control" size="1">
														<?php
														if($assignment['status'] == "draft"){
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
					                            <label class="col-md-3 control-label" for="example-email">Grouping</label>
					                            <div class="col-md-8">					                              
					                            	<input value="<?= $assignment['grouping'] ?>" type="number" id="grouping" name="grouping" class="form-control" placeholder="Number of students in a group...">					                                    					                                
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
																																				                        
					                        <div class="form-group">
					                            <label class="col-md-3 control-label" for="example-email">Questions</label>
					                            <div class="col-md-8">	
					                            	<p>
						                            	<?php
						                            	foreach($assignment['files'] as $file):
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
													<div action="/apiv2/submit-questions.php" class="dropzone"></div>					                
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

													<ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist">												
														<li>
															<a id="add-editor" class="btn" style=""><i class="fa fa-plus"></i></a>
														</li>														
														<?php	
														$i=0;						
														foreach($assignment['sample_code'] as $editor){
															?>
															
															<li class="tab-li <?= $i==0 ? "active" : "" ?>">
																<a href="#tab<?= $editor['editor'] ?>" data-toggle="tab" role="tab">File <?= $i ?></a>
																<i data-id="<?= $editor['editor'] ?>" class="delete-tab fa fa-minus-circle"></i>
															</li>								
															
															<?php								
															$i++;
														}								
														?>				
													</ul>
													<div class="tab-content no-padding no-margin bg-white">							
														<?php	
														$i=0;						
														foreach($assignment['sample_code'] as $editor){
															?>
															
															<div class="tab-pane <?= $i==0 ? "active" : "fade" ?>" id="tab<?= $editor['editor'] ?>">
																<div id="editor<?= $editor['editor'] ?>" class="ace_editor"><?= $editor['code'] ?></div>
															</div>																						
															
															<?php								
															$i++;
														}								
														?>	
													</div>

												</div>			                        
					                        </div>						                        		                    		
			                    		</div>				
			                    	</div><!-- END row -->                        
			                    </div>
			                    <!-- END Second Step -->				                    			    			                    			  			                    			                    					                    
			
			                    <!-- Form Buttons -->	
			                    <div class="row">		               
			                    	<div class="col-md-12 col-md-offset-0">     					                    
					                    <input id="submit" type="submit" value="Save" class="btn btn-lg btn-primary btn-block" >					                    
			                    	</div>
			                    </div><!-- END row -->
			                    <!-- END Form Buttons -->
			                    
								<div class="row m-t-15">
									<div class="col-xs-12">
										<a href="#" id="delete-assignment" class="btn btn-block btn-danger">
											Delete Assignment
										</a>				
									</div>
								</div>			                    
			                </form>	                    	
						</div>
	                </div>					
										
				</div>
			</div>
											
		<!-- END PLACE PAGE CONTENT HERE -->
		</div>
		<!-- END CONTAINER FLUID -->
    </div>
   </div>
    <!-- END PAGE CONTENT -->