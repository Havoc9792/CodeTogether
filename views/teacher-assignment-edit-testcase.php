<?php
$assignmentAPI = new Assignment($assignment_id);
$assignment = $assignmentAPI->info();

$course_id = $assignment['course_id'];
$courseAPI = new course($course_id);
$course = $courseAPI->info();	
?>

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
                        	<a href="#" class="active">Edit Testcase</a>
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
				<div class="col-md-8">
					<h1><?= $assignment['title'] ?></h1>	
					<h4><?= $course['course_code'] ?> - <?= $course['name'] ?></h4>			
				</div>	
				<div class="col-md-4">					
					<a href="#" id="save-testcase" class="btn btn-default pull-right m-t-50">Save</a>
					<a href="#" id="add-testcase" class="btn btn-default pull-right m-r-10 m-t-50">Add Testcase</a>
				</div>					
			</div>
			

					
			<div class="panel panel-transparent no-padding">
            	<div class="panel-body no-padding">
					<form id="testcase" action="/apiv2/submit-assignment.php" method="post" class="">
					
					</form>	                    	
				</div>
            </div>					
										
			<div class="testcase-template" style="display: none">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">
						New Testcase
						</div>	
						<a href="#" id="delete" class="btn btn-xs btn-danger pull-right" style="padding: 0px 5px;font-size: 10.5px;height: 20px;"><i class="fa fa-times"></i></a>			               
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-5">
								<div class="form-group form-group-default required">
		                            <label>Testcase Input</label>
		                            <input type="text" name="input" placeholder="" class="input-lg form-control">
	                          	</div>												
							</div>												
							<div class="col-md-4">
								<div class="form-group form-group-default">
		                            <label>Testcase Output</label>
		                            <input type="text" name="output" placeholder="" disabled class="input-lg form-control disabled">
	                          	</div>														
							</div>
							<div class="col-md-3">												
								<div class="form-group form-group-default required">
									<label class="">Test Type</label>
									<select name="type" class="full-width" data-placeholder="Select Type" data-init-plugin="">
										<option></option>
                                    	<option value="logic">Test for Logical Error</option>
                                    	<option value="careless">Test for Careless Mistake</option>
                                    	<option value="boundary">Test for Boundary</option>						                          
									</select>													
	                          	</div>												
							</div>																				
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-default required">
		                            <label>Comment</label>
		                            <textarea name="comment" class="form-control p-t-10" style="height: 100px"></textarea>
		                            <p>Your comment will be shown to students when they failed a testcase</p>
	                          	</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								
							</div>
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