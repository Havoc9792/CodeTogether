var fileHistory = function(group_id){
    $.post("/apiv2/get-file-history.php", {group_id: group_id}, function(res){
       	//console.log(res); 
       	
       	var html = "";
		$.each($.parseJSON(res), function(i, item){	
			html += '<li class="alert-list p-t-10 p-b-10 p-l-10 p-r-10">';
			html += '<a href="#" data-id="'+item.assignment_history_id+'" class="p-t-10 p-b-10" data-navigate="view" data-view-port="#chat" data-view-animation="push-parrallax">';
		    html += '<p class="col-xs-height col-middle"><span class="text-danger fs-10"><i class="fa fa-circle"></i></span></p>';
		    html += '<p class="p-l-10 col-xs-height col-middle col-xs-12 overflow-ellipsis fs-12">';
		    html += '<span class="text-master link">'+item.save_time+'<br></span>';
		    html += '<span class="text-master">'+item.name+'</span>';
		    html += '</p></a></li>';						   			    
		});       
		
		$("ul", "#quickview-history").html(html);		       			       	
    });
};

var revertFileHistory = function(id){
    $.post("/apiv2/revert-file-history.php", {group_id: group_id, id: id}, function(res){
       	console.log($.parseJSON(res).code); 
       	editor.setValue($.parseJSON(res).code);  
       	socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'restore'});   			       			       
    });	        
}

$(document).on('click', '#quickview-history ul li a', function(){
    var id = $(this).attr('data-id');
    revertFileHistory(id);
});

fileHistory(group_id);