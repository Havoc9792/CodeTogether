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
                        	<a href="<?= $router->generate('assignment', array('assignment_id' => $assignment['assignment_id']) ) ?>" class="active"><?= $assignment['title'] ?></a>
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
				<div class="col-md-9">
					<h1><?= $assignment['title'] ?></h1>	
					<h4><?= $course['course_code'] ?> - <?= $course['name'] ?></h4>			
				</div>						
				<div class="col-md-3">
					<a href="<?= $router->generate('assignment_edit', array('assignment_id' => $assignment['assignment_id']) ) ?>" class="btn btn-lg btn-default m-t-30 pull-right">
						Edit
					</a>					
				</div>
			</div>
			
			<div class="row">									
				<div class="col-md-8">					
					
					<div class="row">						
						<div class="col-md-12">							                
							<div class="panel panel-default">
								<div class="panel-heading separator">
									<div class="panel-title">
										Description
									</div>
								</div>
								<div class="panel-body m-t-10">									
									<p><?= nl2br($assignment['description']) ?></p>
								</div>
							</div>                		
						</div>											
					</div>	
					
					<div class="row">						
						<div class="col-md-12">							                
							<div class="panel panel-default">
								<div class="panel-heading separator">
									<div class="panel-title">
										Questions
									</div>
								</div>
								<div class="panel-body m-t-10">		
									<?php							
			                        foreach($assignment['files'] as $file):
			                            if(in_array($file['extension'], file::$viewerJSSupportedExtension  )):
			                        ?>
			                            <iframe class="pdf" id="viewer" src ="/js/viewerJS/#../../../files/questions/<?= $file['filepath'] ?>" width='' height='' allowfullscreen webkitallowfullscreen frameBorder="0"></iframe>
			                        <?php
			                            endif;
			                        endforeach;
			                        ?>					                        	                        							
								</div>
							</div>                		
						</div>											
					</div>	
					
					<div class="row">						
						<div class="col-md-12">							                
							<div class="panel panel-default">
								<div class="panel-heading separator">
									<div class="panel-title">
										Sample Code
									</div>
								</div>
								<div class="panel-body m-t-10">		
									
									<ul class="nav nav-tabs nav-tabs-simple" role="tablist">												
										<?php	
										$i=0;						
										foreach($assignment['sample_code'] as $editor){
											?>
											
											<li class="<?= $i==0 ? "active" : "" ?>">
												<a href="#tab<?= $editor['sample_code_id'] ?>" data-toggle="tab" role="tab">File <?= $i ?></a>
											</li>								
											
											<?php								
											$i++;
										}								
										?>				
									</ul>
									<div class="tab-content no-padding no-margin">							
										<?php	
										$i=0;						
										foreach($assignment['sample_code'] as $editor){
											?>
											
											<div class="tab-pane <?= $i==0 ? "active" : "fade" ?>" id="tab<?= $editor['sample_code_id'] ?>">
												<div id="editor<?= $editor['sample_code_id'] ?>" class="ace_editor"><?= $editor['code'] ?></div>
											</div>																						
											
											<?php								
											$i++;
										}								
										?>	
									</div>
																							
																					                        				                        	                        							
								</div>
							</div>                		
						</div>											
					</div>																							
					
				</div>
				<div class="col-md-4">	
					

					
					<a href="<?= $router->generate('assignment_stat', array('assignment_id' => $assignment['assignment_id']) ) ?>" class="btn btn-lg btn-block btn-info m-b-10">
						Group Statistics
					</a>	
					
					<a href="<?= $router->generate('overall_stat', array('assignment_id' => $assignment['assignment_id']) ) ?>" class="btn btn-lg btn-block btn-info m-b-10">
						Overall Statistics
					</a>
					
					<a href="<?= $router->generate('assignment_edit_testcase', array('assignment_id' => $assignment['assignment_id']) ) ?>" class="btn btn-lg btn-block btn-info m-b-10">
						Testcase Management
					</a>	
					
					<a href="<?= $router->generate('data_mining', array('assignment_id' => $assignment['assignment_id']) ) ?>" class="btn btn-lg btn-block btn-info m-b-10">
						Data Mining
					</a>																													
					
					<div class="panel panel-default">
						<div class="panel-heading separator">
							<div class="panel-title">
								Information
							</div>
						</div>
						<div class="panel-body m-t-10 p-b-10" style="max-height: 300px; overflow: scroll">							
							<table class="table table-borderless table-vcenter">
		                        <tbody>
		                            <tr>
		                                <td class="text-right">Status</td>
		                                <td>
		                                    <span class="label label-<?= ($assignment['status'] == "draft") ? "warning" : "success" ?>"><?= $assignment['status'] ?></span>
		                                </td>
		                            </tr>
		                            <tr>
		                                <td class="text-right">Deadline</td>
		                                <td>
			                                <?= $assignment['deadline'] ?>
		                                </td>
		                            </tr>
		                        </tbody>
		                    </table>								                        																					
						</div>
					</div>		
								
															                
					<div class="panel panel-default">
						<div class="panel-heading separator">
							<div class="panel-title">
								Grouping (WRONG DATA!!!!)
							</div>
						</div>
						<div class="panel-body m-t-10 p-b-10" style="max-height: 300px; overflow: scroll">							
	                        <?php
	                        foreach($assignmentAPI->groupList($assignment['assignment_id']) as $group):
	                        ?>															
	                        
								<?php
					            foreach($group as $student):
					            ?>   
					            
								<div>
									<div class="profile-img-wrapper m-t-5 inline">
										<img width="35" height="35" alt="" src="<?= user::avatar($student['user_id']) ?>">
										<div class="chat-status available">
										</div>
									</div>
									<div class="inline m-l-10">
										<p class="small hint-text m-t-5"><?= $student['name'] ?>
											<br>from <?= $student['school_name'] ?>
										</p>
									</div>
								</div>						            
					                                     			                   
			                    <?php
				                endforeach;    
				                ?>		                        
	                        
							<?php
							endforeach;	
							?>																								
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