$.each(['#f00', '#ff0', '#0f0', '#0ff', '#00f', '#000', '#fff'], function() {
  $('#quickview-draw .tools').append("<a href='#colors_sketch' data-color='" + this + "' style='width: 10px; background: " + this + ";'></a> ");
});
$.each([3, 10], function() {
  $('#quickview-draw .tools').append("<a href='#colors_sketch' data-size='" + this + "' style='background: #ccc'>" + this + "</a> ");
});
$('#quickview-draw .tools').append("<a id='share-drawing' href='#colors_sketch' style='background: #ccc'>Share</a> ");
$('#quickview-draw .tools').append("<a id='clear-drawing' href='#colors_sketch' style='background: #ccc'>Clear</a> ");
$('#colors_sketch').sketch();

$('body').on("click", "a#share-drawing", function(){	
	var canvas = $("canvas#colors_sketch")[0];
	var pic = canvas.toDataURL('jpeg');	
	uploadDrawing(pic);
});

$('body').on("click", "a#clear-drawing", function(){	
	var canvas = $("canvas#colors_sketch")[0];
	var pic = canvas.getContext('2d');
	$('#colors_sketch').remove();
	$('#quickview-draw').prepend("<canvas id='colors_sketch' height='880' width='659' style='height: 880px;'></canvas>");
	$('#colors_sketch').sketch();
	
	//pic.clearRect(0,0,canvas.width,canvas.height);
	//pic.restore();
	//pic.save();	
});

var uploadDrawing = function(data){ 
	if(data == "") return;
	
	var name = prompt("Drawing Name:");
	
	if(name != null) {
	    		
		//notification('Sharing Drawing');
		//loader('on');
		$.post("/apiv2/submit-drawing.php", {group_id: group_id, drawing: data}, function(res){
			if(res == ""){
				//notification('Drawing Share Error', 'danger');
				return;
			}else{
				socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'drawing-share'}); 
				sendmsg_hei("<a target='_blank' href='/drawing/"+res+"/'>"+user_name+" shared a drawing - "+name+"</a>");
			}
			loader('off');
		});
	
	}
}