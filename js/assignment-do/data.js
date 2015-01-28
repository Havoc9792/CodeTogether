var text_msg_no = 0;
var voice_msg_no = 0;
var drawing_no = 0; 
var code_no = 0;

function uploadCollabData(){
	if (text_msg_no + voice_msg_no + drawing_no + code_no > 0){
		$.post("/apiv2/upload-collaboration-data.php", {group_id: group_id, text: text_msg_no, voice: voice_msg_no, drawing: drawing_no, code: code_no});
		text_msg_no = voice_msg_no = drawing_no = code_no = 0;
	}
}