</div> <!--end container-fluid-->

	<footer class="text-center" id="footer">&copy; Copyright 2016 - Design by <a href="http://www.joerushton.com">joerushton</a></footer>

	

<script>
	$(window).scroll(function(){
		
		//Paralax LOGO
		var vscroll = $(this).scrollTop();
		jQuery('#logotext').css({
			//Setting the Y position of the image by using translate and the variable above
			"transform" : "translate(0px, "+ vscroll/2 +"px)"
		});

		//Paralax BACKFLOWER
		var vscroll = $(this).scrollTop();
		jQuery('#back-flower').css({
			//Setting the Y position of the image by using translate and the variable above
			"transform" : "translate(" + vscroll/5 + "px, -" + vscroll/12 + "px)"
		});

		//Paralax FRONTFLOWER
		var vscroll = $(this).scrollTop();
		jQuery('#fore-flower').css({
			//Setting the Y position of the image by using translate and the variable above
			"transform" : "translate(0px, -"+ vscroll/2 +"px)"
		});
	})
</script>
</body>
</html>