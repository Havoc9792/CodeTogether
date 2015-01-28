<?php
$assignmentAPI = new assignment($assignment_id);
$course_id = $assignmentAPI->info['course_id'];
$courseAPI = new course($course_id);
$course = $courseAPI->info;	
?>

<style>
.pace{display: none !important}	
.sidebar-menu, .page-sidebar{display: none;}
.page-sidebar ~ .page-container{padding: 0}
#quickview{top: 60px; right: 0; position: absolute;}
.quickview-wrapper .nav-tabs {background-color: #FAFAFA;}
.quickview-wrapper .nav-tabs li.active a{color: #626262 !important;}
body{overflow: hidden}
.quickview-wrapper .nav-tabs{padding: 0}
.tools{position: absolute; top: 20px; left: 20px;}
textarea#testcase{border: none; padding: 10px;}
.quickview-wrapper .nav-tabs li a{}
#doc iframe{height: calc( 100% - 35px);}
.nav-tabs li a{padding: 8px 20px}
audio{max-width: 100%;}
#quickview i{font-size: 18px;}
.quickview-wrapper .nav-tabs li a{padding: 10px;}
body > .pgn-wrapper[data-position="top"]{top: 0; left: 0; z-index: 1002}
#quickview-draw .tools{
	position: absolute;
	top: 10px;
	left: 10px;
}

#quickview-draw .tools a{
	border: 1px solid black;
	height: 30px;
	line-height: 30px;
	padding: 0 10px;
	vertical-align: middle;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	color: black;
	font-weight: bold;	
}

canvas{
	background: #FFF;
	cursor: pointer;
}

canvas:active{
	cursor: crosshair;
}
</style>


<!--START QUICKVIEW -->
<div id="quickview" class="quickview-wrapper" data-pages="quickview">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li class="">
			<a href="#quickview-question" data-toggle="tab"><i class="fa fa-file-pdf-o"></i></a>
		</li>
		<li class="">
			<a href="#quickview-draw" data-toggle="tab"><i class="fa fa-pencil"></i></a>
		</li>		
		<li class="">
			<a href="#quickview-chat" data-toggle="tab"><i class="fa fa-comment-o"></i></a>
		</li>				
		<li class="">
			<a href="#quickview-history" data-toggle="tab"><i class="fa fa-history"></i></a>
		</li>				
		<li class="active">
			<a href="#quickview-console" data-toggle="tab"><i class="fa fa-code"></i></a>
		</li>
	</ul>
	
	<!-- Tab panes -->
	<div class="tab-content">
		
		
		<div class="tab-pane fade in no-padding" id="quickview-question">
			<div class="view-port clearfix" id="question">				
				<div class="view bg-white">
					<!-- BEGIN View Header !-->
					<div class="navbar navbar-default navbar-sm">
						<div class="navbar-inner">
						<?php
		                foreach($assignmentAPI->info['files'] as $file):
		                    if(in_array($file['extension'], file::$viewerJSSupportedExtension  )):
		                ?>
							
		                    <iframe id="viewer" src ="<?= $template['template_url'] ?>/js/viewerJS/#../../../files/questions/<?= $file['filepath'] ?>" width='' height='' allowfullscreen webkitallowfullscreen frameBorder="0"></iframe>
						
		                <?php
		                    endif;
		                endforeach;
		                ?> 							
						</div>
					</div>
					<!-- END View Header !-->
				</div>				
			</div>
		</div>	
		
		
		<div class="tab-pane fade in no-padding" id="quickview-draw">
			<div class="view-port clearfix" id="draw">				
				<div class="view bg-white">
					<!-- BEGIN View Header !-->
					<div class="navbar navbar-default navbar-sm">						
						<div class="navbar-inner no-padding">							
							<div class="view-heading">
								You may share drawing to groupmates								
							</div>							
						</div>									               																			
					</div>
					<!-- END View Header !-->
					<div class="relative">
						<canvas id="colors_sketch"></canvas>
		               	<div class="tools">
		               	</div>						
					</div>
				</div>				
			</div>
		</div>		
		
		<div class="tab-pane fade in no-padding" id="quickview-console">
			<div class="view-port clearfix" id="console">				
				<div class="view bg-white relative">
					<div class="navbar navbar-default navbar-sm">
						<div class="navbar-inner no-padding">							
							<div class="view-heading">
								Enter a New Line for Each Testcase								
							</div>							
						</div>
					</div>					
					<textarea id="testcase"></textarea>					
					
					
					<div class="navbar navbar-default navbar-sm" style="border-top: 1px solid #e7e7e7">						
						<div class="navbar-inner no-padding">							
							<div class="view-heading">
								Console
							</div>							
						</div>
					</div>					
			        <div id="terminal"></div>										
	
					<div class="row no-padding no-margin" style="border-radius: 0; bottom: 0; position: absolute; width: 100%">
						<a href="#" id="compile" class="btn col-xs-6 btn-primary btn-lg" style="border-radius: 0">
							<i class="fa fa-play">
							</i> Compile and Run
						</a>
						
						<a href="#" id="testcase-anly" class="btn col-xs-6 btn-intro btn-lg" style="border-radius: 0">
							<i class="fa fa-check-circle">
							</i> Test Case Analysis
						</a>						
					</div>

					<div id="testcase-anly-content" class="bg-white hidden" style="position: absolute; height: calc( 100% - 96px ); width: 100%; top: 51px; left: 0; z-index: 100">
						Test Case Analysis TO BE IMPLEMENTED
					</div>
					
					<!-- END View Header !-->
				</div>				
			</div>
		</div>				
		
		
		<div class="tab-pane fade no-padding" id="quickview-history">
			<div class="view-port clearfix" id="history">				
				<div class="view bg-white">					
					<div class="navbar navbar-default navbar-sm relative">
						<div class="navbar-inner no-padding">							
							<div class="view-heading">
								Click to Restore 								
							</div>							
						</div>
					</div>		
							                
		                                 
		                  <ul style="overflow: scroll; height: calc( 100% - 36px )">
		                    
		                  </ul>
		                
		              								
				</div>				
			</div>
		</div>
		
		
		<div class="tab-pane fade active no-padding" id="quickview-chat">
			<div class="view-port clearfix" id="chat">
				<!-- BEGIN Conversation View  !-->
				<div class="view chat-view bg-white relative clearfix">
					<!-- BEGIN Header  !-->
					<div class="navbar navbar-default">
						<div class="navbar-inner">
							<a href="javascript:;" class="link text-master inline action p-l-10" data-navigate="view" data-view-port="#chat" data-view-animation="push-parrallax">							
							</a>
							<div class="view-heading">
								Group Chat
								<div class="fs-11 hint-text">Online</div>
							</div>
							<a id="video-chat" href="#" class="link text-master inline action p-r-10 pull-right ">
								<i class="fa fa-video-camera"></i>
							</a>
						</div>
					</div>
					<!-- END Header  !-->
					<!-- BEGIN Conversation  !-->
					<div class="chat-inner" id="my-conversation">
							
											
					</div>
					<!-- BEGIN Conversation  !-->
					<!-- BEGIN Chat Input  !-->
					<div class="b-t b-grey bg-white clearfix p-l-10 p-r-10">
						<div class="row">
							<div class="col-xs-1 p-t-15 p-l-15">
								<a href="#" id="voice" class="voice text-master"><i class="fa fa-microphone"></i></a>
							</div>
							<div class="col-xs-11 no-padding">
								<input type="text" class="form-control chat-input" data-chat-input="" data-chat-conversation="#my-conversation" placeholder="Say something">
							</div>							
						</div>
					</div>
					<!-- END Chat Input  !-->
					
					<div id="video-chat-content" class="bg-white hidden relative" style="position: absolute; height: calc(100% - 51px); width: 100%; top: 51px; left: 0;">
						<?php include 'temp-videochat.php'; ?>
					</div>
				</div>
				<!-- END Conversation View  !-->
			</div>
		</div>
		
	</div>
</div>
<!-- END QUICKVIEW-->

<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content"> 
		<!-- START CONTAINER FLUID -->
		<div class="container-fluid no-padding no-margin">
		<!-- BEGIN PlACE PAGE CONTENT HERE -->
				
			<div class="row no-padding no-margin">
				
				<div id="left" class="col-lg-8 col-xs-7 no-padding no-margin">
		            
					<div class="panel no-padding no-margin">
						<ul class="nav nav-tabs nav-tabs-simple" role="tablist">
							<li>
								<a id="add-editor" class="btn" style="padding: 8px 0; min-width: 40px;"><i class="fa fa-plus"></i></a>
							</li>		
							<?php	
							$i=0;						
							foreach($assignmentAPI->info['editor'] as $editor){
								?>
								
								<li class="<?= $i==0 ? "active" : "" ?>">
									<a href="#tab<?= $editor['editor'] ?>" data-toggle="tab" role="tab">Tab <?= $i ?></a>
								</li>								
								
								<?php								
								$i++;
							}								
							?>				
						</ul>
						<div class="tab-content no-padding no-margin">							
							<?php	
							$i=0;						
							foreach($assignmentAPI->info['editor'] as $editor){
								?>
								
								<div class="tab-pane <?= $i==0 ? "active" : "fade" ?>" id="tab<?= $editor['editor'] ?>">
									<div id="editor<?= $editor['editor'] ?>" class="ace_editor"></div>
								</div>																						
								
								<?php								
								$i++;
							}								
							?>												
						</div>
					</div>	            
		            
		            					
				</div>
				
				
				<div id="right" class="col-lg-4 col-xs-5 bg-white full-height no-padding no-margin">
					
	            				
					
				</div>				
				
				
			</div>		
					
		<!-- END PLACE PAGE CONTENT HERE -->
		</div>
		<!-- END CONTAINER FLUID -->
    </div>
   </div>
    <!-- END PAGE CONTENT -->