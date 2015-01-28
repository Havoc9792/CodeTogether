$(".ace_editor").each(function(){
	var id = $(this).attr("id");
	var editor = ace.edit(id);		   
	editor.setTheme("ace/theme/monokai");	
	editor.getSession().setMode("ace/mode/java"); 
	editor.renderer.setShowGutter(false);
	editor.setShowPrintMargin(false);
	editor.setOptions({
	    readOnly: true,
	    highlightActiveLine: false,
	    highlightGutterLine: false
	});	
});

$("div.ace_editor").height($(window).height()*0.7).width("100%");
