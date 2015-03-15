<?php
$assignmentAPI = new Assignment($assignment_id);
$assignment = $assignmentAPI->info();

$course_id = $assignment['course_id'];
$courseAPI = new course($course_id);
$course = $courseAPI->info();

$group_id = $param2;
?>

<script type="text/javascript" src="/js/data/overall-data.js"></script>
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
                        	<a href="<?= $router->generate('assignment_stat', array('assignment_id' => $assignment['assignment_id']) ) ?>">Statistics</a>
                        </li>
						<li>
                        	<a href="#" class="active">Overall</a>
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
				<div class="col-md-4 col-lg-4 col-xlg-5 ">
					<div class="row">
					  <div class="col-md-12 m-b-10">
						<!-- START WIDGET -->
						<div class="selectbox">
						  <select id="selecttestcase">
							
						  </select>
						</div>
						<!-- END WIDGET -->
					  </div>
					</div>
					<div class="row" style="margin-top: 100px;">
					  <div class="col-md-12 m-b-10">
						<!-- START WIDGET -->
						<div class="widget-12 panel no-border widget-loader-circle no-margin">
						  <div class="panel-body" id="detailbox">
								<table>
									<tr>
										<td><p>Input:</p></td>
										<td><p id="input"></p></td>
									</tr>
									<tr>
										<td><p>Output:</p></td>
										<td><p id="output"></p></td>
									</tr>
									<tr>
										<td><p>Type:</p></td>
										<td><p id="type"></p></td>
									</tr>
									<tr>
										<td><p>Description:</p></td>
										<td><p id="desc"></p></td>
									</tr>
								</table>
						   </div>
						</div>
					  </div>
						<!-- END WIDGET -->
					</div>
				</div>
				<div class="col-md-9 col-lg-7 col-xlg-6 m-b-10">
					<div class="row">
					  <div class="col-md-12">
						<!-- START WIDGET -->
						<div class="widget-12 panel no-border widget-loader-circle no-margin">
						  <div class="panel-body">
							<div class="row">
							  <div class="col-xlg-12 ">
								<div class="p-l-10">
								</div>
							  </div>
							</div>
						  </div>
						<!-- END WIDGET -->
					  </div>
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