var collabData;
var testcaseData;

function init_plots()
{
	$.ajax({  
		type : "post",  
		url : "/apiv2/get-collaboration-data.php",  
		data : "group_id=" + group_id,  
		async : false,  
		success : function(res){
			collabData = $.parseJSON(res);
		}  
	}); 
	$.ajax({  
		type : "post",  
		url : "/apiv2/get-testcase-data.php",  
		data : "group_id=" + group_id,  
		async : false,  
		success : function(res){
			testcaseData = $.parseJSON(res);
		}  
	}); 
	calculate_total();
	plot_data ("code");
}

function plot_data (datatype){
	function count_function(d){return d[1][0];}
    
    function label_function(d){return d[2]+": "+d[4][0];}
    
    function legend_function(d){return "<h2>"+d[2]+"&nbsp;</h2><p><h4>"+d[4][0]}
    
    var color = d3.scale.category20c();

    function color_function(d){return color(d[2]);}
	
    d3.select(self.frameElement).style("height", "800px");
	
	if (datatype == "communication"){
		var code_hierarchy_data = create_com_data();
	}else if (datatype == "code"){
		var code_hierarchy_data = create_code_data();
	}else if (datatype == "testcase"){
		var code_hierarchy_data = create_testcase_data();
	}
	
	d3.select("#code_hierarchy").transition().duration(500).style("opacity","0").each("end", function(){
		init_code_hierarchy_plot("code_hierarchy",code_hierarchy_data,count_function,color_function,label_function,legend_function);
		d3.select("#code_hierarchy").transition().duration(500).style("opacity","1");
	});
}

function create_com_data (){
	var hierarchy_data;
	var arr = [];
	var groupTotal = 0;
	$.each(collabData, function(i, item){
		var total = parseInt(item['text_msg_no']) + parseInt(item['voice_msg_no']) + parseInt(item['drawing_no']);
		var temp = [
						item['username'], 
						[total],
						{
							"Text Message": [
								"Text Message", 
								[item['text_msg_no']], 
								{}
							], 
							"Voice Message": [
								"Voice Message", 
								[item['voice_msg_no']], 
								{}
							], 
							"Drawing": [
								"Drawing", 
								[item['drawing_no']], 
								{}
							]
						}
					];
		arr[item['username']] = temp;
		groupTotal += total;
	});  
	hierarchy_data = ["Total Message", [groupTotal], arr];
	
	document.getElementById("title").innerHTML = "Communication";
	
	return hierarchy_data;
}

function create_testcase_data (){
	var hierarchy_data;
	var arr = [];
	var groupTotal = 0;
	$.each(testcaseData, function(i, item){
		var temp = [
						item['result'], 
						[item['compile_no']],
						{}
					];
		arr[item['result']] = temp;
		groupTotal += parseInt(item['compile_no']);
	});
	hierarchy_data = ["Total Compilation", [groupTotal], arr];
	
	document.getElementById("title").innerHTML = "Testcase";
	
	return hierarchy_data;
}

function create_code_data (){
	var hierarchy_data;
	var arr = [];
	var groupTotal = 0;
	$.each(collabData, function(i, item){
		var temp = [
						item['username'], 
						[item['code_no']],
						{}
					];
		arr[item['username']] = temp;
		groupTotal += parseInt(item['code_no']);
	});
	hierarchy_data = ["Total Code", [groupTotal], arr];
	
	document.getElementById("title").innerHTML = "Code Contribution";
	
	return hierarchy_data;
}

function calculate_total (){
	var totalCode = 0;
	var totalMessage = 0;
	var totalCompilation = 0;
	$.each(collabData, function(i, item){
		totalCode+=parseInt(item['code_no']);
		totalMessage+=parseInt(item['text_msg_no']) + parseInt(item['voice_msg_no']) + parseInt(item['drawing_no']);
	});
	$.each(testcaseData, function(i, item){
		totalCompilation+=parseInt(item['compile_no']);
	});
	var codeNo = document.getElementById("code");
	var messageNo = document.getElementById("communication");
	var compileNo = document.getElementById("testcase");
	codeNo.innerHTML = totalCode + " lines of code";
	messageNo.innerHTML = totalMessage + " messages";
	compileNo.innerHTML = totalCompilation + " compilations";
}


window.onload = init_plots;
window.onresize = init_plots;