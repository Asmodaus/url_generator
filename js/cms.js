	    
				 function select(level,val,selector )
				 {
					 $.ajax({
								  type: "GET",
								  url: '/ajax/select'+'?level='+level+'&vsl='+val,
								  dataType: 'html', 
								   cache:false,
								   contentType: false,
								   processData: false,
								 
								  success: function(data)
								  {
										$(selector).val(data); 
								  }
					   });
				 }
				  

				 function copy(selector)
				 {
					$(selector).select();
					document.execCommand('copy');
				 }
			 