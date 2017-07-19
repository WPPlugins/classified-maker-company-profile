jQuery(document).ready(function($)
	{



	$(function() {
		$( ".classified-maker .repatble" ).sortable();
	//$( ".items-container" ).disableSelection(); //{ handle: '.section-header' }
	});
	
	
	$(function() {
		$( "#uploaded-image-container" ).sortable({
			
			
			revert: "invalid", 
			handle: '.move',
			update: function(event, ui) {
				
				//var attach_ids = 
				var attach_ids = '';
				
				$("#uploaded-image-container .file").each(function(){
						var attach_id = $(this).attr('attach_id');
						
						attach_ids += attach_id+','; 
						
					});
					
				//alert(attach_ids);
				$('#classified_maker_com_ads_thumbs').val(attach_ids);
				
				
			}
			});
	//$( ".items-container" ).disableSelection(); //{ handle: '.section-header' }
	});	



		$(document).on('click', '.classified-maker .add-field', function()
			{	
			
				var option_id = $(this).attr('option-id');
				
				var id = $.now();

				var html = '<div class="single"><input type="text" name="'+option_id+'['+id+']" value="" /><input class="remove-field" type="button" value="Remove"></div>';
				//alert(html);
					$(this).prev('.repatble').append(html);
					
					
				})

		$(document).on('click', '.classified-maker .remove-field', function()
			{	
				if(confirm("Do you really want to remove ?")){
					$(this).prev().remove();
					$(this).remove();
					}

				
					
					
				})

	});	







