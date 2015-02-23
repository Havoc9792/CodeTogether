

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
                            <p><a href="<?= $router->generate('course') ?>" class="active">Courses</a></p>
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
				foreach($courseAPI->courseList() as $course ):	
				?>
				<div class="col-md-6 sm-no-padding course">
					<div class="panel panel-transparent">
						<div class="panel-body no-padding">
																																											
							<a href="<?= $router->generate('course_detail', array('course_id' => $course['course_id']) ) ?>" style="color: inherit">
								<div id="portlet-advance" class="panel panel-default">
									
									<div class="panel-heading separator">
										<div class="panel-title">
											<?= $course['course_code'] ?>
										</div>
									</div>			
									
									<div class="panel-body elastic" style="height: 166px; overflow: hidden">
																															
										<h3>
											<span class="semi-bold"></span> <?= $course['name'] ?>
										</h3>
										
										<div class="">
											<div class="col-xs-6 no-padding">
												<p style="height: 60px; overflow: hidden">
													<?= limit_words($course['description'], 20) ?>
												</p>													
											</div>
											<div class="col-xs-6" style="overflow: hidden">
												<div class="">									
												<?php
												foreach($course['teacher'] as $teacher):	
												?>
												<div class="row">
													<div class="profile-img-wrapper m-t-5 inline">
														<img width="35" height="35" alt="" src="<?= user::avatar($teacher['teacher_id']) ?>">
														<div class="chat-status available">
														</div>
													</div>											
													<div class="inline m-l-10">
														<p class="small hint-text m-t-5"><?= $teacher['teacher_name'] ?>
															<br>from <?= $teacher['teacher_school'] ?>
														</p>
													</div>																						
												</div>
												<?php
												endforeach;	
												?>
												</div>
																						
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