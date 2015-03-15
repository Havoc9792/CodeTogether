var passData;
var failData;
var testcases = [];

function getPassFailData(testcase_id){
	$.ajax({  
		type : "post",  
		url : "/apiv2/get-pass-data.php",  
		data : "testcase_id=" + testcase_id,  
		async : false,  
		success : function(res){
			passData = $.parseJSON(res);
		}  
	}); 
	
	
	$.ajax({  
		type : "post",  
		url : "/apiv2/get-fail-data.php",  
		data : "testcase_id=" + testcase_id,  
		async : false,  
		success : function(res){
			failData = $.parseJSON(res);
		}  
	});
}

function showData (testcase_id){
	$("#input").html(testcases[testcase_id]["input"]);
	$("#output").html(testcases[testcase_id]["output"]);
	$("#type").html(testcases[testcase_id]["type"]);
	$("#desc").html(testcases[testcase_id]["description"]);
}

window.onload = function (event) {
	$.ajax({  
		type : "post",  
		url : "/apiv2/get-testcase.php",  
		data : "assignment_id=" + assignment_id,  
		async : false,  
		success : function(res){
			console.log(res);
			rawData = $.parseJSON(res);
		}  
	});
	
	$.each(rawData, function(i, item){
		testcases[item["testcase_id"]] = item;
		if (i == 0) {
			getPassFailData(item["testcase_id"]);
			showData (item["testcase_id"]);
		}
		$("#selecttestcase").append("<option value="+item["testcase_id"]+">Testcase "+(i+1)+"</option>" );
	});
	
	$("#selecttestcase").change(function() {
		showData($(this).val());
	});
}