$(function(){
	$("a.btn").click(function(){
		$(".overlay2").fadeIn();
		var input = $("input").val();
		//alert(assignment_id);
		$.getJSON("/datamining/", {input: input, assignment_id: assignment_id}, function(res){
			console.log(res);
			//$(".overlay2").fadeOut();
			var content = "";
			for(var i=0; i<res.length; i++){
				content += "Label: " + res[i][0] + "<br />";
				content += "Probability: " + res[i][1] + "<br /><br />";		
			}			
			$(".pro").html(content);
			console.log(content, res);
			
		});
	});
});