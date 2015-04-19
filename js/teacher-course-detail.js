$("a#new-assignment").click(function(){
	$.post("/apiv2.1/assignment/", {course_id: course_id},function(res){
		console.log(res);
		if(res > 0){
			notification("New assignment created, please wait for redirection", 'success');
			$.post("/apiv2/create-group.php", {a_id: res, num: 3}, function(r){
				setTimeout(function(){
					window.location = "/assignment/edit/"+res+"/";
				}, 1000);				
			});
						
		}
	});
});