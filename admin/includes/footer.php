</div> <!--end container-fluid-->

	<footer class="text-center" id="footer">&copy; Copyright 2016 - Design by <a href="http://www.joerushton.com">joerushton</a></footer>

<script>
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

	function get_child_options(){
		var parentID = jQuery('#parent').val();
		jQuery.ajax({
			url: '/phpEcommerce/admin/parsers/child_categories.php',
			type: 'POST',
			data: {parentID : parentID},
			success: function(data){
				//sent the data object to the html with the id of child.
				//the data in this case is the buffer from child_categories.php as that is the URL set above and where the parentID is sent via POST (type: POST above)
				jQuery('#child').html(data);
			},
			error: function(){alert("Something went wrong with the child options");}
		});
	}
	jQuery('select[name="parent"]').change(get_child_options);
</script>	
</body>
</html>