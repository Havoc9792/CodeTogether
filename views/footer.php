            <!-- START FOOTER -->
            <div class="container-fluid container-fixed-lg footer">
                <div class="copyright sm-text-center">
                    <p class="small no-margin pull-left sm-pull-reset">
                        <span class="hint-text">Copyright © 2014-<?= date("Y") ?></span>
                        <span class="font-montserrat"><?= $config['sitename'] ?></span>.
                        <span class="hint-text">All rights reserved.</span>
                        <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
                        </span>
                    </p>
                    <p class="small no-margin pull-right sm-pull-reset">                        
                        <span class="hint-text">Made with Love by <?= $config['author'] ?></span>
                    </p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->

    <!-- START OVERLAY -->
    <div class="overlay no-padding" style="display: none" data-pages="search">
      <!-- BEGIN Overlay Content !-->
      <div class="row" style="height: auto">
	      <div class="col-xs-10">
		      <h3 class="p-l-10">Java Documentation Search <small>by Oracle</small></h3>
	      </div>
	      <div class="col-xs-2">
			  <p class="pull-right m-t-20">Press Esc to exit <a href="#" id="overlay-exit"><i class="fa fa-times"></i></a></p>
	      </div>
      </div>
      <div id="doc" class="overlay-content has-results full-height no-margin no-padding">

	  		

      </div>
      <!-- END Overlay Content !-->
    </div>
    <!-- END OVERLAY -->

    
    
    <!-- BEGIN VENDOR JS -->
    <script src="/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
	<script src="/assets/plugins/d3/d3.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/jquery-bez/jquery.bez.min.js"></script>
    <script src="/assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="/assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/bootstrap-select2/select2.min.js"></script>
    <script src="/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/dropzone/dropzone.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js"></script>
    
	<script src="/js/ace/ace.js"></script>
	<script src="/js/ace/ace.java.js"></script>
	<script src="/js/ace/ace.theme.js"></script>    
    
    <!-- END VENDOR JS -->

    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="/pages/js/pages.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->

    <!-- BEGIN PAGE LEVEL JS -->
    <script src="/assets/js/scripts.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
        
	<script>
    var group_id = <?= isset($assignment['group_id']) ? $assignment['group_id'] : ( isset($group_id) ? $group_id : 0 )  ?>;
    var assignment_id = <?= isset($assignment) ? $assignment['assignment_id'] : 0 ?>;

    var user_name = "<?= user::authService()['user_name'] ?>";
    var user_id = <?= user::authService()['user_id'] ?>;
    var user_avatar = "<?= user::avatar() ?>";				
	</script>        
        
	<script>	
	var notification = function(msg, type){
		if(typeof type === undefined){
			type = 'info';
		}
		$('body').pgNotification({
			message: msg,
			style: "bar",
			position: "top",
			type: type,
			onClose: function(){},				
		}).show();
	};	
	
	$("iframe.pdf").height($(window).height()*0.8);
	</script>    
    <?php
	if(isset($config['script'])){
		foreach($config['script'] as $script){
			?>
			<script src="/js/<?= $script ?>.js" type="text/javascript"></script>
			<?php
		}
	}
	
	if(isset($config['assignment_do'])){
		?>
		
			
		<script src="https://cdn.socket.io/socket.io-1.2.1.js"></script>
		<script src="http://intridea.github.io/sketch.js/lib/sketch.min.js"></script>
		<script src="http://cdn.peerjs.com/0.3/peer.js"></script>
	
		<script src="/js/assignment-do/data.js"></script>
		<script src="http://fyp.mylife.hk:443/channel/bcsocket.js"></script>
		<script src="http://fyp.mylife.hk:443/share/share.uncompressed.js"></script>
		<script src="http://fyp.mylife.hk:443/share/ace.js"></script>
		<script src="http://fyp.mylife.hk:443/share/json.js"></script>
		<script src="http://fyp.mylife.hk:443/share/textarea.js"></script>		
		
		<script src="/js/assignment-do/sharejs.js"></script>
		
		<script src="/js/assignment-do/socket.js"></script>		
		
		<script src="/js/assignment-do/ui.js"></script>
		<script src="/js/assignment-do/app.js"></script>
		
		<script src="/js/assignment-do/recorderjs/recorder.js"></script>
		<script src="/js/assignment-do/drawing.js"></script>
		<script src="/js/assignment-do/chat.js"></script>
		<script src="/js/assignment-do/videochat.js"></script>
			
		<script src="/js/assignment-do/history.js"></script>
		
		<script src="http://blog.apps.npr.org/pym.js/dist/pym.min.js"></script>	
			

		<script>
		var pymParent = new pym.Parent('doc', 'https://docs.oracle.com/javase/8/docs/api/index.html', { xdomain: 'docs.oracle.com' });				
		</script>
				
		
		<?php
	}
	?>
</body>
</html>