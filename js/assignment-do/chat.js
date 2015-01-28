//Socket.IO
var socket2 = io('http://fyp.mylife.hk:8443/chat');
var lastChater = "";
var lastChat = 0;
//Socket Listener on joining chatroom
socket2.on('connect', function (data) {
	socket2.emit('join room', {group_id: group_id, name: user_name} );
});

//Socket Listener when user send msg
//method to trigger when user hits enter key
$('[data-chat-input]').on('keypress',function(e){
if(e.which == 13) {
		sendmsg();
		event.preventDefault();
}
});

var elem = document.getElementById('my-conversation');
elem.scrollTop = elem.scrollHeight;

socket2.on('message', function (data) {
	add_message(data);
	lastChater = data.name;
	var elem = document.getElementById('my-conversation');
	elem.scrollTop = elem.scrollHeight;
});

socket2.on('sysbroadcast', function (data) {
	var fragment = '<div class="text-center"><small>'+data+'</small><div>';
	var list = $("#my-conversation");
	list.append(fragment);
	var elem = document.getElementById('my-conversation');
	elem.scrollTop = elem.scrollHeight;
});

function add_message(data) {
	var fragment1, html = "";
	var list = $("#my-conversation");
	if (data.name != lastChater){
		/*
		if (data.name == user_name){
			fragment1 = '<li class="text-left"><small>'+data.name+'</small></li>';
		}else{
			fragment1 = '<li class="text-right"><small>'+data.name+'</small></li>';
		}
		list.append(fragment1);
		*/
	}
	if (data.name == user_name){
		html += '<div class="message clearfix">';
		html += '<div class="chat-bubble from-me">';
		html += data.msg;
		html += '</div>'
		html += '</div>'
	}else{
		html += '<div class="message clearfix">';
		html += '	<div class="profile-img-wrapper m-t-5 inline">';
		html += '		<img class="col-top" width="30" height="30" src="'+data.avatar+'" alt="" ">';
		html += '	</div>';
		html += '	<div class="chat-bubble from-them">';
		html += data.msg;
		html += '	</div>'
		html += '</div>'	
	}
	list.append(html);
}

function sendvoice(msg){
	socket2.emit('message', {message: msg});
	voice_msg_no++;
}

function sendmsg(){	
	var r = $('[data-chat-input]').val();
	if (r == "") return;
	socket2.emit('message', {message: r, avatar: user_avatar});
	$('[data-chat-input]').val('');
	$.post("/apiv2/submit-message.php", {group_id: group_id, message: r});
	text_msg_no++;
}   

//Allow other module to send / share msg with a message content
function sendmsg_hei(msg){
	if(msg == "") return;
	socket2.emit('message', {message: msg, avatar: user_avatar});
	$.post("/apiv2/submit-message.php", {group_id: group_id, message: msg}, function(res){});	
	drawing_no++;
}


$(".voice").click(function (e) {
	toggleRecording(e, group_id);
});

var chatHistory = function (group_id){
	$.post("/apiv2/get-chat-history.php", {group_id: group_id, chat_id: lastChat}, function(res){
		//console.log(res); 
		var html = "";
		var lastchater = ""
		var history = $.parseJSON(res);
		
		if (history == null)
			return;
		
		$.each(history, function(i, item){
			if (item['username'] != lastchater){
				/*
				if (item['username'] == user_name){					
					html += '<div class="message clearfix">';
					html += '<div class="chat-bubble from-me">';
					html += item['username'];
					html += '</div>'
					html += '</div>'					
				}else{
					html += '<div class="message clearfix">';
					html += '<div class="profile-img-wrapper m-t-5 inline"><img class="col-top" width="30" height="30" src="assets/img/profiles/avatar_small.jpg" alt="" data-src="assets/img/profiles/avatar_small.jpg" data-src-retina="assets/img/profiles/avatar_small2x.jpg"></div>';
					html += '<div class="chat-bubble from-them">';
					html += item['username'];
					html += '</div>'
					html += '</div>'	
				}	
				*/						
			}
			if (item['type'] == 'voice'){
				
				if (item['username'] == user_name){
					html += '<div class="message clearfix">';
					html += '<div class="chat-bubble from-me">';
					html += "<audio controls><source src='/apiv2/voice/"+item['chat_id']+".wav' type='audio/wav'></audio>";
					html += '</div>'
					html += '</div>'						
				}else{
					html += '<div class="message clearfix">';
					html += '	<div class="profile-img-wrapper m-t-5 inline">';
					html += '		<img class="col-top" width="30" height="30" src="'+item['avatar']+'" alt="" ">';
					html += '	</div>';
					html += '	<div class="chat-bubble from-them">';
					html += "<audio controls><source src='/apiv2/voice/"+item['chat_id']+".wav' type='audio/wav'></audio>";
					html += '	</div>'
					html += '</div>'						
					//html += "<li class='chat-talk-msg animation-slideRight'><audio controls><source src='/api/voice/"+item['chat_id']+".wav' type='audio/wav'></audio></li>";	
				}	
				
			}else{
				if (item['username'] == user_name){
					html += '<div class="message clearfix">';
					html += '<div class="chat-bubble from-me">';
					html += item['message'];
					html += '</div>'
					html += '</div>'					
				}else{
					html += '<div class="message clearfix">';
					html += '	<div class="profile-img-wrapper m-t-5 inline">';
					html += '		<img class="col-top" width="30" height="30" src="'+item['avatar']+'" alt="" ">';
					html += '	</div>';
					html += '	<div class="chat-bubble from-them">';
					html += item['message'];
					html += '	</div>'
					html += '</div>'											
				}	 
			}
			if (i == 0)
				lastChat = item['chat_id'];
			lastchater = item['username'];
		});      
		
		$('#my-conversation').append(html);	

		
	});
};

$( ".loadchat" ).click(function() {
  chatHistory(group_id);
});

chatHistory(group_id);


//voice-chat

var navigator = window.navigator;
var Context = window.AudioContext || window.webkitAudioContext;
var context = new Context();

// audio
var mediaStream;
var rec;

navigator.getUserMedia = (
  navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia
);

function upload(blob, group_id) {
	console.log(group_id);
	var xhr=new XMLHttpRequest();
	xhr.onload=function(e) {
		if(this.readyState === 4) {
			var msg = "<audio controls><source src='/apiv2/voice/"+e.target.responseText+".wav' type='audio/wav'></audio>";
			sendvoice(msg);
			//console.log("Server returned: ",e.target.responseText);
		}
	};
	var fd=new FormData();
	fd.append("audiofile",blob);
	fd.append('group_id', group_id);
	xhr.open("POST","/apiv2/chat-voice-upload.php",true);
	xhr.send(fd);
}

function toggleRecording(e, group_id) {
	var elem = document.getElementById('voice');
    if (elem.value=="ON") {
	    $("#voice").addClass('text-master').removeClass('text-danger');
        // stop recording
        mediaStream.stop();
		rec.stop();
		rec.exportWAV(function(e){
			rec.clear();
			upload(e, group_id);
			//Recorder.forceDownload(e, "test.wav");
		});
        elem.value="OFF";
		//elem.src="/img/voice.png";
    } else {
        // start recording
		navigator.getUserMedia({audio: true}, function(localMediaStream){
			mediaStream = localMediaStream;
			var mediaStreamSource = context.createMediaStreamSource(localMediaStream);
			rec = new Recorder(mediaStreamSource, {
			  workerPath: '/js/assignment-do/recorderjs/recorderWorker.js'
			});
		    rec.record();
			elem.value="ON";
			//elem.src="/img/recording.gif";
			$("#voice").removeClass('text-master').addClass('text-danger');
		}, function(err){
			console.log('Not supported');
		});
    }
}