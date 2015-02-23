<?php
$schoolAPI = new School();
$schoolList = $schoolAPI->get(null, false);
?>

<style>
.select2-container-multi .select2-choices{border: none !important}	
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
                            <a href="<?= $router->generate('course') ?>">Course</a>
                        </li> 
                        <li>
                            <a href="#" class="active">New</a>
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
		
			<div class="row m-b-20">
				<div class="col-md-12">
					<h1>New Course</h1>									
				</div>								
			</div>
		
			<div class="row">			
				<div class="col-xs-12">				
					<div class="panel panel-default">						
						<div class="panel-body">
							<form class="" role="form">	
								<h5>
									Course Information
								</h5>
															
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group form-group-default required">
											<label>Course Name</label>
											<input type="text" class="form-control" required="">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group form-group-default required">
											<label>Course Code</label>
											<input type="text" class="form-control" required="">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group form-group-default required">
											<label>Course Description</label>
											<textarea class="form-control" style="min-height: 200px"></textarea>
										</div>
									</div>								
								</div>	
								
								<h5>
									Course Enrollment 
								</h5>
								<div class="row">
									<div class="col-sm-9">
										<div class="form-group form-group-default required">
											<label class="">Schools</label>
											<select multiple class="full-width" data-placeholder="Select Schools" data-init-plugin="select2">												
												<?php
												foreach($schoolList as $school):
												?>												
													<option value="<?= $school['id'] ?>"><?= $school['name'] ?> (<?= $school['country_name'] ?>)</option>
												<?php
												endforeach;	
												?>														
											</select>								
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group form-group-default required">
											<label class="">Access Level</label>
											<div class="checkbox check-primary checkbox-circle">
												<input type="checkbox" checked="checked" value="1" id="easy-join">
												<label for="easy-join">Easy Join</label>
											</div>		
											<div class="checkbox check-primary checkbox-circle">
												<input type="checkbox" checked="checked" value="1" id="require-login">
												<label for="require-login">Require Login</label>
											</div>																																							
										</div>										
										
									</div>		
								</div>
								
								
								<div class="row m-t-10" >
									<div class="col-xs-12">
										<button type="submit" class="btn btn-primary pull-right">Create</button>
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
    
<script src="assets/plugins/bootstrap3-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>    