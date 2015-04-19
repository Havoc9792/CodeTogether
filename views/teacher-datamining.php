<?php
$assignmentAPI = new Assignment($assignment_id);
$assignment = $assignmentAPI->info();

$course_id = $assignment['course_id'];
$courseAPI = new course($course_id);
$course = $courseAPI->info();	
?>
<style>
.overlay2{
	position: fixed;
	background: rgba(255,255,255,0.5) url("/img/ajax-loader.gif") no-repeat no-repeat center center;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	z-index: 10000;
	display: none;
}	
</style>
<div class="overlay2"></div>

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
                        	<a href="#" class="active">Data Mining</a>
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
			
			<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">
						Testcase Data Mining
						</div>	
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group form-group-default required">
		                            <label>New Testcase Input</label>
		                            <input type="text" name="input" placeholder="" class="input-lg form-control">
	                          	</div>												
							</div>	
							<div class="col-md-4">								
		                        <a href="#" class="btn btn-primary btn-block btn-lg" style="margin-top: 6px;">Start Mining</a>	                          													
							</div>																																																				
						</div>
						<div class="row">
							<div class="col-md-12 pro">
								
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
       