
<li class="m-t-30">
    <a href="#">
        <span class="title">Courses</span>
        <span class=" arrow"></span>
    </a>
    <span class="icon-thumbnail "><i class="fa fa-graduation-cap"></i>
    </span>
    <ul class="sub-menu">
        <li class="">
            <a href="<?= $router->generate('course') ?>">Course List</a>
            <span class="icon-thumbnail">LI</span>
        </li>	        
        <?php
	    foreach($courseAPI->courseList() as $course ):    
	    ?>
        <li class="">
            <a href="<?= $router->generate('course_detail', array("course_id" => $course['course_id'] )) ?>"><?= $course['name'] ?></a>
            <span class="icon-thumbnail"><?= mb_substr($course['course_code'], 0, 2) ?></span>
        </li>
        <?php
        endforeach;  
        ?>            
    </ul>        
</li>