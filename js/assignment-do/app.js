
var saveCode = function(group_id){
    //windowLayout('terminal');
    terminalOutput("Saving Code to Server...", true);                        
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
								
							}else{	                        
								socket.emit("msg", {group_id: group_id, name: user_name, user_id: user_id, action: 'running-success'});
								terminalOutput("Run Successfully!...");
							                        		
								terminalOutput(arr.content);
								
								$.post("/apiv2/run-against-testcase.php", {group_id: group_id},function(result){
								terminalOutput("Running againist test case");
									var testcaseArray = JSON.parse(result);
									if(testcaseArray.length != 0)
										socket.emit("func", {group_id: group_id, user_name: user_name, user_id: user_id, action: ' $("#testcase-anly").click(); '});
										
									//terminalOutput(testcaseArray.resultType);
									for(var i=0;i<testcaseArray.length;i++){
										terminalOutput("Test Case #: " + i);
										terminalOutput("Result: " + testcaseArray[i].resultType);
										terminalOutput("Test Type: " + testcaseArray[i].type);
										terminalOutput("Teacher's Comment : " + testcaseArray[i].description );
										
										change_testcase_ui_on_delay(testcaseArray[i].id,testcaseArray[i].resultType,500 + i*500);
										/*
										switch(testcaseArray[i].resultType){
											case "PASS":
											testcase_ui_change_to(testcaseArray[i].id,testcase_ui_success);
											break;
											case "FAIL":
											testcase_ui_change_to(testcaseArray[i].id,testcase_ui_error);
											break;
											case "TIMEOUT":
											testcase_ui_change_to(testcaseArray[i].id,testcase_ui_warning);
											break;
											default:
											break;
										}
										*/
									}
									//terminalOutput(testcaseArray[0].id);
									/* It Works
									$.each(testcaseArray,function(key,value){
										terminalOutput("Test Case ID : "+value.id + " Result : " + value.resultType);
									});
									*/
									terminalOutput("");
										
								});											
							}
						});
                        
                    }, 500);                            
                    
                }, 500);
                
                
            }
        });
    }, 500);
};
function change_testcase_ui_on_delay(id,type,delay){
										switch(type){
											case "PASS":
											setTimeout(function(){testcase_ui_change_to(id,testcase_ui_success);}, delay);
											break;
											case "FAIL":
											setTimeout(function(){testcase_ui_change_to(id,testcase_ui_error);}, delay);
											break;
											case "TIMEOUT":
											setTimeout(function(){testcase_ui_change_to(id,testcase_ui_warning);}, delay);
											break;
											default:
											break;
										}
}
$("#compile").click(function(){
	if(!$("#testcase-anly-content").hasClass('hidden')){
		$("#testcase-anly-content").fadeOut(function(){
			$(this).addClass('hidden');
		});
	}else{
	}
	saveCode(group_id);
	
});


//Leave Room
$(window).bind('beforeunload', function(){
    socket.emit("leave group", {group_id: group_id, name: user_name, user_id: user_id});
    return;
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