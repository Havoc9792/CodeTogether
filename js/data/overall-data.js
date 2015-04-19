var testcases = [];

function getPassFailData(testcase_id){
	$.ajax({  
		type : "post",  
		url : "/apiv2/get-overall-data.php",  
		data : "testcase_id=" + testcase_id + "&assignment_id=" + assignment_id,  
		async : false,  
		success : function(res){
			var overallData = $.parseJSON(res);
			var passData = $.parseJSON(overallData['pass']);
			var failData = $.parseJSON(overallData['fail']);
			var attemptData = $.parseJSON(overallData['attempt']);
			
			var temp = $.parseJSON(overallData['groupno']);
			var groupno = temp['groupno'];
			var passno = passData.length;
			var attemptToPass = 0;
			for (i=0; i< failData.length; i++){
				attemptToPass += parseInt(failData[i]['fail']);
			}
			var avgAttemptToPass = attemptToPass/failData.length;
			var attempt = 0;
			for (i=0; i< attemptData.length; i++){
				attempt += parseInt(attemptData[i]['attempt']);
			}
			var avgAttempt = attempt/attemptData.length;
			
			$("#pass").html(passno + " out of " + groupno + " (" + passno/groupno*100 + "%)");
			$("#attempt").html(avgAttempt);
			$("#attempttopass").html(avgAttemptToPass);
			
			
		}  
	}); 
}

function showData (testcase_id){
	function count_function(d){return d[1][0];}
    
    function label_function(d){return d[2]+": "+d[4][0];}
    
    function legend_function(d){return "<h2>"+d[2]+"&nbsp;</h2><p><h4>"+d[4][0]}
    
    var color = d3.scale.category20c();

    function color_function(d){return color(d[2]);}
	
    d3.select(self.frameElement).style("height", "800px");
	
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
		getPassFailData($(this).val());
	});
}