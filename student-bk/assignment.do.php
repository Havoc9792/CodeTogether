<?php require '../inc/config.php'; ?>

<?php $userAPI->authService(); ?>
<?php $userAPI->authRight('student'); ?>

<?php $primary_nav = $app_nav; ?>
<?php $template['sidebar'] = "sidebar-mini sidebar-visible-lg-mini" ?>
<?php $is_editor = true; ?>

<?php require '../inc/template_start.php'; ?>
<?php require '../inc/page_head.php'; ?>
<?php
require_once '../api/course.php';
require_once '../api/assignment.php';
require_once '../api/file.php';
$assignmentAPI = new assignment($_GET['assignment_id']);
$courseAPI = new course($assignmentAPI->info['course_id']);
?>

<style>
body{overflow: hidden;}	
#loader{display: block;}
</style>


<!-- Page content -->
<div id="page-content" ng-app="code">
    <!-- Courses Header -->
    <ul class="breadcrumb breadcrumb-top">
        <li><?= $template['name'] ?></li>
        <li>Courses</li>
        <li><?= $courseAPI->info['name'] ?></li>
        <li><?= $assignmentAPI->info['title'] ?></li>
        <li id="file-history" class="pull-right" style="list-style: none;"><a href="#">Code History</a></li>
    </ul>
    <!-- END Courses Header -->

    <!-- Main Row -->
    <div class="row">
        <div class="col-sm-8">
            <div id="editor-wrapper" class="">
                <div id="editor"><textarea style="display: none"></textarea></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div id="terminal-wrapper" class="module">
                <div id="terminal"><textarea style="display: none"></textarea></div>
            </div>
            
            <div id="testcase-wrapper" class="module">
               	<textarea id="input"></textarea>
                <div id="output"><textarea style="display: none"></textarea></div>
            </div> 
            
            <div id="drawing-wrapper" class="module" style="width: calc(100% + 14px);">	            
               	<canvas id="colors_sketch"></canvas>
               	<div class="tools">
               	</div>
            </div>                        
            
            <div id="questions-wrapper" class="module">               
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
            <div id="history-wrapper" class="module">
				<div class="widget">
					<div class="widget-advanced">
					    <!-- Widget Header -->
					    <div class="widget-header text-center themed-background-dark-night" style="padding: 0; height: auto">
					        <h3 class="widget-content-light">
					            Code History<br>	           
					        </h3>
					    </div>
					    <!-- END Widget Header -->
					
					    <!-- Widget Main -->
					    <div class="widget-main">	        
					        <table class="table table-borderless table-striped table-condensed table-vcenter">
					            <tbody>
					                
					            </tbody>
					        </table>	        
					    </div>
					    <!-- END Widget Main -->
					</div>
				</div>	
            </div>            
        </div>
        
		<!-- shoutbox -->
		<div class="shout_box">
			<div class="header"><h6 class="widget-content-light">Group Chat</h6></div>
			<div class="toggle_chat">
				<ul class="chat-talk-messages" id="chatlog">
					<div class="loadchat">
						<input type="image" src="/img/uparrow.png">
					<div>
				</ul>
				<div class="user_info">
					<div class="voice">
						<input type="image" id="voice" src="/img/voice.png" value="OFF">
					</div>
					<div class="message">
						<input name="shout_message" id="shout_message" type="text" placeholder="Message" maxlength="100" />
					</div>						
				</div>
			</div>
		</div>
		<!-- shoutbox end -->
    </div>
    <!-- END Main Row -->
</div>
<!-- END Page Content -->

<?php include '../inc/page_footer.php'; ?>


<!-- Remember to include excanvas for IE8 chart support -->
<!--[if IE 8]><script src="js/helpers/excanvas.min.js"></script><![endif]-->

<?php include '../inc/template_scripts.php'; ?>

<script src="<?= $template['template_url'] ?>/js/ace/ace.js"></script>
<script src="<?= $template['template_url'] ?>/js/ace/ace.java.js"></script>
<script src="<?= $template['template_url'] ?>/js/ace/ace.theme.js"></script>
<script type="text/javascript" src="<?= $template['template_url'] ?>/js/recorderjs/recorder.js"></script>
<script src="http://fyp.mylife.hk:443/channel/bcsocket.js"></script>
<script src="http://fyp.mylife.hk:443/share/share.uncompressed.js"></script>
<script type='text/javascript' > 
	var text_msg_no = 0;
	var voice_msg_no = 0;
	var drawing_no = 0; 
</script>
<script src="http://fyp.mylife.hk:443/share/ace.js"></script>
<script src="http://fyp.mylife.hk:443/share/json.js"></script>
<script src="http://fyp.mylife.hk:443/share/textarea.js"></script>
<script src="http://intridea.github.io/sketch.js/lib/sketch.min.js"></script>

<script>
	
	$(document).delegate('textarea', 'keydown', function(e) {
	  var keyCode = e.keyCode || e.which;
	
	  if (keyCode == 9) {
	    e.preventDefault();
	    var start = $(this).get(0).selectionStart;
	    var end = $(this).get(0).selectionEnd;
	
	    // set textarea value to: text before caret + tab + text after caret
	    $(this).val($(this).val().substring(0, start)
	                + "\t"
	                + $(this).val().substring(end));
	
	    // put caret at right position again
	    $(this).get(0).selectionStart =
	    $(this).get(0).selectionEnd = start + 1;
	  }
	});	

	
    $(function(){
	    
        var group_id = <?= $assignmentAPI->info['group_id'] ?>;
        var assignment_id = <?= $assignmentAPI->info['assignment_id'] ?>;

        var user_name = "<?= $userAPI->authService()['user_name'] ?>";
        var user_id = <?= $userAPI->authService()['user_id'] ?>;		    
	

        $(window).resize(function(){
            $("#editor-wrapper, #terminal-wrapper").height($(window).height() - 115);
        });
        $("#editor-wrapper, #terminal-wrapper, #testcase-wrapper #input, #drawing-wrapper canvas").height($(window).height() - 115);
        $("#drawing-wrapper canvas")[0].height = $(window).height() - 115;
        $("#drawing-wrapper canvas")[0].width = $("#testcase-wrapper").width();


        $("a").click(function(e){
            if($(this).attr('href') == "#back" || $(this).attr('id') == "back-link"){
                e.preventDefault();
                window.history.back();
            }
        });
        $("i.fa-bars").removeClass("fa-bars").addClass("fa-chevron-left");


        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/java");
        editor.setShowPrintMargin(false);

        var terminal = ace.edit("terminal");
        terminal.setTheme("ace/theme/monokai");
        terminal.getSession().setMode("ace/mode/java");
        terminal.setShowPrintMargin(false);
        terminal.renderer.setShowGutter(false);
        terminal.setOptions({
            readOnly: true,
            highlightActiveLine: false,
            highlightGutterLine: false
        });
        //terminal.renderer.$cursorLayer.element.style.opacity=0
        terminal.textInput.getElement().tabIndex=-1
        
      


        var shareJSConnect = function(editor, group_id, is_textarea){
            var connection = sharejs.open(group_id, 'text', 'http://fyp.mylife.hk:443/channel', function(error, doc) {
                if(error){
                    console.log(error);
                }else{
	                if(typeof is_textarea !== "undefined"){
		                doc.attach_textarea(editor);
	                }else{
	                    doc.attach_ace(editor);
	                    var code = editor.getValue();
	                    if(code == ""){
	                        $.get("code/test/test.java", function(code){
	                            editor.setValue(code);
	                        });
	                    }
	                }
	                loader('off');
                }
            });
        };

        shareJSConnect(editor, "code-group-"+group_id);
        shareJSConnect(terminal, "terminal-group-"+group_id);
        shareJSConnect($("#input")[0], "input-group-"+group_id, true);

        var terminalOutput = function(output, isReset){
            if(typeof isReset !== "undefined"){
                window.terminalOutputValue = "";
            }
            window.terminalOutputValue += output + "\n";
            terminal.setValue(window.terminalOutputValue, 1);
        }


        var saveCode = function(group_id){
	        windowLayout('terminal');
            terminalOutput("Pushing Code to Server...", true);                        
            socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'compile'});
            
            setTimeout(function(){
                terminalOutput("Compiling Code...");
                var code = editor.getValue();
                $.post("/api/submit-code.php", {code: code, group_id: group_id, assignment_id: assignment_id}, function(res){
                    console.log("Submit Code: "+res);
                    fileHistory(group_id);
                    if(res != ""){
                        setTimeout(function(){
	                        socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'compile-fail'});	                        
                            terminalOutput("Compile Error...");
                            terminalOutput(res);                            
                        }, 1000);
                    }else{
                        setTimeout(function(){	                        
	                        socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'compile-success'});
                            terminalOutput("Compile Success...");
                            
	                        setTimeout(function(){
	                            terminalOutput("Running...");	                            
	                            var inputs = $(input).val();
								$.post("/api/run-code.php", {inputs: inputs, group_id: group_id, assignment_id: assignment_id}, function(res){
	                            
									var arr = JSON.parse(res);
									if(arr.resultType == "1"){	                        
										socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'running-error'});
										terminalOutput("Running Exception!...");	
										
									}else{	                        
										socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'running-success'});
										terminalOutput("Run Successfully!...");											
									}
									                        		
	                            	terminalOutput(arr.content);
								});
	                            
	                        }, 1000);                            
                            
                        }, 1000);
                        
                        
                    }
                });
            }, 1000);
        };
        
        var fileHistory = function(group_id){
	        $.post("/api/get-file-history.php", {group_id: group_id}, function(res){
		       	//console.log(res); 
		       	
		       	var html = "";
				$.each($.parseJSON(res), function(i, item){				    
				    html += '<tr>';
				    html += '<td style="width: 10px;">'+i+'</td>'
	                html += '<td><a href="javascript:void(0)"><strong>'+item.name+'</strong></a></td>'
	                html += '<td><a href="javascript:void(0)"><strong>'+item.save_time+'</strong></a></td>'
	                html += '<td class="text-right">Restore</td>'
	                html += '<td class="text-center" style="width: 70px;">'
	                html += '<div class="btn-group btn-group-xs">'
	                html += '<a data-id="'+item.assignment_history_id+'" class="btn btn-default" data-toggle="tooltip" title="Restore"><i class="fa fa-undo"></i></a>'
	                html += '</div>'
	                html += '</td>'
	                html += '</tr>';			    
				});       
				
				$("table tbody", '#history-wrapper').html(html);		       			       	
	        });
        };
        
        var revertFileHistory = function(id){
	        $.post("/api/revert-file-history.php", {group_id: group_id, id: id}, function(res){
		       	console.log($.parseJSON(res)); 
		       	editor.setValue($.parseJSON(res).code);  
		       	socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'restore'});   			       			       
	        });	        
        }
        
        $(document).on('click', '#history-wrapper tr a', function(){
	        var id = $(this).attr('data-id');
	        revertFileHistory(id);
        });


        //Socket.IO
        var socket = io('http://fyp.mylife.hk:8443/assignment-do');

        //Socket Listener on joining group
        socket.emit('join group', {group_id: group_id, name: user_name, user_id: user_id});
        socket.on('status', function (data) {
            console.log(data);
        });

        //Socket Listener on User Joining this page
        socket.on("user join", function(data){
            console.log(data);
            if(typeof data.status_id !== "undefined" || data.status_id > 0){
	            //socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'user-join'});                
            }
        });

        //Socket Listener when a User leave this page
        socket.on("user leave", function(data){
            console.log(data);
            if(typeof data.status_id !== "undefined" || data.status_id > 0){
                console.log(data.user_name);
                socket.emit('identify user', {group_id: group_id, name: user_name, user_id: user_id});
                socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'user-leave'});                
            }
        });
        
        socket.on("msg", function(data){
	       console.log(data);
	       switch(data.action){
		       case "compile":
		       		notification('Compiling');
		       		compileButtonToggle();
			   		break;	
		       case "compile-fail":
		       		notification('Compile Error', 'danger');
		       		compileButtonToggle();
			   		break;	
		       case "compile-success":
		       		notification('Compile Success, Running', 'success');
		       		compileButtonToggle();
			   		break;
		       case "running":
		       		notification('Running');		       		
			   		break;	
		       case "running-error":
		       		notification('Runtime Error','danger');		       		
			   		break;	
		       case "running-success":
		       		notification('Run Successfully','success');		       		
			   		break;	
		       case "restore":
		       		notification(data.user_name+' Code History Restored');		       		
			   		break;		
		       case "drawing-share":
		       		notification(data.user_name+' shared a drawing', 'success');		       		
			   		break;	
			   case "user-leave":
			   		notification(data.user_name+' just leaved', 'danger');
			   		break;	
			   case "user-join":
			   		notification(data.user_name+' just joined', 'success');
			   		break;			   		   			   					   						   					   			       	
	       } 
        });


        //Leave Room
        $(window).bind('beforeunload', function(){
			console.log("Leaving....");
            socket.emit("leave group", {group_id: group_id, name: user_name, user_id: user_id});
			//uploadCollabData();
            return("Are you sure to leave?");
        });


        //Module Animate In & Out
        var editorWindow = function(){
            if($(".col-sm-8", "div.row").attr('location') == "max"){
                $(".col-sm-8", "div.row").animate({width: '66.66666667%' }).attr('location', 'min');
            }else{
                $(".col-sm-8", "div.row").animate({width: $(window).width()}).attr('location', 'max');
            }
        }

        var terminalWindow = function(action){
            if(action != "show"){
                $("div#terminal-wrapper").animate({left:$("div#terminal-wrapper").width()+100}).attr('location', "out");
            }else{
                $("div#terminal-wrapper").animate({left:'-31px'}).attr('location', "in");
            }
        }
        
        var historyWindow = function(action){
            if(action != "show"){
                $("div#history-wrapper").animate({left:$("div#terminal-wrapper").width()+100}).attr('location', "out");
            }else{
                $("div#history-wrapper").animate({left:'-31px'}).attr('location', "in");
            }
        }  
        
        var questionsWindow = function(action){
            if(action != "show"){
                $("div#questions-wrapper").animate({left:$("div#terminal-wrapper").width()+100}).attr('location', "out");
            }else{
                $("div#questions-wrapper").animate({left:'-31px'}).attr('location', "in");
            }
        }  
        
        var testCaseWindow = function(action){
            if(action != "show"){
                $("div#testcase-wrapper").animate({left:$("div#terminal-wrapper").width()+100}).attr('location', "out");
            }else{
                $("div#testcase-wrapper").animate({left:'-31px'}).attr('location', "in");
            }
        }  
        
        var drawingWindow = function(action){
            if(action != "show"){
                $("div#drawing-wrapper").animate({left:$("div#terminal-wrapper").width()+100}).attr('location', "out");
            }else{
                $("div#drawing-wrapper").animate({left:'-31px'}).attr('location', "in");
            }
        }                           
        
        var windowLayout = function(type){
	        terminalWindow('close');
	        historyWindow('close');
	        questionsWindow('close');
	        testCaseWindow('close');
	        drawingWindow('close');
	        
	        if(type == "terminal"){
		        terminalWindow('show');
	        }else if(type == "history"){
		        historyWindow('show');
	        }else if(type == "questions"){
		        questionsWindow('show');
	        }else if(type == "testcase"){
		        testCaseWindow('show');
	        }else if(type == "drawing"){
		       	drawingWindow('show');
	        }
        }
        
        var loader = function(status){
	        if(status == "off"){
		        $("#loader").fadeOut();
	        }else{
		        $("#loader").fadeIn();
	        }
        }

        $("iframe").width($("#terminal-wrapper").width()).height($("#terminal-wrapper").height());
        $(".module").height($("#terminal-wrapper").height());
        fileHistory(group_id);
        windowLayout('questions');



        //Event Listener for buttons
        $("i.fa-terminal").parent().parent().click(function(){
            windowLayout('terminal');
        });
        
        $("i.gi-conversation").parent().parent().click(function(){
            $('.toggle_chat').slideToggle();
        });    
        
        $("i.gi-iphone_transfer").parent().parent().click(function(){
            windowLayout('testcase');
        });          
        
        $("i.gi-keynote").parent().parent().click(function(){
            windowLayout('questions');
        });      
        
        $("i.gi-notes_2").parent().parent().click(function(){
            windowLayout('drawing');
        });                 
        
        $("a#compile-and-run").click(function(){
            saveCode(group_id);
        });
        
        $("li#file-history").click(function(){
	        //fileHistory(group_id);
	        windowLayout('history');
        });   
              
		//Upload data to sql server
		function uploadCollabData(){
			console.log("Upload....");
			if (text_msg_no + voice_msg_no + drawing_no + code_no > 0){
				$.post("/apiv2/upload-collaboration-data.php", {group_id: group_id, text: text_msg_no, voice: voice_msg_no, drawing: drawing_no, code: code_no});
				text_msg_no = voice_msg_no = drawing_no = code_no = 0;
			}
		}
		
		<?php
		include '../js/chat.js'; 			
		include '../js/drawing.js';
		?>
		
	});
</script>


<?php include '../inc/template_end.php'; ?>