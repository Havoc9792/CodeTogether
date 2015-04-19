$(function(){
	$("a.btn").click(function(){
		$(".overlay2").fadeIn();
		var input = $("input").val();
		$.getJSON("http://fyp2.mylife.hk/datamining/", {input: input}, function(res){
			var content = "";
			for(var i=0; i<res.length; i++){
				content += "Label: " + res[i][0] + "<br />";
				content += "Probability: " + res[i][1] + "<br /><br />";		
			}			
			$(".pro").html(content);
			console.log(content, res);
			$(".overlay2").fadeOut();
		});
	});
});