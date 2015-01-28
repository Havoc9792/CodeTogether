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
                        	<a href="#" class="active">Statistics</a>
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
			
				<?php
				foreach($assignmentAPI->groupList($assignment['assignment_id']) as $group ):	
				?>
				
				<div class="col-md-4 sm-no-padding">
					<div class="panel panel-transparent">
						<div class="panel-body no-padding">
							<a href="<?= $router->generate('assignment_group_stat', array('group_id' => $group[0]['group_id'], 'assignment_id' => $assignment['assignment_id'] ) ) ?>" style="color: inherit">
								<div id="portlet-advance" class="panel panel-default">				
									<div class="panel-body">
										<h3>
											<span class="semi-bold">GROUP <?= $group[0]['group_id'] ?></span>
										</h3>
										<div>
											<div class="inline m-l-10">
												<?php
												foreach($group as $student):
												?>   
													<p class="small hint-text m-t-5">
														<?= $student['name'] ?><br>
													</p>
												<?php
												endforeach;    
												?>	
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>	                 
				</div>
				<?php
				endforeach;	
				?>
				
			</div>
		
		
		<!-- END PLACE PAGE CONTENT HERE -->
		</div>
		<!-- END CONTAINER FLUID -->
    </div>
   </div>
    <!-- END PAGE CONTENT -->