$.getJSON("/apiv2.1/testcase/"+assignment_id+"/", function(res){
	$.each(res, function(i, data){
		console.log(data);
		newTestcase(data.input, data.output, data.type, data.description);
	})
});


var newTestcase = function(input, output, type, comment){
	$("div.testcase-template").clone().appendTo('form#testcase').fadeIn();	
	$("div.testcase-template", "form#testcase").removeClass('testcase-template').addClass('testcase')
	
	if(typeof input !== 'undefined'){
		$("div.testcase input[name=input]").last().val(input);
		$("div.testcase input[name=output]").last().val(output);
		$("div.testcase textarea").last().val(comment);
		$("div.testcase select").last().val(type);		
	}
	
	$("div.testcase select").last().select2();
}

$("a#add-testcase").click(function(){
	newTestcase();
});

$(document).on("change", "form#testcase div.testcase select", function(){
	var type = $(this).val();
	var parent = $(this).parent().parent().parent().parent().parent();
	$(".panel-title", parent).text(type + " Test");
});

$(document).on("change", "form#testcase div.testcase input[name=input]", function(){
	if($(this).val() == ""){
		return;
	}
	notification("Getting Expected Output");
	var input = $(this).val();
	var parent = $(this).parent().parent().parent().parent().parent();
	$("input[name=output]", parent).val("Getting Expected Output");
	$.getJSON("/apiv2.1/compileAndRun/"+ assignment_id +"/"+ input +"/", function(res){
		console.log(res, res.result, res.content);
		if(res.result == "success"){
			var output = res.content;			
			$("input[name=output]", parent).val(output);
			notification("Expected Output Generated", 'success');
		}
	});
});

$(document).on("click", "form#testcase div.testcase #delete", function(){
	var input = $(this).val();
	var parent = $(this).parent().parent().parent();
	parent.remove();
});


$("a#save-testcase").click(function(){
	var data = [];
	var die = false;
	$("div.testcase", "form#testcase").each(function(){
		
		var input = $("input[name=input]", $(this)).val();
		var output = $("input[name=output]", $(this)).val();
		var type = $("select", $(this)).val();
		var comment = $("textarea", $(this)).val();				
		
		if(input == "" || output == "" || type == "" || comment == ""){
			notification("Please fill in all items", 'danger');
			die = true;
			return false;
		}
		
		if(output == "Getting Expected Output"){
			notification("Please wait for expected output generation", 'danger');
			die = true;
			return false;
		}		
		
		data.push({input: input, output: output, type: type, comment: comment});
				
	});
	
	console.log(die);
	
	if(die){
		return;
	}
	
	$.post("/apiv2.1/testcase/"+assignment_id+"/save/", {data: data}, function(res){
		console.log(res);
		if(res == 1){
			notification("Testcase saved, please wait for redirection", 'success');
			setTimeout(function(){
				window.location.reload();
			}, 1000);			
		}
	});
});