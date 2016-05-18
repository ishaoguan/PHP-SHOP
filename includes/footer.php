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

	//This function is called when you click the details button of a product (using onclick="detailsmodal()") and it has 1 parameter of "id" which is set with the onclick attribute by using the $product['id'] variable which is acquired through querying the database
	function detailsmodal(id){
		//Store the current ID thats been passed through as a paramenter in a JSON Object (The curly braces and the colon are characteristics of a JSON)
		var data = {"id" : id};
		jQuery.ajax({
			url : '/phpEcommerce/includes/detailsmodal.php',
			method : "post",
			data: data,
			success : function(data){
				//Upon success of the ajax, the data is added at the bottom of the body
				$('body').append(data);

				//Open the modal. the .modal() function is a bootstrap.js function
				$('#details-modal').modal('toggle');
			},
			error : function(){
				alert("Something went wrong!");
			}
		});
	}

	function add_to_cart(){
		//clear out any existing errors
		jQuery('#modal_errors').html("");
		//grab form input values for validation
		var size = jQuery('#size').val();
		var quantity = jQuery('#quantity').val();
		var available = jQuery('#available').val();
		var error = '';
		//serialize the add product form aka put it into a GET format e.g. size=30&quantity=3
		//the data will be sent off via POST in the ajax method below
		var data = jQuery('#add_product_form').serialize();
		if(size == '' || quantity == '' || quantity == 0) {
			error += '<p class="text-danger text-center">You must choose a size and quantity</p>';
			$('#modal_errors').html(error);
			return;
		}else if(quantity > available){
			error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
			$('#modal_errors').html(error);
			return;
		}else{
			jQuery.ajax({
				url : '/phpEcommerce/admin/parsers/add_cart.php',
				method : 'post',
				data : data,
				success : function(){
					location.reload();
				},
				error : function(){alert("Something went wrong");}
			});
		}
	}
</script>
</body>
</html>