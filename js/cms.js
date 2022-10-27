	    
				 function select(table,val,selector )
				 {
					
					 $.ajax({
								  type: "GET",
								  url: '/ajax/select'+'?table='+table+'&val='+val,
								  dataType: 'html', 
								   cache:false,
								   contentType: false,
								   processData: false,
								 
								  success: function(data)
								  {
										$(selector).html(data); 
										$(selector).trigger('change');
										/*
										if ($(selector+" > option").size()>0)
										{ 
											
										} 
										*/
								  }
					   });

					   if (table=='template')
					   {
						$.ajax({
										type: "GET",
										url: '/ajax/button_select'+'?table='+table+'&val='+val,
										dataType: 'html', 
										cache:false,
										contentType: false,
										processData: false,
									
										success: function(data)
										{
											$('#buttons_'+selector.slice(1)).html(data);  
										}
							});
					   }
				 }
				  
				function set_result_link()
				{
					$.ajax({
							type: "GET",
							url: '/ajax/set_result_link'+'?parent_id='+$('#form_parent_id').val()+'&value='+$('#form_value').val()+'&type='+$('#form_type').val(),
							dataType: 'html', 
							cache:false,
							contentType: false,
							processData: false,
						
							success: function(data)
							{
								$('#result_link').val(data);  
							 
							}
				});
				}