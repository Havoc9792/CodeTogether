<?php require '../inc/config.php'; ?>

<?php $userAPI->authService(); ?>
<?php $userAPI->authRight('student'); ?>

<?php require '../inc/template_start.php'; ?>
<?php require '../inc/page_head.php'; ?>
<?php
require '../api/course.php';
$courseAPI = new course($_GET['course_id']);


?>



<!-- Page content -->
<div id="page-content">
    <!-- Courses Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-book_open"></i><?= $courseAPI->info['course_code'] ?> - <?= $courseAPI->info['name'] ?><br><small>Assignments</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><?= $template['name'] ?></li>
        <li><a href="index.php">Courses</a></li>
        <li><?= $courseAPI->info['name'] ?></li>
        <li>Assignments</li>
    </ul>
    <!-- END Courses Header -->

    <!-- Main Row -->
    <div class="row">
        <div class="col-md-8">
            <!-- Courses Content -->
            <div class="row">

	            <!-- Course Widget -->
	            <div class="widget">
	                <div class="widget-advanced">
	                    <!-- Widget Header -->
	                    <div class="widget-header text-center themed-background-dark">
	                        <div class="widget-options">
	                            <button class="btn btn-xs btn-default" data-toggle="tooltip" title="Love it!"><i class="fa fa-heart text-danger"></i></button>
	                        </div>
	                        <h3 class="widget-content-light">
	                            <?= $courseAPI->info['name'] ?><br />
	                            <small><?= $courseAPI->info['course_code'] ?></small>
	                        </h3>
	                    </div>
	                    <!-- END Widget Header -->

	                    <!-- Widget Main -->
	                    <div class="widget-main">
	                        <!-- Lessons -->
	                        <table class="table table-vcenter">
	                            <thead>
	                                <tr class="active">
	                                    <th>Assignments</th>
	                                    <th class="text-right"><small><em> assignments</em></small></th>
	                                </tr>
	                            </thead>
	                            <tbody>
                                        <?php
	                                       //echo ($courseAPI->courseAssignmentList());
                                        foreach($courseAPI->courseAssignmentList() as $assignment ):
                                        ?>
	                                <tr>
	                                    <td>
	                                    	<span style="font-size:18px;"><a href="assignment.php?assignment_id=<?= $assignment['assignment_id']  ?>"><?= $assignment['title'] ?></a></span>
	                                    	<br />
	                                    	<?= $assignment['description'] ?>
	                                    </td>
	                                    <td class="text-right">
	                                    	<?= $assignment['deadline'] ?><br />

	                                    </td>
	                                </tr>
	                                <?php
	                                endforeach;
	                                ?>
	                            </tbody>
	                        </table>
	                        <!-- END Lessons -->
	                    </div>
	                    <!-- END Widget Main -->
	                </div>
	            </div>
	            <!-- END Course Widget -->
            </div>
            <!-- END Courses Content -->
        </div><!-- END col.md-8 -->
        <div class="col-md-4">

            <!-- Most Viewed Courses Block -->
            <div class="block">
                <!-- Most Viewed Courses Title -->
                <div class="block-title">
                    <h2><strong><?= sizeof($courseAPI->info['studentList']) ?> Students</strong> Enrolled</h2>
                </div>
                <!-- END Most Viewed Courses Title -->

                <!-- Most Viewed Courses Content -->
                <div class="resize">
                <table class="table table-striped table-vcenter">
                    <tbody>
                        <?php
                        foreach($courseAPI->info['studentList'] as $student):
                        ?>
                        <tr>
                            <td>
                                <img src="../img/blankAvatar.gif" alt="avatar" class="widget-image img-circle pull-left" width="35">
                            </td>
                            <td>
                                <a href="#"><?= $student['name'] ?></a><br>
                                <small><?= $student['school_name'] ?></small>
                            </td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                      </tbody>
                </table>
                </div>
                <!-- END Most Viewed Courses Content -->
            </div>
            <!-- END Most Viewed Courses Block -->
        </div><!-- END col.md.4 -->
    </div>
    <!-- END Main Row -->
</div>
<!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>

<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

<?php include '../inc/template_scripts.php'; ?>


<?php include '../inc/template_end.php'; ?>