var passData;
var failData;

function getPassFailData(testcase_id)
{
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
	
	console.log(passData);
	console.log(failData);
}

window.onload = function (event) {
	getPassFailData(16);
}