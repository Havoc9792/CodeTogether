$("li.tab-li").click(function(){
	var editor_id = $(this).attr('data-editor-id');
	var editor_name = $(this).attr('data-editor-name');
	$("#quickview-history #tab-name").text("Tab "+editor_name);
	fileHistory(editor_id);
});



var historyEditor = ace.edit("historyPreviewEditor");		   
historyEditor.setTheme("ace/theme/monokai");	
historyEditor.getSession().setMode("ace/mode/java"); 
historyEditor.renderer.setShowGutter(false);
historyEditor.setShowPrintMargin(false);
historyEditor.setOptions({
    readOnly: true,
    highlightActiveLine: false,
    highlightGutterLine: false
});	
$("div#historyPreviewEditor").height($(window).height()*0.6).width("100%");


$("#quickview-history").on("click", "a", function(){
	window.history_id = $(this).attr('data-history-id');
	$.get("/apiv2.1/editor/"+editor_id+"/history/"+history_id+"/", function(res){
		console.log(res);
		var editor = $.parseJSON(res);
		console.log(editor);
		historyEditor.setValue(editor.code, -1);
		$('#historyModal').modal('show');
	});
});


var fileHistory = function(editor_id){
	window.editor_id = editor_id;
    $.get("/apiv2.1/editor/"+editor_id+"/history/", function(res){
       	//console.log(res); 
       	
       	var html = "";
		$.each($.parseJSON(res), function(i, item){	
			html += '<tr>';
			html += '<td class="v-align-middle semi-bold">'+item.save_time+'</td>';
			html += '<td class="v-align-middle">'+item.name+'</td>';
			html += '<td class="indicator v-align-middle semi-bold"><a href="#" data-history-id="'+item.assignment_history_id+'" data-toggle="modal" data-target="#historyModals"><i class="fa fa-search"></i></a></td>'
			html += '</tr>';						   			    
		});       
		
		$("tbody", "#quickview-history").html(html);		       			       	
    });
};

var revertFileHistory = function(){	
	var id = "editor" + window.editor_id;
	var editor = ace.edit(id);
	editor.setValue(historyEditor.getSession().getValue());
	socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'restore'});            
}

$(document).on('click', '#historyModal a', function(){   
	$('#historyModal').modal('hide'); 
    setTimeout(function(){
	    revertFileHistory();
	}, 1000);
});

fileHistory(editor_id);