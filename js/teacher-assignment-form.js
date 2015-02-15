var editors = [];

$(".ace_editor").each(function(){
	var id = $(this).attr("id");
	var editor = ace.edit(id);		   
	editor.setTheme("ace/theme/monokai");	
	editor.getSession().setMode("ace/mode/java"); 	
	editor.setShowPrintMargin(false);
	editors.push({obj: editor, id: id});
});

$(".ace_editor", "form").height($(window).height()*0.7).width("100%");

//Delete Editor
$("i.delete-tab").click(function(){
	var editor_id = $(this).attr('data-id');
	if(confirm("Are you sure to delete this tab?")){				
		$.post("/apiv2.1/editor/delete/"+editor_id+"/", function(res){			
			if(res == 1){				
				window.location.reload();				
			}else{
				alert("Error Deleting Tab");
			}
		});
	}else{
		
	}
});

$("a#add-editor").click(function(e){
	e.preventDefault();
	var code = [];
	
	$.each(editors, function(i, editor){
		code.push({id: editor.id, editor: editor.obj.getSession().getValue()});
	});	
	
		
	if( $("input#due-date").val() == "" || $("input#due-time").val() == "" || $("input#code").val() == "" || $("input#title").val() == "" || $("input#grouping").val() == "" ){
		//$.bootstrapGrowl("Please fill in all the blanks", {type: 'danger'});
		notification("Please fill in all the blanks before creating a new file", 'danger');
		return;
	}
	
	var form = $("form").serializeArray();
					
	$.post("/apiv2.1/assignment/"+assignment_id+"/update/", {form: form , code: code}, function(res){
		console.log(res);			
					
		if(res > 0){
			notification("Assignment Details Saved", 'success');	
			
			$.post("/apiv2.1/samplecode/"+assignment_id+"/create/", function(res){
				console.log(res);			
				if(res > 0){
					notification("New code tab created, please wait for redirection", 'success');	
					setTimeout(function(){
						window.location.reload();
					}, 1000);		
				}else{
					notification("Error creating new code tab", 'danger');
				}
			}); 			
					
		}else{
			notification("Error Saving Assignment Details", 'danger');
		}			
					
		
	}); 
						
});

$("input#submit", "form").click(function(e){
	e.preventDefault();
	var code = [];
	
	$.each(editors, function(i, editor){
		code.push({id: editor.id, editor: editor.obj.getSession().getValue()});
	});	
	
	//console.log(JSON.parse(code));
	
	if( $("input#due-date").val() == "" || $("input#due-time").val() == "" || $("input#code").val() == "" || $("input#title").val() == "" || $("input#grouping").val() == "" ){
		//$.bootstrapGrowl("Please fill in all the blanks", {type: 'danger'});
		notification("Please fill in all the blanks", 'danger');
		return;
	}
	
	
	var formData = [];
	var form = $("form").serializeArray();
	for(var i=0;i<form.length;i++){
		formData[form[i]['name']] = form[i]['value'];
	}
	
	
	console.log(code);
			
	$.post("/apiv2.1/assignment/"+assignment_id+"/update/", {form: form , code: code}, function(res){
		console.log(res);			
		if(res > 0){
			notification("Assignment Details Saved", 'success');			
		}else{
			notification("Error Saving Assignment Details", 'danger');
		}
	});  
	                		
});	