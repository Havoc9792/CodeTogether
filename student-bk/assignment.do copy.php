<html>
  <head>
  	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/style/style.css" rel="stylesheet" type="text/css">
    <title>FYP Code editor</title>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  </head>

  <body>

    <div id="editor">	    
		<textarea style="display: none"></textarea>
    </div>
    
    <div id="result">
    
    </div>
    
    <div id="submit">
    	<p id="status"></p>
    	<button class="btn btn-primary">Run</button>
    </div>
    
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="/js/ace/ace.js"></script>
    <script src="/js/ace/ace.java.js"></script>
    <script src="/js/ace/ace.theme.js"></script>
    
    <script src="http://fyp.mylife.hk:443/channel/bcsocket.js"></script>
	<script src="http://fyp.mylife.hk:443/share/share.uncompressed.js"></script>
	<script src="http://fyp.mylife.hk:443/share/ace.js"></script>   
	<script src="http://fyp.mylife.hk:443/share/json.js"></script>  
    <script>        	
    
    	$(function(){
	    	
			var connection = sharejs.open('blag', 'text', 'http://fyp.mylife.hk:443/channel', function(error, doc) {
				if(error){
					console.log(error);
				}else{									
					doc.attach_ace(editor);
					var code = editor.getValue();    			    		
					if(code == ""){
						$.get("code/test/test.java", function(code){	
				    		editor.setValue(code);	    		
						});					
					}						  										
				}
			});		    	

			// *** Connection status display
			var status = $("#status")[0];
			var register = function(state, klass, text) {
				connection.on(state, function() {
					status.className = klass;
					status.innerHTML = text;
				});
			};			
			register('ok', 'success', 'Online');
			register('connecting', 'warning', 'Connecting...');
			register('disconnected', 'danger', 'Offline');
			register('stopped', 'danger', 'Error');	    	
	    	
		    var editor = ace.edit("editor");		   
		    editor.setTheme("ace/theme/monokai");
		    editor.getSession().setMode("ace/mode/java");  		    		    		    				
				  
		    
		    $("button", "#submit").click(function(){
		    	$("#result").html("Compiling<br />");	    	
			   	var code = editor.getValue();		   	
			   	$.post("api/submit-code.php", {code: code, folder: 'test'}, function(res){
			   		//console.log(res);
			   		if(res == 1){			   		
					   	$.post("api/compile-code.php", {folder: 'test'}, function(res){
					   		if(res == 1){
						   		res = "Compile Success<br />";
						   		$("#result").append(res);	
						   		$.post("api/run-code.php", {folder: 'test'}, function(res){					   			
						   			console.log(res);
						   			$("#result").append("Result:<br />=========================<br />");	
						   			$("#result").append(res);
						   		});
					   		}else{
						   		$("#result").append(res);
					   		}				   				   		
					   	});				   		
			   		}
			   	});	   	
		    });			    	
	    	
    	});      	    
	        	
    </script>
  </body>
</html>
