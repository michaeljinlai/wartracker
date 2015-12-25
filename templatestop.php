          </div>	
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

<!-- Sidebar Toggle -->
<script>
  	$(document).ready(function() {
    	$('#hamburger-open').on("click", function(e) {
      		$('#sidebar-open').toggleClass('hide');
      		$('#sidebar-close').toggleClass('hide');
      		$('#hamburger-open').toggleClass('hide');
      		$('#hamburger-close').toggleClass('hide');
      		$('body').toggleClass('sidebar-toggle');
      		document.cookie = "sidebar=close";
    	});
  	});

  	$(document).ready(function() {
    	$('#hamburger-close').on("click", function(e) {
      		$('#sidebar-open').toggleClass('hide');
      		$('#sidebar-close').toggleClass('hide');
      		$('#hamburger-open').toggleClass('hide');
      		$('#hamburger-close').toggleClass('hide');
      		$('body').toggleClass('sidebar-toggle');
      		document.cookie = "sidebar=open";
    	});
  	});
  	function getCookie(cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0; i<ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1);
	        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	    }
	    return "";
	}
	$(document).ready(function(){
	    if (getCookie("sidebar")=="close") {
	    	$('#hamburger-close').click();
	    	document.cookie = "sidebar=close";
	    }    
	});
</script>















