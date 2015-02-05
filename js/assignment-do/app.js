
var saveCode = function(group_id){
    //windowLayout('terminal');
    terminalOutput("Pushing Code to Server...", true);                        
    socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'compile'});
    
    setTimeout(function(){
    	var codeArray = {};	
        terminalOutput("Compiling Code...");
        $(".ace_editor").each(function(){
			var editor_id = $(this).attr("id");
			if(editor_id != "terminal"){
				var code = ace.edit(editor_id).getValue();
				editor_id = editor_id.replace("editor", "")
				//if(code != ""){
					codeArray[editor_id] = code;
					//console.log("index: " + editor_id +" code: " + code);
				//}
			}
		});
        $.post("/apiv2/submit-code.php", {codeArray: codeArray, group_id: group_id, assignment_id: assignment_id}, function(res){
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
                        var inputs = $("textarea#testcase").val();
						$.post("/apiv2/run-code.php", {inputs: inputs, group_id: group_id, assignment_id: assignment_id}, function(res){
                        
							var arr = JSON.parse(res);
							if(arr.resultType == "1"){	                        
								socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'running-error'});
								terminalOutput("Running Exception!...");
							                        		
								terminalOutput(arr.content);
								terminalOutput("THIS LINE INDICATES THE END...");
								/*
								$.post("/apiv2/run-aggainst-testcase.php", {group_id: group_id},function(res){
									var testcaseArray = JSON.parse(res);
									//$.each(testcaseArray,function(key,value){
										//terminalOuput("Test Case ID : "value.id + " Result : " + value.resultType);
									//});
										//terminalOuput(testcaseArray);
								});
								terminalOutput("THIS LINE INDICATES THE END OF RUN-AGAINST-TESTCASES...");	
								*/
							}else{	                        
								socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'running-success'});
								terminalOutput("Run Successfully!...");
							                        		
								terminalOutput(arr.content);
								terminalOutput("THIS LINE INDICATES THE END...");											
							}
						});
                        
                    }, 1000);                            
                    
                }, 1000);
                
                
            }
        });
    }, 1000);
};

$("#compile").click(function(){
	saveCode(group_id);
});


//Leave Room
$(window).bind('beforeunload', function(){
    socket.emit("leave group", {group_id: group_id, name: user_name, user_id: user_id});
    return("Are you sure to leave?");
});

var loader = function(status){
    if(status == "off"){
        $("#loader").fadeOut();
    }else{
        $("#loader").fadeIn();
    }
}

$("#video-chat").click(function(){
	
	if($("#video-chat-content").hasClass('hidden')){
		$("#video-chat-content").removeClass('hidden').css('display', 'none').fadeIn();
	}else{
		$("#video-chat-content").fadeOut(function(){
			$(this).addClass('hidden');
		});
	}
});

$("#testcase-anly").click(function(){
	
	if($("#testcase-anly-content").hasClass('hidden')){
		$("#testcase-anly-content").removeClass('hidden').css('display', 'none').fadeIn();
	}else{
		$("#testcase-anly-content").fadeOut(function(){
			$(this).addClass('hidden');
		});
	}
});

$("#overlay-exit").click(function(){
	$(".overlay").fadeOut("fast").addClass("closed");
})