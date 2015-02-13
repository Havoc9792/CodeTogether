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
	uploadCollabData();
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
       		notification('Code History Restored by '+data.user_name );		       		
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
	   case "reload":
	   		window.location.reload();
	   		break;
	   case "testcase_ui_load_all":
		   	testcase_ui_load_all();
	   		break;		   		   			   					   						   					   			       	
	   case "testcase_ui_load_all":
		   	testcase_ui_change_to(data.testcase_id, data.testcase_type);
	   		break;		   		
   } 
});
