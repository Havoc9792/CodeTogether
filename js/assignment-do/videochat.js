// Compatibility shim
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

var call_num_list = [];

socket.on("user support videochat", function(data){
    console.log(data);
    call_num_list.push(data.call_num);
});


var peer = new Peer('video'+user_id, {key: 'qur78wltn0e2vs4i'}); 

peer.on('open', function(){
	console.log("peer id: "+peer.id);
	socket.emit('user support videochat', {group_id: group_id, name: user_name, user_id: user_id, call_num: peer.id});
});

// Receiving a call
peer.on('call', function(call){
	// Answer the call automatically (instead of prompting user) for demo purposes
	notification("You are invited to group video chat");
	call.answer(window.localStream);
	var call_num = call.peer;
	receiveCall(call, call_num);
});

peer.on('error', function(err){
	alert(err.message);		
});


function step1() {
	// Get audio/video stream
	navigator.getUserMedia({audio: true, video: true}, function(stream){
		$('#my-video').prop('src', URL.createObjectURL(stream));
		
		var call_num = "video156";
		
		//var call = peer.call(call_num, window.localStream);
		//step3(call, call_num);		
		
	}, function(){ 
		
		console.log("error");
	});
}


function receiveCall(call, call_num) {		
	call.on('stream', function(stream){
		$("#video-chat-windows").append('<div class="col-xs-6 video-'+call_num+'"><video style="width:100%" class="their-video" autoplay></video></div>');				
		$('video', 'div.video-'+call_num).prop('src', URL.createObjectURL(stream));
	});
	
	call.on('close', function(){
		call.close();
		$('div.video-'+call_num).remove();
	})
	
}

// Click handlers setup
$(function(){
	$('#make-call').click(function(){			
		step1();	
	});

});
