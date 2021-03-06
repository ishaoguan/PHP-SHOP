</div> <!--end container-fluid-->

	<footer class="text-center" id="footer">&copy; Copyright 2016 - Design by <a href="http://www.joerushton.com">joerushton</a></footer>

<script>
	// This function is called when an administrator selects the sizes/quantities of the product their adding
	function updateSizes(){
		//declare the size/quantity string
		var sizeString = '';

		//iterate through the values 12 times for all 12 fields and take the value from each field and concatenate it to the sizestring.
		for(var i=1;i<=12;i++){
			//if size field is not empty..
			if(jQuery('#size'+i).val() != ''){
				//the id's of each text field was generated by giving it the name of either size/quantity and the number of the iteration.
				sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
			}
		}
		jQuery('#sizes').val(sizeString);
	}

	function get_child_options(selected){

		// The if typeof selected is essentially just setting the default value of var selected
		// same as saying if (!isset($selected)) in php
		if (typeof selected === 'undefined'){
			var selected = '';
		}
		var parentID = jQuery('#parent').val();
		jQuery.ajax({
			url: '/PHP-SHOP/admin/parsers/child_categories.php',
			type: 'POST',
			data: {parentID : parentID, selected : selected},
			success: function(data){
				//the (data) here is whatever is returned from the url: ''
				//the data in this case is the buffer from child_categories.php as that is the URL set above and where the parentID is sent via POST (type: POST above)
				jQuery('#child').html(data);
			},
			error: function(){alert("Something went wrong with the child options");}
		});
	}
	//Listener ~ listens for <select name="parent"> to change and then fires the function "get_child_options()"
	jQuery('select[name="parent"]').change(function(){
		get_child_options();
	});
</script>	
</body>
</html>