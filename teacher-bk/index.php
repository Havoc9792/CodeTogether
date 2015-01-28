<?php include '../inc/config.php'; ?>

<?php $userAPI->authService(); ?>
<?php $userAPI->authRight('teacher'); ?>

<?php include '../inc/template_start.php'; ?>
<?php include '../inc/page_head.php'; ?>
<?php 
include '../api/course.php'; 
$courseAPI = new course();
?>


<!-- Page content -->
<div id="page-content">
    <!-- Courses Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-book_open"></i>Welcome to <strong><?= $template['name'] ?></strong><br><small>Courses Hub!</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><?= $template['name'] ?></li>
        <li>Courses</li>        
    </ul>
    <!-- END Courses Header -->

    <!-- Main Row -->
    <div class="row">
        <div class="col-md-12">
            <!-- Courses Content -->
            <div class="row">
            
            	<?php
            	foreach($courseAPI->courseList($userAPI->authService()['user_id'] ) as $course ):
            	?>
                <!-- Course Widget -->
                <div class="col-sm-6">
                    <div class="widget">
                        <div class="widget-advanced">
                            <!-- Widget Header -->
                            <div class="widget-header text-center themed-background-dark-default">
                                <div class="widget-options">
                                    
                                </div>
                                <h3 class="widget-content-light">
                                    <a href="assignments.php?course_id=<?= $course['course_id'] ?>" class="themed-color-default"><?= $course['name'] ?></a><br>
                                    <small><?= $course['course_code'] ?></small>
                                </h3>
                            </div>
                            <!-- END Widget Header -->

                            <!-- Widget Main -->
                            <div class="widget-main">
                                <a href="assignments.php?course_id=<?= $course['course_id'] ?>" class="widget-image-container animation-fadeIn">
                                    <span class="widget-icon themed-background-default"><i class="fa fa-terminal"></i></span>                                    
                                </a>
                                <a href="assignments.php?course_id=<?= $course['course_id'] ?>" class="btn btn-sm btn-default pull-right">                                    
                                    <i class="fa fa-clock-o"></i> 
                                </a>
                                <a href="assignments.php?course_id=<?= $course['course_id'] ?>" class="btn btn-sm btn-success"><?= sizeof($course['studentList']) ?> Students</a>
                            </div>
                            <!-- END Widget Main -->
                        </div>
                    </div>
                </div>
                <!-- END Course Widget -->
                <?php
                endforeach;
                ?>
               
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


<?php include '../inc/template_end.php'; ?>