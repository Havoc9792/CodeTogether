<?php
$assignmentAPI = new Assignment($assignment_id);
$assignment = $assignmentAPI->info();

$course_id = $assignment['course_id'];
$courseAPI = new course($course_id);
$course = $courseAPI->info();

$group_id = $param2;
?>
<style>
#code_hierarchy
{
	position:relative;
	width:600px;
	margin:0 auto;
}

#code_hierarchy_legend
{
	height:100px;
	font-size:1.4em;
	text-align:center;
}

.bg-success:hover {
	background-color: #626c75;
	border-color: #626c75;
	cursor: pointer;
}
</style>
<script type="text/javascript">
	//gp_id = <?= $group_id ?>;
</script>
<script type="text/javascript" src="/js/data/visualization.js"></script>
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
                        	<a href="<?= $router->generate('assignment_stat', array('assignment_id' => $assignment['assignment_id']) ) ?>">Statistics</a>
                        </li>
						<li>
                        	<a href="#" class="active">Group <?= $group_id ?></a>
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
						<div class="widget-8 panel no-border bg-success no-margin widget-loader-bar" onclick = "plot_data('code')">
						  <div class="container-xs-height full-height">
							<div class="row-xs-height">
							  <div class="col-xs-height col-top">
								<div class="panel-heading top-left top-right">
								  <div class="panel-title text-black">
									<span class="font-montserrat fs-15 all-caps">Code Contribution <i class="fa fa-chevron-right"></i></span>
								  </div>
								</div>
							  </div>
							</div>
							<div class="row-xs-height">
							  <div class="col-xs-height col-top">
								<div class="p-l-20 p-t-15">
								  <h3 class="no-margin p-b-5 text-white" id="code"></h3>
								  <p class="small hint-text m-t-5">
									<span class="label  font-montserrat m-r-5">60%</span>Higher
								  </p>
								</div>
							  </div>
							</div>
						  </div>
						</div>
						<!-- END WIDGET -->
					  </div>
					</div>
					<div class="row">
					  <div class="col-md-12 m-b-10">
						<!-- START WIDGET -->
						<div class="widget-9 panel no-border bg-success no-margin widget-loader-bar" onclick = "plot_data('communication')">
						  <div class="container-xs-height full-height">
							<div class="row-xs-height">
							  <div class="col-xs-height col-top">
								<div class="panel-heading  top-left top-right">
								  <div class="panel-title text-black">
									<span class="font-montserrat fs-15 all-caps">Communication <i class="fa fa-chevron-right"></i></span>
								  </div>
								</div>
							  </div>
							</div>
							<div class="row-xs-height">
							  <div class="col-xs-height col-top">
								<div class="p-l-20 p-t-15">
								  <h3 class="no-margin p-b-5 text-white" id="communication"></h3>
								  <a href="#" class="btn-circle-arrow text-white"><i class="pg-arrow_minimize"></i></a>
								  <span class="small hint-text">65% lower than last month</span>
								</div>
							  </div>
							</div>
							  <div class="col-xs-height col-bottom">
								<div class="progress progress-small m-b-20">
								  <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
								  <div class="progress-bar progress-bar-white" data-percentage="45%" style="width: 45%;"></div>
								  <!-- END BOOTSTRAP PROGRESS -->
								</div>
							  </div>
							</div>
						  </div>
						</div>
						<!-- END WIDGET -->
					  </div>
					<div class="row">
					  <div class="col-md-12 m-b-10">
						<!-- START WIDGET -->
						<div class="widget-9 panel no-border bg-success no-margin widget-loader-bar">
						  <div class="container-xs-height full-height">
							<div class="row-xs-height">
							  <div class="col-xs-height col-top">
								<div class="panel-heading  top-left top-right">
								  <div class="panel-title text-black">
									<span class="font-montserrat fs-15 all-caps">Testcase <i class="fa fa-chevron-right"></i></span>
								  </div>
								</div>
							  </div>
							</div>
							<div class="row-xs-height">
							  <div class="col-xs-height col-top">
								<div class="p-l-20 p-t-15">
								  <h3 class="no-margin p-b-5 text-white" id="testcase">23 compilations</h3>
								  <div class="pull-left small">
									  <span>ERR</span>
									  <span class=" text-danger font-montserrat">
											<i class="fa fa-caret-up m-l-10"></i> 9%
										</span>
									</div>
									<div class="pull-left m-l-20 small">
									  <span>PASS</span>
									  <span class=" text-danger font-montserrat">
											<i class="fa fa-caret-up m-l-10"></i> 21%
										</span>
									</div>
									<div class="clearfix"></div>
								</div>
							  </div>
							</div>
							  <div class="col-xs-height col-bottom">
								<div class="progress progress-small m-b-20">
								  <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
								  <div class="progress-bar progress-bar-white" data-percentage="45%" style="width: 45%;"></div>
								  <!-- END BOOTSTRAP PROGRESS -->
								</div>
							  </div>
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
								  <h2 class="pull-left" id="title"></h2>
								  <div class="clearfix"></div>
								  <div id="code_hierarchy_legend">&nbsp;</div>
								  <div class="clearfix"></div>
								  <div id="code_hierarchy">&nbsp;</div>
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
		<!-- END PLACE PAGE CONTENT HERE -->
		</div>
		<!-- END CONTAINER FLUID -->
    </div>
   </div>
    <!-- END PAGE CONTENT -->