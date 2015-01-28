var shareJSConnect = function(editor, group_id, is_textarea){
    var connection = sharejs.open(group_id, 'text', 'http://fyp.mylife.hk:443/channel', function(error, doc) {
        if(error){
            console.log(error);
        }else{
            if(typeof is_textarea !== "undefined"){
                doc.attach_textarea(editor);
            }else{
                doc.attach_ace(editor);
                var code = editor.getValue();
                if(code == ""){
	                /*
                    $.get("code/test/test.java", function(code){
                        editor.setValue(code);
                    });
                    */
                }
            }
            //loader('off');
        }
    });
};

var shareJsInit = function(group_id, editor_id){
	var editor = ace.edit(editor_id);
	editor.setTheme("ace/theme/monokai");
	editor.getSession().setMode("ace/mode/java");
	editor.setShowPrintMargin(false);	
	shareJSConnect(editor, "code-group-"+group_id+"-"+editor_id);
};

$(".ace_editor").each(function(){
	var id = $(this).attr("id");
	shareJsInit(group_id, id);
});

var terminalOutput = function(output, isReset){
    if(typeof isReset !== "undefined"){
        window.terminalOutputValue = "";
    }
    window.terminalOutputValue += output + "\n";
    terminal.setValue(window.terminalOutputValue, 1);
}

/*
var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");
editor.getSession().setMode("ace/mode/java");
editor.setShowPrintMargin(false);

var editor1 = ace.edit("editor1");
editor1.setTheme("ace/theme/monokai");
editor1.getSession().setMode("ace/mode/java");
editor1.setShowPrintMargin(false);

var editor2 = ace.edit("editor2");
editor2.setTheme("ace/theme/monokai");
editor2.getSession().setMode("ace/mode/java");
editor2.setShowPrintMargin(false);
*/

var terminal = ace.edit("terminal");
terminal.setTheme("ace/theme/monokai");
terminal.getSession().setMode("ace/mode/java");
terminal.setShowPrintMargin(false);
terminal.renderer.setShowGutter(false);
terminal.setOptions({
    readOnly: true,
    highlightActiveLine: false,
    highlightGutterLine: false
});
//terminal.renderer.$cursorLayer.element.style.opacity=0
terminal.textInput.getElement().tabIndex=-1


//shareJSConnect(editor, "code-group-"+group_id);
shareJSConnect(terminal, "terminal-group-"+group_id);
shareJSConnect($("textarea#testcase")[0], "input-group-"+group_id, true);
	
