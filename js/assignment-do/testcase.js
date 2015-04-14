//Testcase UI
var testcase_ui_loading = '<i class="fa fa-circle-o-notch fa-spin info"></i>';
var testcase_ui_success = '<i class="fa fa-check-circle success"></i>';
var testcase_ui_warning = '<i class="fa fa-exclamation-triangle warning"></i>';
var testcase_ui_error = '<i class="fa fa-times-circle danger"></i>';

//Testcase container
var testcase_container = $("#testcase-anly-content");

//Function to change all indicator to loading
var testcase_ui_load_all = function(){	
	socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'testcase_ui_load_all'});
	$('table tbody tr', testcase_container).each(function(i, item){
		$(".indicator", item).html(testcase_ui_loading);		
	});
}

//Function to change one indicator with id to type
//eg. testcase_ui_change_to(3, testcase_ui_error)
var testcase_ui_change_to = function(id, type){									
	socket.emit("msg", {group_id: group_id, user_name: user_name, user_id: user_id, action: 'testcase_ui_change_to', param:{testcase_id: id, testcase_type: type}});
	$('table tbody tr[data-testcase-id='+id+'] .indicator', testcase_container).html(type);				
}


