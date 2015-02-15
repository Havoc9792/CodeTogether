$(document).delegate('textarea', 'keydown', function(e) {
  var keyCode = e.keyCode || e.which;

  if (keyCode == 9) {
    e.preventDefault();
    var start = $(this).get(0).selectionStart;
    var end = $(this).get(0).selectionEnd;

    // set textarea value to: text before caret + tab + text after caret
    $(this).val($(this).val().substring(0, start)
                + "\t"
                + $(this).val().substring(end));

    // put caret at right position again
    $(this).get(0).selectionStart =
    $(this).get(0).selectionEnd = start + 1;
  }
});	

var panel = function(type){
	var far_width = (reference_width_right + 10 ) * -1;
	$(".panel-active").animate({right: far_width}, 'fast', function(){
		$(this).removeClass('panel-active');
		$("#"+type, "#right").delay('fast').animate({right: 0}, 'fast').addClass('panel-active');
	});		
};


var window_height = $(window).height();
var reference_height = $(window).height() - 60 - 39;
var reference_width_left = $("#left").width();
var reference_width_right = $("#right").width();

$("#editor, #editor1,#editor2,#drawing canvas, #question iframe").height(reference_height);

$("#terminal").height(reference_height * 0.5);
$("textarea#testcase").height(reference_height * 0.3);
$("#terminal, textarea#testcase").width(reference_width_right);

$("iframe", "#quickview-question").width(reference_width_right).height(window_height);

$("#quickview").width(reference_width_right).height(reference_height + 39);

$("canvas", "#quickview-draw")[0].height = reference_height;
$("canvas", "#quickview-draw")[0].width = reference_width_right;

$(".col-sm-8", "div.row").animate({width: '66.66666667%' }).attr('location', 'min');

var newEditorStyle = function(){
	$(".ace_editor", "#left").height(reference_height);
};

newEditorStyle();

$("a#add-editor").click(function(){
	$.post("/apiv2/add-editor.php", {group_id: group_id}, function(res){
		console.log(res);
		if(res == 1){
			socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'reload'}); 
			window.location.reload();
		}else{
			alert("Error adding new tab");
		}
	});
});

$("i.delete-tab").click(function(){
	var editor_id = $(this).attr('data-id');
	if(confirm("Are you sure to delete this tab?")){
		$.post("/apiv2.1/editor/delete/"+editor_id+"/", function(res){
			
			if(res == 1){
				socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'reload'});
				window.location.reload();				
			}else{
				alert("Error Deleting Tab");
			}
		});
	}else{
		
	}
});